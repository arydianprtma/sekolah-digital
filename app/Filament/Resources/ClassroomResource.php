<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClassroomResource\Pages;
use App\Filament\Traits\HasRoleVisibility;
use App\Models\Classroom;
use Filament\Actions;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ClassroomResource extends Resource
{
    use HasRoleVisibility;

    protected static array $allowedRoles = ['admin', 'guru', 'orang_tua'];

    protected static ?string $model = Classroom::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-building-office-2';

    protected static \UnitEnum|string|null $navigationGroup = 'Akademik & Sekolah';

    protected static ?string $navigationLabel = 'Kelas & Rombel';

    protected static ?string $modelLabel = 'Kelas';

    protected static ?string $pluralModelLabel = 'Data Kelas';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $form): Schema
    {
        return $form->schema([
            Forms\Components\TextInput::make('nama_kelas')
                ->label('Nama Kelas')
                ->required()
                ->placeholder('Contoh: X IPA 1'),

            Forms\Components\Select::make('tingkat')
                ->label('Tingkat')
                ->options([
                    'VII' => 'Kelas 7 (VII)',
                    'VIII' => 'Kelas 8 (VIII)',
                    'IX' => 'Kelas 9 (IX)',
                    'X' => 'Kelas 10 (X)',
                    'XI' => 'Kelas 11 (XI)',
                    'XII' => 'Kelas 12 (XII)',
                ])
                ->required(),

            Forms\Components\TextInput::make('jurusan')
                ->label('Jurusan')
                ->placeholder('IPA / IPS / RPL'),

            Forms\Components\Select::make('wali_kelas_id')
                ->label('Wali Kelas')
                ->relationship('waliKelas', 'name')
                ->searchable()
                ->preload(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_kelas')
                    ->label('Nama Kelas')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('tingkat')
                    ->label('Tingkat')
                    ->sortable(),

                Tables\Columns\TextColumn::make('jurusan')
                    ->label('Jurusan'),

                Tables\Columns\TextColumn::make('waliKelas.name')
                    ->label('Wali Kelas')
                    ->default('-'),

                Tables\Columns\TextColumn::make('students_count')
                    ->label('Jumlah Siswa')
                    ->counts('students'),
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
            'index'  => Pages\ListClassrooms::route('/'),
            'create' => Pages\CreateClassroom::route('/create'),
            'edit'   => Pages\EditClassroom::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        $query = parent::getEloquentQuery();
        $user = auth()->user();

        if ($user && $user->hasRole('orang_tua') && !$user->hasRole('admin') && !$user->hasRole('Super Admin')) {
            $studentIds = \App\Models\StudentParent::where('user_id', $user->id)->pluck('student_id');
            $classroomIds = \App\Models\Student::whereIn('id', $studentIds)->pluck('classroom_id');
            $query->whereIn('id', $classroomIds);
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
