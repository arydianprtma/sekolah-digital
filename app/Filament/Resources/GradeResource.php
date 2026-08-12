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
                ->relationship('academicYear', 'tahun_ajaran')
                ->required(),

            Forms\Components\TextInput::make('nilai_presensi')
                ->label('Presensi (%)')
                ->numeric()
                ->minValue(0)->maxValue(100),

            Forms\Components\TextInput::make('nilai_tugas')
                ->label('Tugas')
                ->numeric()
                ->minValue(0)->maxValue(100),

            Forms\Components\TextInput::make('nilai_uh')
                ->label('UH')
                ->numeric()
                ->minValue(0)->maxValue(100),

            Forms\Components\TextInput::make('nilai_uts')
                ->label('UTS')
                ->numeric()
                ->minValue(0)->maxValue(100),

            Forms\Components\TextInput::make('nilai_uas')
                ->label('UAS')
                ->numeric()
                ->minValue(0)->maxValue(100),

            Forms\Components\TextInput::make('nilai_akhir')
                ->label('Nilai Akhir')
                ->numeric(),

            Forms\Components\TextInput::make('nilai_huruf')
                ->label('Nilai Huruf')
                ->maxLength(2),

            Forms\Components\Textarea::make('catatan')
                ->label('Catatan Guru')
                ->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        $user = auth()->user();
        $isGuruAtauAdmin = $user && ($user->hasRole('admin') || $user->hasRole('guru'));
        $isSiswa = $user && $user->hasRole('siswa');

        return $table
            ->columns([
                Tables\Columns\TextColumn::make('student.nama_lengkap')
                    ->label('Nama Siswa')
                    ->searchable()
                    ->sortable()
                    ->hidden(fn () => $isSiswa), // Siswa tak perlu lihat namanya berulang kali

                Tables\Columns\TextColumn::make('student.classroom.nama_kelas')
                    ->label('Kelas')
                    ->hidden(fn () => $isSiswa),

                Tables\Columns\TextColumn::make('subject.nama_mapel')
                    ->label('Mata Pelajaran')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('nilai_presensi')
                    ->label('Presensi')
                    ->getStateUsing(function ($record) {
                        $totalHadir = \App\Models\Attendance::where('student_id', $record->student_id)
                            ->where('academic_year_id', $record->academic_year_id)
                            ->where('status', 'Hadir')
                            ->count();
                            
                        $totalPertemuan = \App\Models\Attendance::where('student_id', $record->student_id)
                            ->where('academic_year_id', $record->academic_year_id)
                            ->count();
                            
                        if ($totalPertemuan === 0) return '0%';
                        return round(($totalHadir / $totalPertemuan) * 100) . '%';
                    }),
                
                $isGuruAtauAdmin 
                    ? Tables\Columns\TextInputColumn::make('nilai_tugas')->label('Tugas')->extraAttributes(['style' => 'min-width: 80px; width: 80px; max-width: 100px;']) 
                    : Tables\Columns\TextColumn::make('nilai_tugas')->label('Tugas')->default('-'),
                
                $isGuruAtauAdmin 
                    ? Tables\Columns\TextInputColumn::make('nilai_uts')->label('UTS')->extraAttributes(['style' => 'min-width: 80px; width: 80px; max-width: 100px;']) 
                    : Tables\Columns\TextColumn::make('nilai_uts')->label('UTS')->default('-'),
                
                $isGuruAtauAdmin 
                    ? Tables\Columns\TextInputColumn::make('nilai_uas')->label('UAS')->extraAttributes(['style' => 'min-width: 80px; width: 80px; max-width: 100px;']) 
                    : Tables\Columns\TextColumn::make('nilai_uas')->label('UAS')->default('-'),

                Tables\Columns\TextColumn::make('nilai_akhir')
                    ->label('NA')
                    ->sortable()
                    ->weight('bold')
                    ->default('-'),

                Tables\Columns\TextColumn::make('nilai_huruf')
                    ->label('Predikat')
                    ->badge()
                    ->default('-')
                    ->color(fn (?string $state): string => match ($state) {
                        'Sangat Baik' => 'success',
                        'Baik' => 'info',
                        'Cukup' => 'warning',
                        'Kurang' => 'danger',
                        default => 'gray',
                    }),
            ])
            ->recordUrl(null)
            ->filters([
                Tables\Filters\SelectFilter::make('academic_year_id')
                    ->label('Tahun Ajaran')
                    ->relationship('academicYear', 'tahun_ajaran'),
                Tables\Filters\SelectFilter::make('student.classroom_id')
                    ->label('Kelas')
                    ->relationship('student.classroom', 'nama_kelas')
                    ->hidden(fn () => $isSiswa),
                Tables\Filters\SelectFilter::make('subject_id')
                    ->label('Mapel')
                    ->relationship('subject', 'nama_mapel', function (\Illuminate\Database\Eloquent\Builder $query) use ($user) {
                        if ($user && $user->hasRole('guru') && !$user->hasRole('admin') && !$user->hasRole('Super Admin')) {
                            $subjectIds = \App\Models\Schedule::where('teacher_id', $user->id)->pluck('subject_id');
                            return $query->whereIn('id', $subjectIds);
                        }
                        return $query;
                    }),
            ], layout: \Filament\Tables\Enums\FiltersLayout::AboveContent)
            ->filtersFormColumns(3)
            ->actions([
                // Tidak perlu tombol Edit/Delete karena sudah inline editing
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
