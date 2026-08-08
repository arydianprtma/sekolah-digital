<?php

namespace App\Filament\Resources\CounselingRecordResource\Pages;

use App\Filament\Resources\CounselingRecordResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCounselingRecord extends EditRecord
{
    protected static string $resource = CounselingRecordResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\DeleteAction::make()];
    }
}
