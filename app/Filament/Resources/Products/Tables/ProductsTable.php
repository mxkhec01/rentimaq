<?php

namespace App\Filament\Resources\Products\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('image')
                    ->label('Imagen')
                    ->html()
                    ->formatStateUsing(function ($state) {
                        if (empty($state)) {
                            return '<div style="width: 40px; height: 40px; background-color: #f3f4f6; border-radius: 50%;"></div>';
                        }
                        $url = Str::startsWith($state, 'images/')
                            ? asset($state)
                            : Storage::url($state);
                        return '<img src="' . $url . '" style="width: 40px; height: 40px; object-fit: cover; border-radius: 50%;" />';
                    }),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('category')
                    ->searchable()
                    ->sortable(),
                IconColumn::make('is_rental')
                    ->boolean()
                    ->sortable(),
                IconColumn::make('is_for_sale')
                    ->boolean()
                    ->sortable(),
                IconColumn::make('is_active')
                    ->boolean()
                    ->sortable(),
                TextColumn::make('rental_prices_count')
                    ->counts('rentalPrices')
                    ->label('Precios'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
