<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AssignmentResource\Pages;
use App\Filament\Traits\HasRoleVisibility;
use App\Models\Assignment;
use Filament\Actions;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Filament\Resources\AssignmentResource\RelationManagers\SubmissionsRelationManager;

class AssignmentResource extends Resource
{
    use HasRoleVisibility;

    protected static array $allowedRoles = ['admin', 'guru', 'siswa'];

    protected static ?string $model = Assignment::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-document-text';

    protected static \UnitEnum|string|null $navigationGroup = 'E-Learning & Pembelajaran';

    protected static ?string $parentItem = 'Materi & Tugas';

    protected static ?string $navigationLabel = 'Tugas & Materi';

    protected static ?string $modelLabel = 'Tugas';

    protected static ?string $pluralModelLabel = 'Tugas & Materi';

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
                ->label('Guru Pengampu')
                ->relationship('teacher', 'name')
                ->default(fn () => auth()->user()?->hasRole('guru') ? auth()->id() : null)
                ->disabled(fn () => auth()->user()?->hasRole('guru'))
                ->dehydrated(),

            Forms\Components\TextInput::make('judul')
                ->label('Judul Tugas')
                ->required(),

            Forms\Components\RichEditor::make('deskripsi')
                ->label('Deskripsi / Soal Tugas')
                ->fileAttachmentsDirectory('assignments')
                ->columnSpanFull(),

            Forms\Components\DateTimePicker::make('tenggat_waktu')
                ->label('Batas Pengumpulan')
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('judul')
                    ->label('Judul Tugas')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('subject.nama_mapel')
                    ->label('Mapel'),

                Tables\Columns\TextColumn::make('classroom.nama_kelas')
                    ->label('Kelas'),

                Tables\Columns\TextColumn::make('tenggat_waktu')
                    ->label('Tenggat')
                    ->dateTime('d M Y H:i')
                    ->sortable(),

                Tables\Columns\TextColumn::make('submissions_count')
                    ->label('Pengumpulan')
                    ->counts('submissions'),
            ])
            ->actions([
                Actions\ViewAction::make(),
                Actions\EditAction::make(),
                Actions\DeleteAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            SubmissionsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListAssignments::route('/'),
            'create' => Pages\CreateAssignment::route('/create'),
            'view'   => Pages\ViewAssignment::route('/{record}'),
            'edit'   => Pages\EditAssignment::route('/{record}/edit'),
        ];
    }
}
