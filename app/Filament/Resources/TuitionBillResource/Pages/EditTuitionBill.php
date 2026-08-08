<?php

namespace App\Filament\Resources\TuitionBillResource\Pages;

use App\Filament\Resources\TuitionBillResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTuitionBill extends EditRecord
{
    protected static string $resource = TuitionBillResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\DeleteAction::make()];
    }
}
