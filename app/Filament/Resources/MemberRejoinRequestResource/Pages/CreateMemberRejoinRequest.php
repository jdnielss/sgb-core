<?php

namespace App\Filament\Resources\MemberRejoinRequestResource\Pages;

use App\Filament\Resources\MemberRejoinRequestResource;
use Filament\Resources\Pages\CreateRecord;

class CreateMemberRejoinRequest extends CreateRecord
{
    protected static string $resource = MemberRejoinRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

    protected function getFormActions(): array
    {
        return [];
    }
}
