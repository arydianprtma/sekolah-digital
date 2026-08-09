<?php

namespace App\Filament\Resources\AssignmentResource\RelationManagers;

use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Actions\Action;
use Filament\Actions\ViewAction;
use Illuminate\Database\Eloquent\Builder;

class SubmissionsRelationManager extends RelationManager
{
    protected static string $relationship = 'submissions';
    
    protected static ?string $title = 'Pengumpulan Tugas';

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
                    ->directory('assignment_submissions')
                    ->downloadable(),

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
                \Filament\Actions\CreateAction::make()
                    ->label('Kumpulkan Tugas')
                    ->hidden(function () {
                        // Jika bukan siswa, sembunyikan CreateAction
                        if (!auth()->user()?->hasRole('siswa')) return true;
                        
                        // Jika siswa sudah pernah mengumpulkan, sembunyikan
                        $student = \App\Models\Student::where('user_id', auth()->id())->first();
                        if (!$student) return true;
                        return $this->getOwnerRecord()->submissions()->where('student_id', $student->id)->exists();
                    }),
            ])
            ->recordActions([
                \Filament\Actions\ViewAction::make(),
                \Filament\Actions\Action::make('beri_nilai')
                    ->label('Beri Nilai')
                    ->icon('heroicon-o-check-badge')
                    ->color('success')
                    ->visible(fn () => !auth()->user()?->hasRole('siswa')) // Hanya Guru/Admin
                    ->form([
                        Forms\Components\TextInput::make('nilai')
                            ->label('Nilai')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100)
                            ->required(),
                        Forms\Components\Textarea::make('catatan_guru')
                            ->label('Catatan dari Guru (Opsional)'),
                    ])
                    ->action(function ($record, array $data): void {
                        $record->update([
                            'nilai' => $data['nilai'],
                            'catatan_guru' => $data['catatan_guru'],
                        ]);
                    }),
            ])
            ->bulkActions([
                //
            ]);
    }
}
