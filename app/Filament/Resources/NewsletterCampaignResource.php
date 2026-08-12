<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NewsletterCampaignResource\Pages;
use App\Models\NewsletterCampaign;
use Filament\Actions;
use Filament\Forms;
use Filament\Schemas\Schema;
use App\Filament\Traits\HasRoleVisibility;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class NewsletterCampaignResource extends Resource
{
    use HasRoleVisibility;

    protected static array $allowedRoles = ['admin'];

    protected static ?string $model = NewsletterCampaign::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-paper-airplane';

    protected static \UnitEnum|string|null $navigationGroup = 'Layanan & Keuangan';

    protected static ?string $parentItem = null;

    protected static ?string $navigationLabel = 'Kirim Email Massal';

    protected static ?string $modelLabel = 'Pesan Email';

    protected static ?string $pluralModelLabel = 'Kirim Email Massal';

    protected static ?int $navigationSort = 6;

    public static function form(Schema $form): Schema
    {
        return $form->schema([
            Forms\Components\TextInput::make('subjek')
                ->label('Subjek Email')
                ->required()
                ->maxLength(255)
                ->columnSpanFull(),

            Forms\Components\RichEditor::make('konten')
                ->label('Isi Newsletter')
                ->required()
                ->columnSpanFull(),

            Forms\Components\Select::make('status')
                ->label('Status')
                ->options([
                    'draft'      => 'Draft',
                    'terjadwal'  => 'Terjadwal',
                    'terkirim'   => 'Terkirim',
                ])
                ->default('draft'),

            Forms\Components\DateTimePicker::make('dijadwalkan_pada')
                ->label('Jadwal Kirim'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('subjek')
                    ->label('Subjek')
                    ->searchable()
                    ->limit(60),

                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'gray'    => 'draft',
                        'warning' => 'terjadwal',
                        'success' => 'terkirim',
                    ]),

                Tables\Columns\TextColumn::make('jumlah_penerima')
                    ->label('Penerima'),

                Tables\Columns\TextColumn::make('jumlah_terkirim')
                    ->label('Terkirim'),

                Tables\Columns\TextColumn::make('dijadwalkan_pada')
                    ->label('Dijadwalkan')
                    ->dateTime('d M Y H:i')
                    ->sortable(),

                Tables\Columns\TextColumn::make('dikirim_pada')
                    ->label('Dikirim')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
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
            'index'  => Pages\ListNewsletterCampaigns::route('/'),
            'create' => Pages\CreateNewsletterCampaign::route('/create'),
            'edit'   => Pages\EditNewsletterCampaign::route('/{record}/edit'),
        ];
    }
}
