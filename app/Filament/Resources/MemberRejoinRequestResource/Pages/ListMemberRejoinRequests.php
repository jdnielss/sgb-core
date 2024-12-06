<?php

namespace App\Filament\Resources\MemberRejoinRequestResource\Pages;

use App\Filament\Resources\MemberRejoinRequestResource;
use Filament\Resources\Pages\ListRecords;

class ListMemberRejoinRequests extends ListRecords
{
    protected static string $resource = MemberRejoinRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
