<?php

namespace App\Filament\Resources\SecurityReportResource\Pages;

use App\Filament\Resources\SecurityReportResource;
use App\Models\CashFlow;
use App\Models\Logging;
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

    protected function afterSave(): void
    {
        $user = auth()->user();

        if ($user) {
            // Get the old data before the update
            $oldData = CashFlow::find($this->record->id); // Fetch the old record from the database

            // Get the changes made to the record
            $changedData = $this->record->getChanges(); // Get the changes that were actually made

            Logging::create([
                'user_id' => $user->id,
                'user_name' => $user->name ?? 'Unknown',
                'resource' => 'security_report',
                'action' => $this->record->wasChanged() ? 'update' : 'create',
                'old_data' => $oldData->toArray(),
                'new_data' => $changedData
            ]);
        }
    }
}
