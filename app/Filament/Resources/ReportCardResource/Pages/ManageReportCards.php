<?php

namespace App\Filament\Resources\ReportCardResource\Pages;

use App\Filament\Resources\ReportCardResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageReportCards extends ManageRecords
{
    protected static string $resource = ReportCardResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
