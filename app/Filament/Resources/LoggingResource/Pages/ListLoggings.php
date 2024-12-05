<?php

namespace App\Filament\Resources\LoggingResource\Pages;

use App\Filament\Resources\LoggingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLoggings extends ListRecords
{
    protected static string $resource = LoggingResource::class;

    protected function getHeaderActions(): array
    {
        return [
//            Actions\CreateAction::make(),
        ];
    }
}
