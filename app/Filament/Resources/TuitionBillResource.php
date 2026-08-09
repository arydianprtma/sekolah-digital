<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TuitionBillResource\Pages;
use App\Filament\Traits\HasRoleVisibility;
use App\Models\TuitionBill;
use App\Models\Student;
use App\Models\StudentParent;
use Filament\Actions;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class TuitionBillResource extends Resource
{
    use HasRoleVisibility;

    protected static array $allowedRoles = ['admin', 'orang_tua', 'siswa'];

    protected static ?string $model = TuitionBill::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-banknotes';

    protected static \UnitEnum|string|null $navigationGroup = 'Keuangan Sekolah';

    protected static ?string $navigationLabel = 'Tagihan SPP';

    protected static ?string $modelLabel = 'Tagihan';

    protected static ?string $pluralModelLabel = 'Tagihan SPP';

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

            Forms\Components\TextInput::make('nama_tagihan')
                ->label('Nama Tagihan')
                ->placeholder('SPP Bulan Agustus 2026')
                ->required(),

            Forms\Components\TextInput::make('jumlah')
                ->label('Jumlah Tagihan (Rp)')
                ->numeric()
                ->prefix('Rp')
                ->required(),

            Forms\Components\TextInput::make('bulan_tahun')
                ->label('Periode (Bulan-Tahun)')
                ->placeholder('08-2026'),

            Forms\Components\DatePicker::make('jatuh_tempo')
                ->label('Jatuh Tempo'),

            Forms\Components\Select::make('status')
                ->label('Status Pembayaran')
                ->options([
                    'belum_lunas' => 'Belum Lunas',
                    'sebagian'    => 'Dibayar Sebagian',
                    'lunas'       => 'Lunas',
                ])
                ->default('belum_lunas')
                ->required(),
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

                Tables\Columns\TextColumn::make('nama_tagihan')
                    ->label('Tagihan')
                    ->searchable(),

                Tables\Columns\TextColumn::make('jumlah')
                    ->label('Jumlah')
                    ->money('IDR')
                    ->sortable(),

                Tables\Columns\TextColumn::make('jatuh_tempo')
                    ->label('Jatuh Tempo')
                    ->date('d M Y'),

                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'danger'  => 'belum_lunas',
                        'warning' => 'sebagian',
                        'success' => 'lunas',
                    ]),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'belum_lunas' => 'Belum Lunas',
                        'sebagian'    => 'Sebagian',
                        'lunas'       => 'Lunas',
                    ]),
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
            'index'  => Pages\ListTuitionBills::route('/'),
            'create' => Pages\CreateTuitionBill::route('/create'),
            'edit'   => Pages\EditTuitionBill::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        $user  = auth()->user();

        // Siswa: hanya lihat tagihan milik dirinya sendiri
        if ($user && $user->hasRole('siswa')) {
            $student = Student::where('user_id', $user->id)->first();
            return $query->where('student_id', $student?->id ?? 0);
        }

        // Orang tua: hanya lihat tagihan anak mereka
        if ($user && $user->hasRole('orang_tua')) {
            $studentIds = StudentParent::where('user_id', $user->id)->pluck('student_id');
            return $query->whereIn('student_id', $studentIds);
        }

        return $query;
    }
}
