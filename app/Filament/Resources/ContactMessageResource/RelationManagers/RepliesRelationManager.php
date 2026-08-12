<?php

namespace App\Filament\Resources\ContactMessageResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class RepliesRelationManager extends RelationManager
{
    protected static string $relationship = 'replies';

    protected static ?string $title = 'Riwayat Balasan';

    public function table(Table $table): Table
    {
        return $table
            ->heading('Riwayat Balasan')
            ->description('Semua balasan yang telah dikirim untuk pesan ini')
            ->emptyStateHeading('Belum ada balasan')
            ->emptyStateDescription('Gunakan tombol "Kirim Balasan" di atas untuk membalas pesan ini.')
            ->emptyStateIcon('heroicon-o-chat-bubble-left-right')
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Waktu')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Dibalas Oleh')
                    ->badge()
                    ->color('primary'),

                Tables\Columns\TextColumn::make('body')
                    ->label('Isi Balasan')
                    ->wrap(),
            ])
            ->defaultSort('created_at', 'asc')
            ->paginated(false)
            ->headerActions([])
            ->actions([])
            ->bulkActions([]);
    }
}
