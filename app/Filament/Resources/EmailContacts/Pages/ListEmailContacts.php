<?php

namespace App\Filament\Resources\EmailContacts\Pages;

use App\Filament\Resources\EmailContacts\EmailContactResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListEmailContacts extends ListRecords
{
    protected static string $resource = EmailContactResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
