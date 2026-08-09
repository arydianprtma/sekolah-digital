<?php

namespace App\Filament\Resources\ClassroomResource\Pages;

use App\Filament\Resources\ClassroomResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListClassrooms extends ListRecords
{
    protected static string $resource = ClassroomResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->hidden(fn () => auth()->user() && auth()->user()->hasRole('guru') && !auth()->user()->hasRole('admin') && !auth()->user()->hasRole('Super Admin')),
        ];
    }
}
