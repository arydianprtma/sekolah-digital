<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AchievementResource\Pages;
use App\Models\Achievement;
use Filament\Forms;
use Filament\Schemas\Components as SchemaComponents;
use Filament\Schemas\Schema;
use App\Filament\Traits\HasRoleVisibility;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions;
use Illuminate\Support\Str;

class AchievementResource extends Resource
{
    use HasRoleVisibility;

    protected static array $allowedRoles = ['admin'];

    protected static ?string $model = Achievement::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-trophy';

    protected static \UnitEnum|string|null $navigationGroup = 'Fasilitas & Prestasi';

    protected static ?string $modelLabel = 'Prestasi';

    protected static ?string $pluralModelLabel = 'Prestasi Sekolah & Siswa';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                SchemaComponents\Section::make('Detail Prestasi')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Judul / Nama Prestasi')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),

                        Forms\Components\TextInput::make('slug')
                            ->label('Slug URL')
                            ->required()
                            ->maxLength(255)
                            ->unique(Achievement::class, 'slug', ignoreRecord: true),

                        Forms\Components\TextInput::make('winner_name')
                            ->label('Nama Pemenang / Tim')
                            ->required(),

                        Forms\Components\Select::make('level')
                            ->label('Tingkat Kejuaraan')
                            ->options([
                                'kabupaten' => 'Kabupaten / Kota',
                                'provinsi' => 'Provinsi',
                                'nasional' => 'Nasional',
                                'internasional' => 'Internasional',
                            ])
                            ->required(),

                        Forms\Components\Select::make('rank')
                            ->label('Peringkat / Juara')
                            ->options([
                                'juara_1' => 'Juara 1',
                                'juara_2' => 'Juara 2',
                                'juara_3' => 'Juara 3',
                                'harapan_1' => 'Juara Harapan',
                                'lainnya' => 'Penghargaan Lainnya',
                            ])
                            ->required(),

                        Forms\Components\TextInput::make('year')
                            ->label('Tahun')
                            ->numeric()
                            ->default(date('Y')),

                        Forms\Components\TextInput::make('category')
                            ->label('Kategori (cth: Sains, Robotika, Seni, Olahraga)'),

                        Forms\Components\FileUpload::make('image')
                            ->label('Foto Dokumentasi / Piagam')
                            ->image()
                            ->directory('achievements'),

                        Forms\Components\RichEditor::make('description')
                            ->label('Deskripsi Prestasi')
                            ->columnSpanFull(),

                        Forms\Components\Toggle::make('status')
                            ->label('Tampilkan Publik')
                            ->default(true),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Foto'),

                Tables\Columns\TextColumn::make('title')
                    ->label('Nama Prestasi')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('winner_name')
                    ->label('Pemenang')
                    ->searchable(),

                Tables\Columns\TextColumn::make('level')
                    ->label('Tingkat')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'kabupaten' => 'Kabupaten',
                        'provinsi' => 'Provinsi',
                        'nasional' => 'Nasional',
                        'internasional' => 'Internasional',
                    }),

                Tables\Columns\TextColumn::make('rank')
                    ->label('Peringkat')
                    ->badge()
                    ->color('success')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'juara_1' => 'Juara 1',
                        'juara_2' => 'Juara 2',
                        'juara_3' => 'Juara 3',
                        'harapan_1' => 'Harapan',
                        default => 'Penghargaan',
                    }),

                Tables\Columns\TextColumn::make('year')
                    ->label('Tahun')
                    ->sortable(),

                Tables\Columns\IconColumn::make('status')
                    ->label('Status')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('level')
                    ->options([
                        'kabupaten' => 'Kabupaten',
                        'provinsi' => 'Provinsi',
                        'nasional' => 'Nasional',
                        'internasional' => 'Internasional',
                    ]),
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
            'index' => Pages\ListAchievements::route('/'),
            'create' => Pages\CreateAchievement::route('/create'),
            'edit' => Pages\EditAchievement::route('/{record}/edit'),
        ];
    }
}
