<?php

namespace App\Filament\Resources\ContactMessageResource\Pages;

use App\Filament\Resources\ContactMessageResource;
use App\Mail\ReplyContactMessageMail;
use App\Models\ContactMessageReply;
use Filament\Actions;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Mail;

class EditContactMessage extends EditRecord
{
    protected static string $resource = ContactMessageResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $this->getRecord()->markAsRead();
        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('balas')
                ->label('Kirim Balasan')
                ->icon('heroicon-o-paper-airplane')
                ->color('primary')
                ->form([
                    Forms\Components\Textarea::make('body')
                        ->label('Isi Balasan')
                        ->required()
                        ->rows(6)
                        ->placeholder('Tulis balasan Anda di sini...'),
                ])
                ->action(function (array $data): void {
                    $record = $this->getRecord();

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

                    $this->refreshFormData(['status']);
                }),

            Actions\DeleteAction::make(),
        ];
    }

}
