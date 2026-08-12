<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SchoolProfileResource\Pages;
use App\Models\SchoolProfile;
use Filament\Forms;
use Filament\Schemas\Components as SchemaComponents;
use Filament\Schemas\Schema;
use App\Filament\Traits\HasRoleVisibility;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions;

class SchoolProfileResource extends Resource
{
    use HasRoleVisibility;

    protected static array $allowedRoles = ['admin'];

    protected static ?string $model = SchoolProfile::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-academic-cap';

    protected static \UnitEnum|string|null $navigationGroup = 'Profil & Fasilitas';

    protected static ?string $parentItem = null;

    protected static ?string $modelLabel = 'Profil Sekolah';

    protected static ?string $pluralModelLabel = 'Identitas & Profil';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                SchemaComponents\Section::make('Identitas Utama Sekolah')
                    ->schema([
                        Forms\Components\TextInput::make('school_name')
                            ->label('Nama Sekolah')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('npsn')
                            ->label('NPSN')
                            ->required()
                            ->maxLength(50),

                        Forms\Components\TextInput::make('accreditation')
                            ->label('Akreditasi (cth: Unggul / A)')
                            ->default('A'),

                        Forms\Components\TextInput::make('principal_name')
                            ->label('Nama Kepala Sekolah'),

                        Forms\Components\FileUpload::make('principal_photo')
                            ->label('Foto Kepala Sekolah')
                            ->image()
                            ->disk('public')
                            ->directory('profil')
                            ->maxSize(5120)
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/gif']),

                        Forms\Components\FileUpload::make('logo')
                            ->label('Logo Sekolah')
                            ->image()
                            ->disk('public')
                            ->directory('profil')
                            ->maxSize(5120)
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/svg+xml', 'image/webp']),
                    ])->columns(2),

                SchemaComponents\Section::make('Kontak & Alamat')
                    ->schema([
                        Forms\Components\Textarea::make('address')
                            ->label('Alamat Lengkap')
                            ->rows(3)
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('phone')
                            ->label('Nomor Telepon'),

                        Forms\Components\TextInput::make('email')
                            ->label('Email Resmi')
                            ->email(),

                        Forms\Components\TextInput::make('website')
                            ->label('URL Website Utama'),
                    ])->columns(3),

                SchemaComponents\Section::make('Sejarah, Visi, Misi & Sambutan')
                    ->schema([
                        Forms\Components\RichEditor::make('principal_greeting')
                            ->label('Sambutan Kepala Sekolah')
                            ->columnSpanFull(),

                        Forms\Components\RichEditor::make('history')
                            ->label('Sejarah Singkat Sekolah')
                            ->columnSpanFull(),

                        Forms\Components\RichEditor::make('vision')
                            ->label('Visi Sekolah')
                            ->columnSpanFull(),

                        Forms\Components\RichEditor::make('mission')
                            ->label('Misi Sekolah')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('logo')
                    ->label('Logo'),

                Tables\Columns\TextColumn::make('school_name')
                    ->label('Nama Sekolah')
                    ->searchable(),

                Tables\Columns\TextColumn::make('npsn')
                    ->label('NPSN'),

                Tables\Columns\TextColumn::make('accreditation')
                    ->label('Akreditasi')
                    ->badge(),

                Tables\Columns\TextColumn::make('principal_name')
                    ->label('Kepala Sekolah'),
            ])
            ->actions([
                Actions\EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSchoolProfiles::route('/'),
            'create' => Pages\CreateSchoolProfile::route('/create'),
            'edit' => Pages\EditSchoolProfile::route('/{record}/edit'),
        ];
    }
}
