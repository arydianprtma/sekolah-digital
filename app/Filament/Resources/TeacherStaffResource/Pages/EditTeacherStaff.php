<?php

namespace App\Filament\Resources\TeacherStaffResource\Pages;

use App\Filament\Resources\TeacherStaffResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTeacherStaff extends EditRecord
{
    protected static string $resource = TeacherStaffResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
