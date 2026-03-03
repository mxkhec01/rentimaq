<?php

namespace App\Filament\Resources\EmailContacts;

use App\Filament\Resources\EmailContacts\Pages\CreateEmailContact;
use App\Filament\Resources\EmailContacts\Pages\EditEmailContact;
use App\Filament\Resources\EmailContacts\Pages\ListEmailContacts;
use App\Models\EmailContact;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class EmailContactResource extends Resource
{
    protected static ?string $model = EmailContact::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-envelope';

    protected static \UnitEnum|string|null $navigationGroup = 'Configuración';

    protected static ?string $modelLabel = 'Destinatario de Correo';

    protected static ?string $pluralModelLabel = 'Destinatarios de Correo';

    protected static ?string $recordTitleAttribute = 'nombre';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nombre')
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                Toggle::make('recibe_facturacion')
                    ->label('Facturación')
                    ->helperText('Recibe notificaciones de solicitudes de facturación'),
                Toggle::make('recibe_cotizacion')
                    ->label('Cotizaciones')
                    ->helperText('Recibe notificaciones de solicitudes de cotización'),
                Toggle::make('recibe_contacto')
                    ->label('Contacto General')
                    ->helperText('Recibe notificaciones de formulario de contacto'),
                Toggle::make('activo')
                    ->label('Activo')
                    ->default(true)
                    ->helperText('Desactivar para pausar el envío sin eliminar el registro'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nombre')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->icon('heroicon-m-envelope')
                    ->copyable()
                    ->searchable(),
                IconColumn::make('recibe_facturacion')
                    ->label('Facturación')
                    ->boolean(),
                IconColumn::make('recibe_cotizacion')
                    ->label('Cotizaciones')
                    ->boolean(),
                IconColumn::make('recibe_contacto')
                    ->label('Contacto')
                    ->boolean(),
                IconColumn::make('activo')
                    ->label('Activo')
                    ->boolean(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListEmailContacts::route('/'),
            'create' => CreateEmailContact::route('/create'),
            'edit' => EditEmailContact::route('/{record}/edit'),
        ];
    }
}
