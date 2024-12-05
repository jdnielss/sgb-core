<?php

namespace App\Filament\Resources\LoggingResource\Pages;

use App\Filament\Resources\LoggingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLogging extends EditRecord
{
    protected static string $resource = LoggingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
