<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CounselingRecordResource\Pages;
use App\Filament\Traits\HasRoleVisibility;
use App\Models\CounselingRecord;
use Filament\Actions;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CounselingRecordResource extends Resource
{
    use HasRoleVisibility;

    protected static array $allowedRoles = ['admin', 'guru'];

    protected static ?string $model = CounselingRecord::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-chat-bubble-left-ellipsis';

    protected static \UnitEnum|string|null $navigationGroup = 'Bimbingan Konseling';

    protected static ?string $navigationLabel = 'Catatan BK';

    protected static ?string $modelLabel = 'Catatan BK';

    protected static ?string $pluralModelLabel = 'Catatan Bimbingan Konseling';

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

            Forms\Components\Select::make('teacher_id')
                ->label('Guru BK / Pelapor')
                ->relationship('teacher', 'name'),

            Forms\Components\DatePicker::make('tanggal')
                ->label('Tanggal Kejadian / Konseling')
                ->default(now())
                ->required(),

            Forms\Components\Select::make('jenis')
                ->label('Jenis Catatan')
                ->options([
                    'pelanggaran' => 'Pelanggaran Tata Tertib',
                    'prestasi'    => 'Pencapaian / Prestasi',
                    'konseling'   => 'Sesi Konseling',
                ])
                ->default('konseling')
                ->required(),

            Forms\Components\TextInput::make('poin')
                ->label('Poin (Pelanggaran = negatif / Prestasi = positif)')
                ->numeric()
                ->default(0),

            Forms\Components\Textarea::make('deskripsi')
                ->label('Deskripsi Kejadian / Catatan')
                ->required()
                ->columnSpanFull(),

            Forms\Components\Textarea::make('tindak_lanjut')
                ->label('Tindak Lanjut')
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
                    ->searchable(),

                Tables\Columns\TextColumn::make('student.classroom.nama_kelas')
                    ->label('Kelas'),

                Tables\Columns\BadgeColumn::make('jenis')
                    ->label('Jenis')
                    ->colors([
                        'danger'  => 'pelanggaran',
                        'success' => 'prestasi',
                        'info'    => 'konseling',
                    ]),

                Tables\Columns\TextColumn::make('poin')
                    ->label('Poin')
                    ->sortable(),

                Tables\Columns\TextColumn::make('deskripsi')
                    ->label('Deskripsi')
                    ->limit(60),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('jenis')
                    ->options([
                        'pelanggaran' => 'Pelanggaran',
                        'prestasi'    => 'Prestasi',
                        'konseling'   => 'Konseling',
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
            'index'  => Pages\ListCounselingRecords::route('/'),
            'create' => Pages\CreateCounselingRecord::route('/create'),
            'edit'   => Pages\EditCounselingRecord::route('/{record}/edit'),
        ];
    }
}
