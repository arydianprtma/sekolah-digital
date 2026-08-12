<?php

namespace App\Filament\Resources\AssignmentResource\RelationManagers;

use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Actions\Action;
use Filament\Actions\ViewAction;
use Illuminate\Database\Eloquent\Builder;

class SubmissionsRelationManager extends RelationManager
{
    protected static string $relationship = 'submissions';
    
    protected static ?string $title = 'Pengumpulan Tugas';
    protected static ?string $modelLabel = 'Pengumpulan Tugas';
    protected static ?string $pluralModelLabel = 'Pengumpulan Tugas';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\Select::make('student_id')
                    ->label('Siswa')
                    ->relationship('student', 'nama_lengkap')
                    ->required()
                    ->default(function () {
                        $user = auth()->user();
                        if ($user && $user->hasRole('siswa')) {
                            return \App\Models\Student::where('user_id', $user->id)->value('id');
                        }
                        return null;
                    })
                    ->disabled(fn () => auth()->user()?->hasRole('siswa'))
                    ->dehydrated(),
                
                Forms\Components\FileUpload::make('file_path')
                    ->label('File Jawaban / Tugas')
                    ->disk('public')
                    ->directory('assignment_submissions')
                    ->downloadable()
                    ->maxSize(15360)
                    ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/zip', 'application/x-zip-compressed', 'application/x-rar-compressed', 'image/jpeg', 'image/png']),

                Forms\Components\Textarea::make('catatan_siswa')
                    ->label('Catatan dari Siswa')
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('nilai')
                    ->label('Nilai')
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(100)
                    ->hidden(fn () => auth()->user()?->hasRole('siswa')),

                Forms\Components\Textarea::make('catatan_guru')
                    ->label('Catatan dari Guru')
                    ->columnSpanFull()
                    ->hidden(fn () => auth()->user()?->hasRole('siswa')),

                Forms\Components\DateTimePicker::make('created_at')
                    ->label('Waktu Pengumpulan')
                    ->disabled()
                    ->hidden(fn () => auth()->user()?->hasRole('siswa')),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('student.nama_lengkap')
            ->modifyQueryUsing(function (Builder $query) {
                if (auth()->user()?->hasRole('siswa')) {
                    return $query->whereHas('student', function ($q) {
                        $q->where('user_id', auth()->id());
                    });
                }
                return $query;
            })
            ->columns([
                TextColumn::make('student.nama_lengkap')
                    ->label('Siswa')
                    ->searchable(),
                TextColumn::make('nilai')
                    ->label('Nilai')
                    ->sortable()
                    ->badge()
                    ->color(fn ($state) => $state === null ? 'warning' : ($state >= 75 ? 'success' : 'danger'))
                    ->formatStateUsing(fn ($state) => $state === null ? 'Belum Dinilai' : $state),
                TextColumn::make('created_at')
                    ->label('Disubmit Pada')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([
                \Filament\Tables\Filters\SelectFilter::make('kelas')
                    ->label('Filter Kelas')
                    ->relationship('student.classroom', 'nama_kelas')
                    ->searchable()
                    ->preload()
                    ->hidden(fn () => auth()->user()?->hasRole('siswa')),
            ])
            ->headerActions([
                \Filament\Actions\Action::make('kumpulkan_tugas_manual')
                    ->label('Kumpulkan Tugas')
                    ->url(fn () => \App\Filament\Resources\AssignmentSubmissionResource::getUrl('create') . '?assignment_id=' . $this->getOwnerRecord()->id)
                    ->visible(fn() => auth()->user()?->hasRole('siswa'))
            ])
            ->recordActions([
                \Filament\Actions\ViewAction::make()
                    ->modalHeading('Lihat Pengumpulan Tugas'),
                \Filament\Actions\Action::make('beri_nilai')
                    ->label('Beri Nilai')
                    ->icon('heroicon-o-check-badge')
                    ->color('success')
                    ->visible(fn () => !auth()->user()?->hasRole('siswa'))
                    ->modalHeading('Penilaian Tugas')
                    ->modalDescription(fn ($record) => 'Berikan nilai untuk: ' . ($record->student?->nama_lengkap ?? '-'))
                    ->modalIcon('heroicon-o-academic-cap')
                    ->modalIconColor('success')
                    ->fillForm(fn ($record) => [
                        'nilai' => $record->nilai,
                        'catatan_guru' => $record->catatan_guru,
                    ])
                    ->form([
                        Forms\Components\TextInput::make('nilai')
                            ->label('Nilai')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100)
                            ->required()
                            ->suffix('/ 100')
                            ->placeholder('Masukkan nilai 0-100'),
                        Forms\Components\Textarea::make('catatan_guru')
                            ->label('Catatan dari Guru')
                            ->placeholder('Tuliskan feedback atau catatan untuk siswa...')
                            ->rows(3),
                    ])
                    ->modalSubmitActionLabel('Simpan Nilai')
                    ->action(function ($record, array $data): void {
                        $record->update([
                            'nilai' => $data['nilai'],
                            'catatan_guru' => $data['catatan_guru'],
                        ]);

                        \Filament\Notifications\Notification::make()
                            ->success()
                            ->title('Nilai Berhasil Disimpan')
                            ->body('Nilai untuk ' . ($record->student?->nama_lengkap ?? 'siswa') . ' telah diperbarui.')
                            ->send();
                    }),
            ])
            ->bulkActions([
                //
            ]);
    }
}
