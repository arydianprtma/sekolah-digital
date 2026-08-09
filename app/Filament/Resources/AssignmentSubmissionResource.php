<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AssignmentSubmissionResource\Pages;
use App\Filament\Traits\HasRoleVisibility;
use App\Models\AssignmentSubmission;
use Filament\Actions;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AssignmentSubmissionResource extends Resource
{
    use HasRoleVisibility;

    protected static array $allowedRoles = ['admin', 'siswa'];

    protected static ?string $model = AssignmentSubmission::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-document-check';

    protected static \UnitEnum|string|null $navigationGroup = 'E-Learning & Konten';

    protected static ?string $navigationLabel = 'Pengumpulan Tugas';

    protected static ?string $modelLabel = 'Pengumpulan Tugas';

    protected static ?string $pluralModelLabel = 'Pengumpulan Tugas';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $form): Schema
    {
        return $form->schema([
            Forms\Components\Select::make('assignment_id')
                ->label('Tugas')
                ->relationship('assignment', 'judul')
                ->required(),

            Forms\Components\Select::make('student_id')
                ->label('Siswa')
                ->relationship('student', 'nama_lengkap')
                ->required()
                ->default(function () {
                    $user = auth()->user();
                    if ($user && $user->hasRole('siswa')) {
                        return \App\Models\Student::where('user_id', $user->id)->value('id');
                    }
                    return null;
                })
                ->disabled(fn () => auth()->user()?->hasRole('siswa'))
                ->dehydrated(),

            Forms\Components\FileUpload::make('file_path')
                ->label('File Jawaban / Tugas')
                ->directory('assignment_submissions')
                ->downloadable(),

            Forms\Components\Textarea::make('catatan_siswa')
                ->label('Catatan dari Siswa')
                ->columnSpanFull(),

            Forms\Components\TextInput::make('nilai')
                ->label('Nilai')
                ->numeric()
                ->minValue(0)
                ->maxValue(100)
                ->hidden(fn () => auth()->user()?->hasRole('siswa')),

            Forms\Components\Textarea::make('catatan_guru')
                ->label('Catatan dari Guru')
                ->columnSpanFull()
                ->hidden(fn () => auth()->user()?->hasRole('siswa')),

            Forms\Components\DateTimePicker::make('created_at')
                ->label('Waktu Pengumpulan')
                ->disabled()
                ->hidden(fn () => auth()->user()?->hasRole('siswa')),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('assignment.judul')
                    ->label('Tugas')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('student.nama_lengkap')
                    ->label('Siswa')
                    ->searchable(),

                Tables\Columns\TextColumn::make('nilai')
                    ->label('Nilai')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Disubmit Pada')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
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
            'index'  => Pages\ListAssignmentSubmissions::route('/'),
            'create' => Pages\CreateAssignmentSubmission::route('/create'),
            'edit'   => Pages\EditAssignmentSubmission::route('/{record}/edit'),
        ];
    }
}
