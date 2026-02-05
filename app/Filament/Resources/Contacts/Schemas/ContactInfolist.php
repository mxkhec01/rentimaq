<?php

namespace App\Filament\Resources\Contacts\Schemas;

use Filament\Infolists\Components\KeyValueEntry;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ContactInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Sender Details')
                    ->schema([
                        TextEntry::make('name'),
                        TextEntry::make('email')
                            ->icon('heroicon-m-envelope')
                            ->copyable(),
                        TextEntry::make('phone')
                            ->icon('heroicon-m-phone'),
                        TextEntry::make('company')
                            ->icon('heroicon-m-building-office'),
                        TextEntry::make('type')
                            ->badge()
                            ->color(fn(string $state): string => match ($state) {
                                'contact' => 'gray',
                                'quote' => 'warning',
                                'rent' => 'success',
                                default => 'gray',
                            }),
                        TextEntry::make('created_at')
                            ->dateTime(),
                    ])->columns(3),

                Section::make('Message & Data')
                    ->schema([
                        TextEntry::make('message')
                            ->columnSpanFull()
                            ->prose(),
                        TextEntry::make('metadata')
                            ->columnSpanFull()
                            ->markdown()
                            ->formatStateUsing(fn($state) => '```json' . PHP_EOL . json_encode($state, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . PHP_EOL . '```'),
                    ]),
            ]);
    }
}
