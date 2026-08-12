<?php

namespace App\Filament\Resources\ContactMessageResource\Widgets;

use App\Models\ContactMessageReply;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class ReplyHistoryWidget extends BaseWidget
{
    public ?int $recordId = null;

    protected function getTableQuery(): Builder
    {
        $id = $this->recordId ?? request()->route('record');

        return ContactMessageReply::query()
            ->where('contact_message_id', $id)
            ->with('user')
            ->latest();
    }

    public function table(Table $table): Table
    {
        return $table
            ->query($this->getTableQuery())
            ->heading('Riwayat Balasan')
            ->description('Semua balasan yang telah dikirim untuk pesan ini')
            ->emptyStateHeading('Belum ada balasan')
            ->emptyStateDescription('Gunakan tombol "Kirim Balasan" untuk membalas pesan ini.')
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
                    ->wrap()
                    ->limit(200),
            ])
            ->defaultSort('created_at', 'asc')
            ->paginated(false);
    }
}
