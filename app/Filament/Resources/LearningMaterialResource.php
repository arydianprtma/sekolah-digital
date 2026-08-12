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
                ->relationship(
                    name: 'subject', 
                    titleAttribute: 'nama_mapel',
                    modifyQueryUsing: function (\Illuminate\Database\Eloquent\Builder $query) {
                        $user = auth()->user();
                        if ($user && $user->hasRole('guru') && !$user->hasRole('admin') && !$user->hasRole('Super Admin')) {
                            $subjectIds = \App\Models\Schedule::where('teacher_id', $user->id)->pluck('subject_id');
                            return $query->whereIn('id', $subjectIds);
                        }
                        return $query;
                    }
                )
                ->required(),

            Forms\Components\Select::make('classroom_id')
                ->label('Kelas')
                ->relationship(
                    name: 'classroom', 
                    titleAttribute: 'nama_kelas',
                    modifyQueryUsing: function (\Illuminate\Database\Eloquent\Builder $query) {
                        $user = auth()->user();
                        if ($user && $user->hasRole('guru') && !$user->hasRole('admin') && !$user->hasRole('Super Admin')) {
                            $classroomIds = \App\Models\Schedule::where('teacher_id', $user->id)->pluck('classroom_id');
                            return $query->whereIn('id', $classroomIds);
                        }
                        return $query;
                    }
                )
                ->required(),

            Forms\Components\Select::make('teacher_id')
                ->label('Guru')
                ->relationship('teacher', 'name')
                ->default(fn () => auth()->user()?->hasRole('guru') ? auth()->id() : null)
                ->disabled(fn () => auth()->user()?->hasRole('guru'))
                ->dehydrated(),

            Forms\Components\TextInput::make('judul')
                ->label('Judul Materi')
                ->required(),

            Forms\Components\RichEditor::make('deskripsi')
                ->label('Deskripsi')
                ->fileAttachmentsDirectory('materials')
                ->columnSpanFull(),

            Forms\Components\FileUpload::make('file_path')
                ->label('Berkas Materi (Opsional)')
                ->disk('public')
                ->directory('materials')
                ->downloadable()
                ->maxSize(15360)
                ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation', 'application/zip', 'image/jpeg', 'image/png']),

            Forms\Components\TextInput::make('link_external')
                ->label('Link Eksternal (Opsional)')
                ->url()
                ->suffixAction(
                    \Filament\Actions\Action::make('openLink')
                        ->icon('heroicon-m-arrow-top-right-on-square')
                        ->url(fn ($state) => $state, true)
                        ->visible(fn ($state) => filled($state))
                ),
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

                Tables\Columns\TextColumn::make('link_external')
                    ->label('Tautan')
                    ->url(fn ($record) => $record->link_external, true)
                    ->color('primary')
                    ->icon('heroicon-o-link')
                    ->formatStateUsing(fn ($state) => $state ? 'Buka Link' : '-')
                    ->toggleable(),
            ])
            ->actions([
                Actions\ViewAction::make(),
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
