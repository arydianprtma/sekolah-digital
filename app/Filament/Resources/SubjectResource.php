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

    protected static ?string $navigationLabel = 'Mata Pelajaran';

    protected static ?string $modelLabel = 'Mata Pelajaran';

    protected static ?string $pluralModelLabel = 'Mata Pelajaran';

    protected static ?int $navigationSort = 2;

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
            ])
            ->actions([
                Actions\EditAction::make(),
                Actions\DeleteAction::make(),
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
}
