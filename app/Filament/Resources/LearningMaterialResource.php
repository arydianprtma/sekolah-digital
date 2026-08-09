<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LearningMaterialResource\Pages;
use App\Filament\Traits\HasRoleVisibility;
use App\Models\LearningMaterial;
use Filament\Actions;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class LearningMaterialResource extends Resource
{
    use HasRoleVisibility;

    protected static array $allowedRoles = ['admin', 'guru', 'siswa'];

    protected static ?string $model = LearningMaterial::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-book-open';

    protected static \UnitEnum|string|null $navigationGroup = 'E-Learning & Konten';

    protected static ?string $navigationLabel = 'Materi Belajar';

    protected static ?string $modelLabel = 'Materi';

    protected static ?string $pluralModelLabel = 'Materi Belajar';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $form): Schema
    {
        return $form->schema([
            Forms\Components\Select::make('subject_id')
                ->label('Mata Pelajaran')
                ->relationship('subject', 'nama_mapel')
                ->required(),

            Forms\Components\Select::make('classroom_id')
                ->label('Kelas')
                ->relationship('classroom', 'nama_kelas')
                ->required(),

            Forms\Components\Select::make('teacher_id')
                ->label('Guru')
                ->relationship('teacher', 'name'),

            Forms\Components\TextInput::make('judul')
                ->label('Judul Materi')
                ->required(),

            Forms\Components\RichEditor::make('deskripsi')
                ->label('Deskripsi')
                ->fileAttachmentsDirectory('materials')
                ->columnSpanFull(),

            Forms\Components\FileUpload::make('file_path')
                ->label('Berkas Materi (Opsional)')
                ->directory('materials')
                ->downloadable(),

            Forms\Components\TextInput::make('link_external')
                ->label('Link Eksternal (Opsional)')
                ->url(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('judul')
                    ->label('Judul')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('subject.nama_mapel')
                    ->label('Mata Pelajaran'),

                Tables\Columns\TextColumn::make('classroom.nama_kelas')
                    ->label('Kelas'),

                Tables\Columns\TextColumn::make('teacher.name')
                    ->label('Guru')
                    ->default('-'),
            ])
            ->actions([
                Actions\EditAction::make(),
                Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListLearningMaterials::route('/'),
            'create' => Pages\CreateLearningMaterial::route('/create'),
            'edit'   => Pages\EditLearningMaterial::route('/{record}/edit'),
        ];
    }
}
