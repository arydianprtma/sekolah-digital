<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentResource\Pages;
use App\Filament\Traits\HasRoleVisibility;
use App\Models\Student;
use App\Models\StudentParent;
use Filament\Actions;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class StudentResource extends Resource
{
    use HasRoleVisibility;

    protected static array $allowedRoles = ['admin', 'guru', 'orang_tua', 'siswa'];

    protected static ?string $model = Student::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-user-group';

    protected static \UnitEnum|string|null $navigationGroup = 'Akademik & Sekolah';

    protected static ?string $navigationLabel = 'Data Siswa';

    protected static ?string $modelLabel = 'Siswa';

    protected static ?string $pluralModelLabel = 'Data Siswa';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $form): Schema
    {
        return $form->schema([
            \Filament\Schemas\Components\Section::make('Informasi Pribadi Siswa')->schema([
                Forms\Components\TextInput::make('nisn')
                    ->label('NISN')
                    ->required()
                    ->unique(ignoreRecord: true),

                Forms\Components\TextInput::make('nis')
                    ->label('NIS')
                    ->placeholder('Nomor Induk Sekolah'),

                Forms\Components\TextInput::make('nama_lengkap')
                    ->label('Nama Lengkap Siswa')
                    ->required(),

                Forms\Components\Select::make('jenis_kelamin')
                    ->label('Jenis Kelamin')
                    ->options([
                        'L' => 'Laki-laki',
                        'P' => 'Perempuan',
                    ])
                    ->required(),

                Forms\Components\Select::make('classroom_id')
                    ->label('Kelas / Rombel')
                    ->relationship('classroom', 'nama_kelas')
                    ->searchable()
                    ->preload(),

                Forms\Components\Select::make('user_id')
                    ->label('Akun User Login')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload(),

                Forms\Components\TextInput::make('tempat_lahir')->label('Tempat Lahir'),
                Forms\Components\DatePicker::make('tanggal_lahir')->label('Tanggal Lahir'),
                Forms\Components\TextInput::make('no_telepon')->label('Nomor WhatsApp / HP'),

                Forms\Components\Select::make('status')
                    ->label('Status Siswa')
                    ->options([
                        'aktif' => 'Aktif',
                        'lulus' => 'Lulus',
                        'pindah' => 'Pindah',
                        'do' => 'Drop Out (DO)',
                    ])
                    ->default('aktif')
                    ->required(),
            ])->columns(2),

            \Filament\Schemas\Components\Section::make('Alamat Siswa')->schema([
                Forms\Components\Textarea::make('alamat')->label('Alamat Lengkap')->columnSpanFull(),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nisn')
                    ->label('NISN')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('nama_lengkap')
                    ->label('Nama Siswa')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('classroom.nama_kelas')
                    ->label('Kelas')
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('jenis_kelamin')
                    ->label('L/P')
                    ->colors([
                        'info' => 'L',
                        'success' => 'P',
                    ]),

                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'success' => 'aktif',
                        'gray'    => 'lulus',
                        'warning' => 'pindah',
                        'danger'  => 'do',
                    ]),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('classroom_id')
                    ->label('Kelas')
                    ->relationship('classroom', 'nama_kelas'),
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'aktif' => 'Aktif',
                        'lulus' => 'Lulus',
                        'pindah' => 'Pindah',
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
            'index'  => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/create'),
            'edit'   => Pages\EditStudent::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        $user  = auth()->user();

        // Siswa: hanya lihat profil data dirinya sendiri
        if ($user && $user->hasRole('siswa')) {
            return $query->where('user_id', $user->id);
        }

        // Orang tua: hanya lihat data anak mereka
        if ($user && $user->hasRole('orang_tua')) {
            $parent    = StudentParent::where('user_id', $user->id)->first();
            $studentId = $parent?->student_id ?? 0;
            return $query->where('id', $studentId);
        }

        return $query;
    }
}
