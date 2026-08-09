<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LibraryBookResource\Pages;
use App\Filament\Traits\HasRoleVisibility;
use App\Models\LibraryBook;
use Filament\Actions;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class LibraryBookResource extends Resource
{
    use HasRoleVisibility;

    protected static array $allowedRoles = ['admin', 'guru', 'siswa'];

    protected static ?string $model = LibraryBook::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-book-open';

    protected static \UnitEnum|string|null $navigationGroup = 'Perpustakaan';

    protected static ?string $navigationLabel = 'Katalog Buku';

    protected static ?string $modelLabel = 'Buku';

    protected static ?string $pluralModelLabel = 'Koleksi Buku';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $form): Schema
    {
        return $form->schema([
            \Filament\Schemas\Components\Section::make('Data Buku')->schema([
                Forms\Components\TextInput::make('judul')
                    ->label('Judul Buku')
                    ->required(),

                Forms\Components\TextInput::make('pengarang')
                    ->label('Pengarang / Penulis')
                    ->required(),

                Forms\Components\TextInput::make('penerbit')
                    ->label('Penerbit'),

                Forms\Components\TextInput::make('tahun_terbit')
                    ->label('Tahun Terbit')
                    ->numeric(),

                Forms\Components\TextInput::make('isbn')
                    ->label('ISBN'),

                Forms\Components\TextInput::make('kategori')
                    ->label('Kategori')
                    ->default('Umum'),

                Forms\Components\TextInput::make('stok')
                    ->label('Jumlah Stok')
                    ->numeric()
                    ->default(1),
            ])->columns(2),

            \Filament\Schemas\Components\Section::make('Berkas Digital')->schema([
                Forms\Components\FileUpload::make('cover_image')
                    ->label('Sampul Buku')
                    ->image()
                    ->directory('library/cover'),

                Forms\Components\FileUpload::make('pdf_file')
                    ->label('File PDF E-Book (Opsional)')
                    ->acceptedFileTypes(['application/pdf'])
                    ->directory('library/pdf')
                    ->downloadable(),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('cover_image')
                    ->label('Sampul')
                    ->width(40)
                    ->height(56),

                Tables\Columns\TextColumn::make('judul')
                    ->label('Judul Buku')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('pengarang')
                    ->label('Pengarang')
                    ->searchable(),

                Tables\Columns\TextColumn::make('kategori')
                    ->label('Kategori'),

                Tables\Columns\TextColumn::make('stok')
                    ->label('Stok')
                    ->sortable(),
            ])
            ->actions([
                Actions\EditAction::make(),
                Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListLibraryBooks::route('/'),
            'create' => Pages\CreateLibraryBook::route('/create'),
            'edit'   => Pages\EditLibraryBook::route('/{record}/edit'),
        ];
    }
}
