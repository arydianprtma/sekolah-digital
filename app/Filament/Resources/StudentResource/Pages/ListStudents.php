<?php

namespace App\Filament\Resources\StudentResource\Pages;

use App\Filament\Resources\StudentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStudents extends ListRecords
{
    protected static string $resource = StudentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->hidden(fn () => auth()->user() && auth()->user()->hasRole('guru') && !auth()->user()->hasRole('admin') && !auth()->user()->hasRole('Super Admin')),
        ];
    }
}
