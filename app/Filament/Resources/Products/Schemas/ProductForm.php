<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\KeyValue;
use Filament\Schemas\Components\Group;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make()
                    ->schema([
                        Section::make('Product Details')
                            ->schema([
                                TextInput::make('name')
                                    ->required()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn(Set $set, ?string $state) => $set('slug', Str::slug($state))),
                                TextInput::make('slug')
                                    ->required()
                                    ->unique(ignoreRecord: true),
                                Select::make('category')
                                    ->options([
                                        'Compactación' => 'Compactación',
                                        'Concreto' => 'Concreto',
                                        'Generación' => 'Generación',
                                        'Demolición' => 'Demolición',
                                        'Elevación' => 'Elevación',
                                        'Bombeo' => 'Bombeo',
                                        'Corte' => 'Corte',
                                    ])
                                    ->searchable()
                                    ->createOptionForm([
                                        TextInput::make('category')
                                            ->required(),
                                    ])
                                    ->createOptionUsing(fn(array $data) => $data['category']),
                                FileUpload::make('image')
                                    ->image()
                                    ->disk('public')
                                    ->visibility('public')
                                    ->directory('products')
                                    ->columnSpanFull(),
                                RichEditor::make('description')
                                    ->columnSpanFull(),
                            ])->columns(3),

                        Section::make('Technical Specs')
                            ->schema([
                                KeyValue::make('technical_specs')
                                    ->keyLabel('Property')
                                    ->valueLabel('Value'),
                            ]),
                    ])
                    ->columnSpan(2),

                Group::make()
                    ->schema([
                        Section::make('Availability')
                            ->schema([
                                Toggle::make('is_rental')
                                    ->default(true),
                                Toggle::make('is_for_sale')
                                    ->default(false),
                                Toggle::make('is_active')
                                    ->default(true),
                            ])->columns(1),
                    ])
                    ->columnSpan(1),

                Section::make('Rental Prices')
                    ->visible(fn(callable $get) => $get('is_rental'))
                    ->schema([
                        Repeater::make('rentalPrices')
                            ->relationship()
                            ->schema([
                                Select::make('rental_period_id')
                                    ->relationship('rentalPeriod', 'label')
                                    ->required(),
                                TextInput::make('price')
                                    ->numeric()
                                    ->prefix('$')
                                    ->required(),
                                TextInput::make('currency')
                                    ->default('MXN')
                                    ->required(),
                            ])
                            ->columns(3),
                    ])
                    ->columnSpanFull(),
            ])
            ->columns(3);
    }
}
