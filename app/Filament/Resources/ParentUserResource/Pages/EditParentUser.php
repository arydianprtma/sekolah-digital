<?php

namespace App\Filament\Resources\ParentUserResource\Pages;

use App\Filament\Resources\ParentUserResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditParentUser extends EditRecord
{
    protected static string $resource = ParentUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}


