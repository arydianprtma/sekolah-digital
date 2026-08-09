<?php

namespace App\Filament\Resources\LearningMaterials\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class LearningMaterialForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('subject_id')
                    ->relationship('subject', 'id')
                    ->required(),
                Select::make('classroom_id')
                    ->relationship('classroom', 'id')
                    ->required(),
                Select::make('teacher_id')
                    ->relationship('teacher', 'name'),
                TextInput::make('judul')
                    ->required(),
                Textarea::make('deskripsi')
                    ->columnSpanFull(),
                TextInput::make('file_path'),
                TextInput::make('link_external'),
            ]);
    }
}
