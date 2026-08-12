<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AttendanceResource\Pages;
use App\Filament\Traits\HasRoleVisibility;
use App\Models\Attendance;
use Filament\Actions;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AttendanceResource extends Resource
{
    use HasRoleVisibility;

    protected static array $allowedRoles = ['admin', 'guru', 'orang_tua', 'siswa'];

    protected static ?string $model = Attendance::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-clipboard-document-check';

    protected static \UnitEnum|string|null $navigationGroup = 'Akademik & Sekolah';

    protected static ?string $parentItem = 'Penilaian & Presensi';

    protected static ?string $navigationLabel = 'Absensi & Presensi';

    protected static ?string $modelLabel = 'Absensi';

    protected static ?string $pluralModelLabel = 'Absensi Siswa';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $form): Schema
    {
        return $form->schema([
            Forms\Components\Select::make('student_id')
                ->label('Siswa')
                ->relationship('student', 'nama_lengkap')
                ->searchable()
                ->preload()
                ->required(),

            Forms\Components\Select::make('classroom_id')
                ->label('Kelas')
                ->relationship('classroom', 'nama_kelas')
                ->required(),

            Forms\Components\Select::make('subject_id')
                ->label('Mata Pelajaran (opsional)')
                ->relationship('subject', 'nama_mapel'),

            Forms\Components\Select::make('academic_year_id')
                ->label('Tahun Ajaran')
                ->relationship('academicYear', 'tahun_ajaran')
                ->required(),

            Forms\Components\DatePicker::make('tanggal')
                ->label('Tanggal')
                ->default(now())
                ->required(),

            Forms\Components\Select::make('status')
                ->label('Status Kehadiran')
                ->options([
                    'hadir' => 'Hadir',
                    'izin'  => 'Izin',
                    'sakit' => 'Sakit',
                    'alpa'  => 'Alpa (Tanpa Keterangan)',
                ])
                ->default('hadir')
                ->required(),

            Forms\Components\Textarea::make('catatan')
                ->label('Catatan Keterangan')
                ->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tanggal')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('student.nama_lengkap')
                    ->label('Nama Siswa')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('classroom.nama_kelas')
                    ->label('Kelas'),

                Tables\Columns\TextColumn::make('subject.nama_mapel')
                    ->label('Mapel')
                    ->default('Presensi Harian'),

                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'success' => 'hadir',
                        'info'    => 'izin',
                        'warning' => 'sakit',
                        'danger'  => 'alpa',
                    ]),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'hadir' => 'Hadir',
                        'izin'  => 'Izin',
                        'sakit' => 'Sakit',
                        'alpa'  => 'Alpa',
                    ]),
                Tables\Filters\SelectFilter::make('classroom_id')
                    ->label('Kelas')
                    ->relationship('classroom', 'nama_kelas'),
            ])
            ->actions([
                Actions\EditAction::make(),
                Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListAttendances::route('/'),
            'create' => Pages\CreateAttendance::route('/create'),
            'edit'   => Pages\EditAttendance::route('/{record}/edit'),
        ];
    }
}
