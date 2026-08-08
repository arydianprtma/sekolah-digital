<?php

namespace App\Filament\Resources\TuitionBillResource\Pages;

use App\Filament\Resources\TuitionBillResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTuitionBills extends ListRecords
{
    protected static string $resource = TuitionBillResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\CreateAction::make()];
    }
}
