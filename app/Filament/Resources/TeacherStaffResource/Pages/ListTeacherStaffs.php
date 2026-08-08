<?php

namespace App\Filament\Resources\TeacherStaffResource\Pages;

use App\Filament\Resources\TeacherStaffResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTeacherStaffs extends ListRecords
{
    protected static string $resource = TeacherStaffResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Tambah Guru / Staf Baru'),
        ];
    }
}
