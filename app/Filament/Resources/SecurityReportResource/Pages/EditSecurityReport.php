<?php

namespace App\Filament\Resources\SecurityReportResource\Pages;

use App\Filament\Resources\SecurityReportResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSecurityReport extends EditRecord
{
    protected static string $resource = SecurityReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
