<?php

namespace App\Filament\Resources\CashFlowResource\Pages;

use App\Filament\Resources\CashFlowResource;
use App\Models\Logging;
use Filament\Resources\Pages\CreateRecord;

class CreateCashFlow extends CreateRecord
{
    protected static string $resource = CashFlowResource::class;

    protected function afterCreate(): void
    {
        $user = auth()->user();

        if ($user) {
            // Log the creation of the new cash flow record
            Logging::create([
                'user_id' => $user->id, // The ID of the logged-in user
                'user_name' => $user->name ?? 'Unknown', // Safely access the name or provide a default value
                'resource' => 'cash_flow',
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
