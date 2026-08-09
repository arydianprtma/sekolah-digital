<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PpdbSettingResource\Pages;
use App\Models\PpdbSetting;
use Filament\Actions;
use Filament\Forms;
use Filament\Schemas\Schema;
use App\Filament\Traits\HasRoleVisibility;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PpdbSettingResource extends Resource
{
    use HasRoleVisibility;

    protected static array $allowedRoles = ['admin'];

    protected static ?string $model = PpdbSetting::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-academic-cap';

    protected static \UnitEnum|string|null $navigationGroup = 'PPDB & Digital';

    protected static ?string $navigationLabel = 'Pengaturan PPDB';

    protected static ?string $modelLabel = 'Pengaturan PPDB';

    protected static ?string $pluralModelLabel = 'Pengaturan PPDB';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $form): Schema
    {
        return $form->schema([
            \Filament\Schemas\Components\Section::make('Informasi Dasar')->schema([
                Forms\Components\TextInput::make('tahun_ajaran')
                    ->label('Tahun Ajaran')
                    ->required()
                    ->placeholder('2027/2028'),

                Forms\Components\TextInput::make('gelombang')
                    ->label('Gelombang')
                    ->placeholder('Gelombang 1'),

                Forms\Components\DatePicker::make('tanggal_mulai')
                    ->label('Tanggal Mulai Pendaftaran'),

                Forms\Components\DatePicker::make('tanggal_selesai')
                    ->label('Tanggal Selesai Pendaftaran'),

                Forms\Components\Toggle::make('is_active')
                    ->label('Aktif')
                    ->default(true),
            ])->columns(2),

            \Filament\Schemas\Components\Section::make('Kontak Pendaftaran')->schema([
                Forms\Components\TextInput::make('link_pendaftaran')
                    ->label('Link Pendaftaran Online')
                    ->url()
                    ->placeholder('https://...'),

                Forms\Components\TextInput::make('whatsapp_pendaftaran')
                    ->label('WhatsApp')
                    ->tel()
                    ->placeholder('628...'),

                Forms\Components\TextInput::make('email_pendaftaran')
                    ->label('Email')
                    ->email(),
            ])->columns(3),

            \Filament\Schemas\Components\Section::make('Konten')->schema([
                Forms\Components\RichEditor::make('persyaratan')
                    ->label('Persyaratan Pendaftaran')
                    ->columnSpanFull(),

                Forms\Components\RichEditor::make('jadwal')
                    ->label('Jadwal PPDB')
                    ->columnSpanFull(),

                Forms\Components\RichEditor::make('biaya')
                    ->label('Informasi Biaya')
                    ->columnSpanFull(),

                Forms\Components\RichEditor::make('keterangan')
                    ->label('Keterangan Tambahan')
                    ->columnSpanFull(),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tahun_ajaran')
                    ->label('Tahun Ajaran')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('gelombang')
                    ->label('Gelombang'),

                Tables\Columns\TextColumn::make('tanggal_mulai')
                    ->label('Mulai')
                    ->date('d M Y'),

                Tables\Columns\TextColumn::make('tanggal_selesai')
                    ->label('Selesai')
                    ->date('d M Y'),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')->label('Aktif'),
            ])
            ->actions([
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
            'index'  => Pages\ListPpdbSettings::route('/'),
            'create' => Pages\CreatePpdbSetting::route('/create'),
            'edit'   => Pages\EditPpdbSetting::route('/{record}/edit'),
        ];
    }
}
