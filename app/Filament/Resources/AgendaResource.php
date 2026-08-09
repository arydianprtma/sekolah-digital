<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AgendaResource\Pages;
use App\Models\Agenda;
use Filament\Forms;
use Filament\Schemas\Components as SchemaComponents;
use Filament\Schemas\Schema;
use App\Filament\Traits\HasRoleVisibility;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions;
use Illuminate\Support\Str;

class AgendaResource extends Resource
{
    use HasRoleVisibility;

    protected static array $allowedRoles = ['admin'];

    protected static ?string $model = Agenda::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-calendar';

    protected static \UnitEnum|string|null $navigationGroup = 'Informasi & Agenda';

    protected static ?string $modelLabel = 'Agenda';

    protected static ?string $pluralModelLabel = 'Agenda Kegiatan';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                SchemaComponents\Section::make('Rincian Agenda Kegiatan')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Judul Agenda')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),

                        Forms\Components\TextInput::make('slug')
                            ->label('Slug URL')
                            ->required()
                            ->maxLength(255)
                            ->unique(Agenda::class, 'slug', ignoreRecord: true),

                        Forms\Components\DateTimePicker::make('start_date')
                            ->label('Waktu Mulai')
                            ->required(),

                        Forms\Components\DateTimePicker::make('end_date')
                            ->label('Waktu Selesai'),

                        Forms\Components\TextInput::make('location')
                            ->label('Lokasi / Tempat Pelaksanaan')
                            ->required(),

                        Forms\Components\TextInput::make('organizer')
                            ->label('Penyelenggara / Panitia'),

                        Forms\Components\FileUpload::make('image')
                            ->label('Poster / Pamflet Agenda')
                            ->image()
                            ->directory('agenda'),

                        Forms\Components\Toggle::make('status')
                            ->label('Status Aktif')
                            ->default(true),

                        Forms\Components\RichEditor::make('description')
                            ->label('Deskripsi Kegiatan')
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Poster'),

                Tables\Columns\TextColumn::make('title')
                    ->label('Judul Agenda')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('start_date')
                    ->label('Waktu Pelaksanaan')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),

                Tables\Columns\TextColumn::make('location')
                    ->label('Lokasi')
                    ->searchable(),

                Tables\Columns\IconColumn::make('status')
                    ->label('Status')
                    ->boolean(),
            ])
            ->defaultSort('start_date', 'asc')
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
            'index' => Pages\ListAgendas::route('/'),
            'create' => Pages\CreateAgenda::route('/create'),
            'edit' => Pages\EditAgenda::route('/{record}/edit'),
        ];
    }
}
