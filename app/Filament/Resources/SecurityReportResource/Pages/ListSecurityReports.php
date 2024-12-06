<?php

namespace App\Filament\Resources\SecurityReportResource\Pages;

use App\Filament\Resources\SecurityReportResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSecurityReports extends ListRecords
{
    protected static string $resource = SecurityReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label("Create"),
        ];
    }
}
