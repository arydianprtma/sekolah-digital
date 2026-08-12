<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactMessageResource\Pages;
use App\Filament\Resources\ContactMessageResource\RelationManagers;
use App\Mail\ReplyContactMessageMail;
use App\Models\ContactMessage;
use App\Models\ContactMessageReply;
use Filament\Forms;
use Filament\Schemas\Components as SchemaComponents;
use Filament\Schemas\Schema;
use App\Filament\Traits\HasRoleVisibility;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Mail;

class ContactMessageResource extends Resource
{
    use HasRoleVisibility;

    protected static array $allowedRoles = ['Super Admin', 'admin'];

    protected static ?string $model = ContactMessage::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-envelope';

    protected static \UnitEnum|string|null $navigationGroup = 'Layanan & Keuangan';

    protected static ?string $parentItem = null;

    protected static ?string $modelLabel = 'Pesan Masuk';

    protected static ?string $pluralModelLabel = 'Kotak Masuk Pesan';

    protected static ?int $navigationSort = 4;

    public static function getNavigationBadge(): ?string
    {
        $count = ContactMessage::where('status', 'baru')->count();
        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                SchemaComponents\Section::make('Rincian Pesan Pengunjung')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Pengirim')
                            ->disabled(),

                        Forms\Components\TextInput::make('email')
                            ->label('Email Pengirim')
                            ->disabled(),

                        Forms\Components\TextInput::make('subject')
                            ->label('Subjek Pesan')
                            ->disabled(),

                        Forms\Components\Select::make('status')
                            ->label('Status Pesan')
                            ->options([
                                'baru'        => 'Baru',
                                'dibaca'      => 'Sudah Dibaca',
                                'dibalas'     => 'Sudah Dibalas',
                                'diarsipkan'  => 'Diarsipkan',
                            ])
                            ->required(),

                        Forms\Components\Textarea::make('message')
                            ->label('Isi Pesan')
                            ->rows(5)
                            ->disabled()
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('ip_address')
                            ->label('Alamat IP')
                            ->disabled(),

                        Forms\Components\DateTimePicker::make('created_at')
                            ->label('Waktu Dikirim')
                            ->disabled(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),

                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Pengirim')
                    ->searchable(),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),

                Tables\Columns\TextColumn::make('subject')
                    ->label('Subjek')
                    ->searchable()
                    ->limit(40),

                Tables\Columns\TextColumn::make('replies_count')
                    ->counts('replies')
                    ->label('Balasan')
                    ->badge()
                    ->color('info'),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'baru'       => 'Baru',
                        'dibaca'     => 'Sudah Dibaca',
                        'dibalas'    => 'Sudah Dibalas',
                        'diarsipkan' => 'Diarsipkan',
                        default      => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'baru'       => 'danger',
                        'dibaca'     => 'warning',
                        'dibalas'    => 'success',
                        'diarsipkan' => 'gray',
                        default      => 'gray',
                    }),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                Actions\Action::make('balas')
                    ->label('Balas')
                    ->icon('heroicon-o-paper-airplane')
                    ->color('primary')
                    ->form([
                        Forms\Components\Textarea::make('body')
                            ->label('Isi Balasan')
                            ->required()
                            ->rows(5)
                            ->placeholder('Tulis balasan Anda di sini...'),
                    ])
                    ->action(function (ContactMessage $record, array $data): void {
                        ContactMessageReply::create([
                            'contact_message_id' => $record->id,
                            'user_id'            => auth()->id(),
                            'body'               => $data['body'],
                        ]);

                        Mail::to($record->email)->send(new ReplyContactMessageMail(
                            contactMessage: $record,
                            replyBody: $data['body'],
                            repliedBy: auth()->user()->name,
                        ));

                        $record->markAsReplied();

                        Notification::make()
                            ->title('Balasan berhasil dikirim')
                            ->body('Email balasan telah dikirim ke ' . $record->email)
                            ->success()
                            ->send();
                    }),

                Actions\EditAction::make()->label('Detail'),
                Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\RepliesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContactMessages::route('/'),
            'edit'  => Pages\EditContactMessage::route('/{record}/edit'),
        ];
    }
}
