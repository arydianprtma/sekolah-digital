<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GradeResource\Pages;
use App\Filament\Traits\HasRoleVisibility;
use App\Models\Grade;
use App\Models\Student;
use App\Models\StudentParent;
use Filament\Actions;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class GradeResource extends Resource
{
    use HasRoleVisibility;

    protected static array $allowedRoles = ['admin', 'guru', 'siswa', 'orang_tua'];

    protected static ?string $model = Grade::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-academic-cap';

    protected static \UnitEnum|string|null $navigationGroup = 'Akademik & Sekolah';

    protected static ?string $navigationLabel = 'Nilai & Raport';

    protected static ?string $modelLabel = 'Nilai';

    protected static ?string $pluralModelLabel = 'Nilai Siswa';

    protected static ?int $navigationSort = 5;

    public static function form(Schema $form): Schema
    {
        return $form->schema([
            Forms\Components\Select::make('student_id')
                ->label('Siswa')
                ->relationship('student', 'nama_lengkap')
                ->searchable()
                ->preload()
                ->required(),

            Forms\Components\Select::make('subject_id')
                ->label('Mata Pelajaran')
                ->relationship('subject', 'nama_mapel')
                ->required(),

            Forms\Components\Select::make('academic_year_id')
                ->label('Tahun Ajaran')
                ->relationship('academicYear', 'tahun_ajaran'),

            Forms\Components\Select::make('jenis_nilai')
                ->label('Kategori Nilai')
                ->options([
                    'tugas' => 'Nilai Tugas',
                    'uh'    => 'Ujian Harian (UH)',
                    'uts'   => 'Ujian Tengah Semester (UTS)',
                    'uas'   => 'Ujian Akhir Semester (UAS)',
                ])
                ->required(),

            Forms\Components\TextInput::make('nilai')
                ->label('Nilai (0 - 100)')
                ->numeric()
                ->minValue(0)
                ->maxValue(100)
                ->required(),

            Forms\Components\Textarea::make('catatan')
                ->label('Catatan Guru')
                ->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('student.nama_lengkap')
                    ->label('Nama Siswa')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('student.classroom.nama_kelas')
                    ->label('Kelas'),

                Tables\Columns\TextColumn::make('subject.nama_mapel')
                    ->label('Mata Pelajaran')
                    ->searchable(),

                Tables\Columns\BadgeColumn::make('jenis_nilai')
                    ->label('Kategori')
                    ->colors([
                        'gray'    => 'tugas',
                        'info'    => 'uh',
                        'warning' => 'uts',
                        'success' => 'uas',
                    ]),

                Tables\Columns\TextColumn::make('nilai')
                    ->label('Nilai')
                    ->sortable()
                    ->weight('bold'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('jenis_nilai')
                    ->options([
                        'tugas' => 'Tugas',
                        'uh'    => 'UH',
                        'uts'   => 'UTS',
                        'uas'   => 'UAS',
                    ]),
                Tables\Filters\SelectFilter::make('subject_id')
                    ->label('Mapel')
                    ->relationship('subject', 'nama_mapel'),
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
            'index'  => Pages\ListGrades::route('/'),
            'create' => Pages\CreateGrade::route('/create'),
            'edit'   => Pages\EditGrade::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        $user  = auth()->user();

        // Siswa: hanya lihat nilai dirinya sendiri
        if ($user && $user->hasRole('siswa')) {
            $student = Student::where('user_id', $user->id)->first();
            return $query->where('student_id', $student?->id ?? 0);
        }

        // Orang tua: lihat nilai anak mereka
        if ($user && $user->hasRole('orang_tua')) {
            $studentIds = StudentParent::where('user_id', $user->id)->pluck('student_id');
            return $query->whereIn('student_id', $studentIds);
        }

        return $query;
    }
}
