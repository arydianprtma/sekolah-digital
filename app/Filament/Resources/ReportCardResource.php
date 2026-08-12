<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReportCardResource\Pages;
use App\Filament\Traits\HasRoleVisibility;
use App\Models\ReportCard;
use App\Models\Student;
use App\Models\StudentParent;
use Filament\Actions;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ReportCardResource extends Resource
{
    use HasRoleVisibility;

    protected static array $allowedRoles = ['admin', 'guru', 'siswa', 'orang_tua'];

    protected static ?string $model = ReportCard::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-document-text';

    protected static \UnitEnum|string|null $navigationGroup = 'Akademik & Sekolah';

    protected static ?string $parentItem = 'Penilaian & Presensi';

    protected static ?string $navigationLabel = 'Cetak Rapor';

    protected static ?string $modelLabel = 'Rapor';

    protected static ?string $pluralModelLabel = 'Data Rapor';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\Select::make('student_id')
                    ->label('Siswa')
                    ->relationship('student', 'nama_lengkap')
                    ->searchable()
                    ->preload()
                    ->required(),

                Forms\Components\Select::make('academic_year_id')
                    ->label('Tahun Ajaran')
                    ->relationship('academicYear', 'tahun_ajaran')
                    ->required(),

                Forms\Components\Select::make('nilai_sikap')
                    ->options([
                        'Sangat Baik' => 'Sangat Baik',
                        'Baik' => 'Baik',
                        'Cukup' => 'Cukup',
                        'Kurang' => 'Kurang',
                    ])
                    ->default('Baik')
                    ->required(),

                Forms\Components\Select::make('nilai_spiritual')
                    ->options([
                        'Sangat Baik' => 'Sangat Baik',
                        'Baik' => 'Baik',
                        'Cukup' => 'Cukup',
                        'Kurang' => 'Kurang',
                    ])
                    ->default('Baik')
                    ->required(),

                Forms\Components\Select::make('status_kenaikan')
                    ->options([
                        'Naik Kelas' => 'Naik Kelas',
                        'Tinggal Kelas' => 'Tinggal Kelas',
                        'Lulus' => 'Lulus',
                    ]),

                Forms\Components\Textarea::make('catatan_wali_kelas')
                    ->label('Catatan Wali Kelas')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('student.nama_lengkap')
                    ->label('Siswa')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('academicYear.tahun_ajaran')
                    ->label('Tahun Ajaran')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status_kenaikan')
                    ->label('Status Kenaikan')
                    ->badge(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Actions\Action::make('cetak_rapor')
                    ->label('Cetak PDF')
                    ->icon('heroicon-o-printer')
                    ->color('success')
                    ->url(fn (ReportCard $record) => url('/portal/report-cards/' . $record->id . '/pdf'))
                    ->openUrlInNewTab(),
                Actions\EditAction::make(),
                Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageReportCards::route('/'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        $user  = auth()->user();

        // Siswa: hanya lihat rapor dirinya sendiri
        if ($user && $user->hasRole('siswa')) {
            $student = Student::where('user_id', $user->id)->first();
            return $query->where('student_id', $student?->id ?? 0);
        }

        // Orang tua: lihat rapor anak mereka
        if ($user && $user->hasRole('orang_tua')) {
            $studentIds = StudentParent::where('user_id', $user->id)->pluck('student_id');
            return $query->whereIn('student_id', $studentIds);
        }

        return $query;
    }
}
