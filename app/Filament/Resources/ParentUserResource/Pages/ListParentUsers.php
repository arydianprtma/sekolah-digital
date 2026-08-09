<?php

namespace App\Filament\Resources\ParentUserResource\Pages;

use App\Filament\Resources\ParentUserResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListParentUsers extends ListRecords
{
    protected static string $resource = ParentUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Tambah Pengguna Baru'),
        ];
    }
}


