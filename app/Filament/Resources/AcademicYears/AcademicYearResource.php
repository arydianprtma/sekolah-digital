<?php

namespace App\Filament\Resources\AcademicYears;

use App\Filament\Resources\AcademicYears\Pages\ManageAcademicYears;
use App\Models\AcademicYear;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AcademicYearResource extends Resource
{
    use \App\Filament\Traits\HasRoleVisibility;

    protected static array $allowedRoles = ['admin'];

    protected static ?string $model = AcademicYear::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-calendar-days';

    protected static \UnitEnum|string|null $navigationGroup = 'Akademik & Sekolah';
    
    protected static ?string $parentItem = 'Manajemen Akademik';

    protected static ?string $navigationLabel = 'Tahun Ajaran';

    protected static ?string $modelLabel = 'Tahun Ajaran';

    protected static ?int $navigationSort = 5;

    protected static ?string $recordTitleAttribute = 'tahun_ajaran';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('tahun_ajaran')
                    ->required(),
                Select::make('semester')
                    ->options(['ganjil' => 'Ganjil', 'genap' => 'Genap'])
                    ->default('ganjil')
                    ->required(),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('tahun_ajaran')
            ->columns([
                TextColumn::make('tahun_ajaran')
                    ->searchable(),
                TextColumn::make('semester')
                    ->badge(),
                IconColumn::make('is_active')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageAcademicYears::route('/'),
        ];
    }
}
