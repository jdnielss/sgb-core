<?php

namespace App\Filament\Resources\MemberRejoinRequestResource\Pages;

use App\Filament\Resources\MemberRejoinRequestResource;
use Filament\Resources\Pages\EditRecord;

class EditMemberRejoinRequest extends EditRecord
{
    protected static string $resource = MemberRejoinRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
