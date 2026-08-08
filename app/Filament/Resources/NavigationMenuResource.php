<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NavigationMenuResource\Pages;
use App\Models\NavigationMenu;
use Filament\Forms;
use Filament\Schemas\Components as SchemaComponents;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions;

class NavigationMenuResource extends Resource
{
    protected static ?string $model = NavigationMenu::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-bars-3';

    protected static \UnitEnum|string|null $navigationGroup = 'Tampilan & Navigasi';

    protected static ?string $modelLabel = 'Menu Navigasi';

    protected static ?string $pluralModelLabel = 'Menu Navigasi Utama';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                SchemaComponents\Section::make('Item Navigasi')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Label Menu')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('url')
                            ->label('Tujuan URL (cth: /profil atau https://...)')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\Select::make('parent_id')
                            ->label('Menu Induk (Sub-menu jika diisi)')
                            ->options(NavigationMenu::whereNull('parent_id')->pluck('title', 'id'))
                            ->nullable(),

                        Forms\Components\Select::make('target')
                            ->label('Target Pembukaan')
                            ->options([
                                '_self' => 'Halaman Saat Ini (_self)',
                                '_blank' => 'Tab Baru (_blank)',
                            ])
                            ->default('_self'),

                        Forms\Components\TextInput::make('sort_order')
                            ->label('Urutan')
                            ->numeric()
                            ->default(0),

                        Forms\Components\Toggle::make('is_external')
                            ->label('Tautan Luar / Eksternal')
                            ->default(false),

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
                Tables\Columns\TextColumn::make('title')
                    ->label('Label Menu')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('url')
                    ->label('Tujuan URL')
                    ->searchable(),

                Tables\Columns\TextColumn::make('parent.title')
                    ->label('Induk Menu')
                    ->placeholder('Utama (Top Level)'),

                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Urutan')
                    ->sortable(),

                Tables\Columns\IconColumn::make('status')
                    ->label('Status')
                    ->boolean(),
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
            'index' => Pages\ListNavigationMenus::route('/'),
            'create' => Pages\CreateNavigationMenu::route('/create'),
            'edit' => Pages\EditNavigationMenu::route('/{record}/edit'),
        ];
    }
}
