<?php

namespace App\Filament\Resources\EmailContacts\Pages;

use App\Filament\Resources\EmailContacts\EmailContactResource;
use Filament\Resources\Pages\EditRecord;

class EditEmailContact extends EditRecord
{
    protected static string $resource = EmailContactResource::class;
}
