<?php

namespace App\Filament\Resources\SecurityReportResource\Pages;

use App\Filament\Resources\SecurityReportResource;
use App\Models\Logging;
use Filament\Resources\Pages\CreateRecord;

class CreateSecurityReport extends CreateRecord
{
    protected static string $resource = SecurityReportResource::class;

    protected function afterCreate(): void
    {
        $user = auth()->user();

        if ($user) {
            // Log the creation of the new cash flow record
            Logging::create([
                'user_id' => $user->id, // The ID of the logged-in user
                'user_name' => $user->name ?? 'Unknown', // Safely access the name or provide a default value
                'resource' => 'security_report',
                'action' => 'create',
                'new_data' => $this->record->toArray(),
            ]);
        } else {
            // Handle the case when the user is not authenticated
            // You might want to log the action without a user name or take alternative action
            Logging::create([
                'user_id' => null,
                'user_name' => 'Guest', // Or any default name for unauthenticated users
                'resource' => 'security_report',
                'action' => 'create',
                'new_data' => $this->record->toArray(),
            ]);
        }
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
