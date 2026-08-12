<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AuditLogResource\Pages;
use App\Models\AuditLog;
use Filament\Schemas\Components as SchemaComponents;
use Filament\Schemas\Schema;
use App\Filament\Traits\HasRoleVisibility;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AuditLogResource extends Resource
{
    use HasRoleVisibility;

    protected static array $allowedRoles = ['admin'];

    protected static ?string $model = AuditLog::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static \UnitEnum|string|null $navigationGroup = 'Sistem & Keamanan';

    protected static ?string $modelLabel = 'Audit Log';

    protected static ?string $pluralModelLabel = 'Catatan Aktivitas (Audit Log)';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                SchemaComponents\Section::make('Rincian Log Aktivitas')
                    ->schema([
                        // Read-only inspection
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Waktu')
                    ->dateTime('d M Y, H:i:s')
                    ->sortable(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Pengguna')
                    ->placeholder('Sistem / Tamu')
                    ->searchable(),

                Tables\Columns\TextColumn::make('action')
                    ->label('Aktivitas')
                    ->formatStateUsing(fn (string $state) => match ($state) {
                        'created'      => 'Tambah Data',
                        'updated'      => 'Ubah Data',
                        'deleted'      => 'Hapus Data',
                        'restored'     => 'Pulihkan Data',
                        'force_deleted'=> 'Hapus Permanen',
                        default        => $state,
                    })
                    ->badge()
                    ->color(fn (string $state) => match ($state) {
                        'created'       => 'success',
                        'updated'       => 'warning',
                        'deleted'       => 'danger',
                        'restored'      => 'info',
                        'force_deleted' => 'danger',
                        default         => 'gray',
                    })
                    ->searchable(),

                Tables\Columns\TextColumn::make('model_type')
                    ->label('Tipe Modul')
                    ->formatStateUsing(fn (string $state) => match ($state) {
                        'News'                 => 'Berita',
                        'Announcement'         => 'Pengumuman',
                        'Agenda'               => 'Agenda / Kegiatan',
                        'Album'                => 'Album Galeri',
                        'Achievement'          => 'Prestasi',
                        'Document'             => 'Dokumen',
                        'Facility'             => 'Fasilitas',
                        'LibraryBook'          => 'Buku Perpustakaan',
                        'LearningMaterial'     => 'Materi Belajar',
                        'TeacherStaff'         => 'Guru & Tenaga Kependidikan',
                        'SchoolProfile'        => 'Profil Sekolah',
                        'Student'              => 'Data Siswa',
                        'User'                 => 'Pengguna',
                        'Assignment'           => 'Tugas',
                        'AssignmentSubmission' => 'Pengumpulan Tugas',
                        'Grade'                => 'Nilai / Rapor',
                        'Schedule'             => 'Jadwal Pelajaran',
                        'Page'                 => 'Halaman Kustom',
                        'System'               => 'Sistem',
                        default                => $state,
                    })
                    ->badge()
                    ->color('gray'),

                Tables\Columns\TextColumn::make('ip_address')
                    ->label('IP Address')
                    ->copyable()
                    ->copyMessage('IP disalin!'),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAuditLogs::route('/'),
        ];
    }
}
