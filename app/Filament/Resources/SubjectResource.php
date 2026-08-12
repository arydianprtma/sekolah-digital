<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubjectResource\Pages;
use App\Filament\Traits\HasRoleVisibility;
use App\Models\Subject;
use Filament\Actions;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SubjectResource extends Resource
{
    use HasRoleVisibility;

    protected static array $allowedRoles = ['admin', 'guru'];

    protected static ?string $model = Subject::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-book-open';

    protected static \UnitEnum|string|null $navigationGroup = 'Akademik & Sekolah';

    protected static ?string $parentItem = 'Manajemen Akademik';

    protected static ?string $navigationLabel = 'Mata Pelajaran';

    protected static ?string $modelLabel = 'Mata Pelajaran';

    protected static ?string $pluralModelLabel = 'Mata Pelajaran';

    protected static ?int $navigationSort = 4;

    public static function form(Schema $form): Schema
    {
        return $form->schema([
            Forms\Components\TextInput::make('kode_mapel')
                ->label('Kode Mapel')
                ->required()
                ->unique(ignoreRecord: true)
                ->placeholder('MTK-10'),

            Forms\Components\TextInput::make('nama_mapel')
                ->label('Nama Mata Pelajaran')
                ->required()
                ->placeholder('Matematika Wajib'),

            Forms\Components\Select::make('kelompok')
                ->label('Kelompok Mapel')
                ->options([
                    'wajib' => 'Kelompok Wajib (A/B)',
                    'peminatan' => 'Kelompok Peminatan (C)',
                    'muatan_lokal' => 'Muatan Lokal',
                ])
                ->default('wajib')
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kode_mapel')
                    ->label('Kode')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('nama_mapel')
                    ->label('Nama Mapel')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('kelompok')
                    ->label('Kelompok')
                    ->colors([
                        'primary' => 'wajib',
                        'warning' => 'peminatan',
                        'success' => 'muatan_lokal',
                    ]),

                Tables\Columns\TextColumn::make('kelas_list')
                    ->label('Kelas')
                    ->badge()
                    ->separator(', ')
                    ->getStateUsing(function ($record) {
                        $user = auth()->user();
                        if ($user && $user->hasRole('guru') && !$user->hasRole('admin') && !$user->hasRole('Super Admin')) {
                            return \App\Models\Schedule::where('subject_id', $record->id)
                                ->where('teacher_id', $user->id)
                                ->with('classroom')
                                ->get()
                                ->pluck('classroom.nama_kelas')
                                ->unique()
                                ->toArray();
                        }
                        return \App\Models\Schedule::where('subject_id', $record->id)
                            ->with('classroom')
                            ->get()
                            ->pluck('classroom.nama_kelas')
                            ->unique()
                            ->toArray();
                    }),
            ])
            ->actions([
                Actions\EditAction::make()
                    ->hidden(fn () => auth()->user() && auth()->user()->hasRole('guru') && !auth()->user()->hasRole('admin') && !auth()->user()->hasRole('Super Admin')),
                Actions\DeleteAction::make()
                    ->hidden(fn () => auth()->user() && auth()->user()->hasRole('guru') && !auth()->user()->hasRole('admin') && !auth()->user()->hasRole('Super Admin')),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListSubjects::route('/'),
            'create' => Pages\CreateSubject::route('/create'),
            'edit'   => Pages\EditSubject::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        $query = parent::getEloquentQuery();
        $user = auth()->user();

        if ($user && $user->hasRole('guru') && !$user->hasRole('admin') && !$user->hasRole('Super Admin')) {
            $subjectIds = \App\Models\Schedule::where('teacher_id', $user->id)->pluck('subject_id');
            return $query->whereIn('id', $subjectIds);
        }

        return $query;
    }

    public static function canCreate(): bool
    {
        $user = auth()->user();
        if ($user && ($user->hasRole('guru') || $user->hasRole('siswa') || $user->hasRole('orang_tua')) && !$user->hasRole('admin') && !$user->hasRole('Super Admin')) {
            return false;
        }
        return true;
    }

    public static function canEdit(\Illuminate\Database\Eloquent\Model $record): bool
    {
        $user = auth()->user();
        if ($user && ($user->hasRole('guru') || $user->hasRole('siswa') || $user->hasRole('orang_tua')) && !$user->hasRole('admin') && !$user->hasRole('Super Admin')) {
            return false;
        }
        return true;
    }

    public static function canDelete(\Illuminate\Database\Eloquent\Model $record): bool
    {
        $user = auth()->user();
        if ($user && ($user->hasRole('guru') || $user->hasRole('siswa') || $user->hasRole('orang_tua')) && !$user->hasRole('admin') && !$user->hasRole('Super Admin')) {
            return false;
        }
        return true;
    }
}
