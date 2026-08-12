<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DocumentResource\Pages;
use App\Models\Document;
use Filament\Forms;
use Filament\Schemas\Components as SchemaComponents;
use Filament\Schemas\Schema;
use App\Filament\Traits\HasRoleVisibility;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions;
use Illuminate\Support\Str;

class DocumentResource extends Resource
{
    use HasRoleVisibility;

    protected static array $allowedRoles = ['admin', 'operator'];

    protected static ?string $model = Document::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-document-arrow-down';

    protected static \UnitEnum|string|null $navigationGroup = 'Pusat Dokumen';

    protected static ?string $modelLabel = 'Dokumen';

    protected static ?string $pluralModelLabel = 'Pusat Dokumen Publik';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                SchemaComponents\Section::make('Informasi Dokumen')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Judul Dokumen')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),

                        Forms\Components\TextInput::make('slug')
                            ->label('Slug URL')
                            ->required()
                            ->maxLength(255)
                            ->unique(Document::class, 'slug', ignoreRecord: true),

                        Forms\Components\TextInput::make('category')
                            ->label('Kategori Dokumen (cth: Akademik, PPDB, Panduan)')
                            ->required()
                            ->default('Umum'),

                        Forms\Components\TextInput::make('year')
                            ->label('Tahun Dokumen')
                            ->numeric()
                            ->default(date('Y')),

                        Forms\Components\FileUpload::make('file_path')
                            ->label('Berkas Dokumen (PDF, DOCX, XLSX)')
                            ->required()
                            ->disk('public')
                            ->directory('documents')
                            ->downloadable()
                            ->maxSize(10240)
                            ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet']),

                        Forms\Components\TextInput::make('file_size')
                            ->label('Keterangan Ukuran File (cth: 1.5 MB)'),

                        Forms\Components\Textarea::make('description')
                            ->label('Keterangan / Deskripsi Dokumen')
                            ->rows(3)
                            ->columnSpanFull(),

                        Forms\Components\DateTimePicker::make('published_at')
                            ->label('Tanggal Dipublikasikan')
                            ->default(now()),

                        Forms\Components\Toggle::make('status')
                            ->label('Status Publik')
                            ->default(true),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul Dokumen')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('category')
                    ->label('Kategori')
                    ->badge(),

                Tables\Columns\TextColumn::make('year')
                    ->label('Tahun'),

                Tables\Columns\TextColumn::make('file_size')
                    ->label('Ukuran File'),

                Tables\Columns\TextColumn::make('download_count')
                    ->label('Diunduh')
                    ->numeric()
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
            'index' => Pages\ListDocuments::route('/'),
            'create' => Pages\CreateDocument::route('/create'),
            'edit' => Pages\EditDocument::route('/{record}/edit'),
        ];
    }
}
