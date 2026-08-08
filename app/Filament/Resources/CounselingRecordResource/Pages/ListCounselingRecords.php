<?php

namespace App\Filament\Resources\CounselingRecordResource\Pages;

use App\Filament\Resources\CounselingRecordResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCounselingRecords extends ListRecords
{
    protected static string $resource = CounselingRecordResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\CreateAction::make()];
    }
}
