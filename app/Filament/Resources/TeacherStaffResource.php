<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TeacherStaffResource\Pages;
use App\Models\TeacherStaff;
use Filament\Forms;
use Filament\Schemas\Components as SchemaComponents;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions;

class TeacherStaffResource extends Resource
{
    protected static ?string $model = TeacherStaff::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-user-group';

    protected static \UnitEnum|string|null $navigationGroup = 'Identitas Sekolah';

    protected static ?string $modelLabel = 'Guru & Staf';

    protected static ?string $pluralModelLabel = 'Guru & Tenaga Kependidikan';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                SchemaComponents\Section::make('Informasi Pribadi & Jabatan')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Lengkap & Gelar')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\Select::make('category')
                            ->label('Kategori Jabatan')
                            ->options([
                                'kepala_sekolah' => 'Kepala Sekolah',
                                'wakil_kepala_sekolah' => 'Wakil Kepala Sekolah',
                                'guru' => 'Guru / Tenaga Pengajar',
                                'staf' => 'Staf / Tata Usaha',
                                'tenaga_kependidikan' => 'Tenaga Kependidikan Lainnya',
                            ])
                            ->default('guru')
                            ->required(),

                        Forms\Components\TextInput::make('nip')
                            ->label('NIP')
                            ->maxLength(50),

                        Forms\Components\TextInput::make('nuptk')
                            ->label('NUPTK')
                            ->maxLength(50),

                        Forms\Components\TextInput::make('position')
                            ->label('Jabatan Spesifik (cth: Wakasek Kurikulum)'),

                        Forms\Components\TextInput::make('subject')
                            ->label('Mata Pelajaran yang Diampu'),

                        Forms\Components\TextInput::make('email')
                            ->label('Alamat Email')
                            ->email(),

                        Forms\Components\FileUpload::make('photo')
                            ->label('Foto Profil')
                            ->image()
                            ->directory('guru-staf')
                            ->imageEditor(),

                        Forms\Components\Textarea::make('bio')
                            ->label('Biografi Singkat')
                            ->rows(3)
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('sort_order')
                            ->label('Urutan Tampilan')
                            ->numeric()
                            ->default(0),

                        Forms\Components\Toggle::make('status')
                            ->label('Status Aktif')
                            ->default(true),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('photo')
                    ->label('Foto')
                    ->circular(),

                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Lengkap')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('category')
                    ->label('Kategori')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'kepala_sekolah' => 'Kepala Sekolah',
                        'wakil_kepala_sekolah' => 'Wakil Kepsek',
                        'guru' => 'Guru',
                        'staf' => 'Staf',
                        'tenaga_kependidikan' => 'Tenaga Kependidikan',
                    }),

                Tables\Columns\TextColumn::make('position')
                    ->label('Jabatan'),

                Tables\Columns\TextColumn::make('subject')
                    ->label('Mata Pelajaran'),

                Tables\Columns\IconColumn::make('status')
                    ->label('Status')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->label('Kategori')
                    ->options([
                        'kepala_sekolah' => 'Kepala Sekolah',
                        'wakil_kepala_sekolah' => 'Wakil Kepsek',
                        'guru' => 'Guru',
                        'staf' => 'Staf',
                        'tenaga_kependidikan' => 'Tenaga Kependidikan',
                    ]),
                Tables\Filters\TernaryFilter::make('status')
                    ->label('Status Aktif'),
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
            'index' => Pages\ListTeacherStaffs::route('/'),
            'create' => Pages\CreateTeacherStaff::route('/create'),
            'edit' => Pages\EditTeacherStaff::route('/{record}/edit'),
        ];
    }
}
