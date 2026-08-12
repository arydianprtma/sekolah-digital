<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Auth\Pages\EditProfile as BaseEditProfile;

class CustomEditProfile extends BaseEditProfile
{
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(['default' => 1, 'md' => 2, 'lg' => 3])
                    ->schema([
                        Section::make('Informasi Akun')
                            ->description('Ubah detail akun dan kata sandi Anda.')
                            ->columnSpan(['default' => 1, 'md' => 1, 'lg' => 1])
                            ->schema([
                                FileUpload::make('avatar_url')
                                    ->label('Foto Profil (Avatar)')
                                    ->image()
                                    ->disk('public')
                                    ->directory('avatars')
                                    ->maxSize(2048)
                                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/gif'])
                                    ->avatar()
                                    ->alignCenter(),
                                $this->getNameFormComponent(),
                                $this->getEmailFormComponent(),
                                $this->getPasswordFormComponent(),
                                $this->getPasswordConfirmationFormComponent(),
                            ]),
                        
                        Section::make('Data Diri Siswa')
                            ->description('Lengkapi data diri Anda sebagai siswa.')
                            ->relationship('student')
                            ->columnSpan(['default' => 1, 'md' => 1, 'lg' => 2])
                            ->columns(['default' => 1, 'md' => 2])
                            ->schema([
                                TextInput::make('nisn')
                                    ->label('NISN')
                                    ->numeric()
                                    ->maxLength(10),
                                TextInput::make('nis')
                                    ->label('NIS')
                                    ->numeric()
                                    ->maxLength(10),
                                TextInput::make('nama_lengkap')
                                    ->label('Nama Lengkap')
                                    ->required(),
                                Select::make('jenis_kelamin')
                                    ->label('Jenis Kelamin')
                                    ->options([
                                        'L' => 'Laki-laki',
                                        'P' => 'Perempuan',
                                    ])
                                    ->required(),
                                TextInput::make('tempat_lahir')
                                    ->label('Tempat Lahir'),
                                DatePicker::make('tanggal_lahir')
                                    ->label('Tanggal Lahir'),
                                TextInput::make('agama')
                                    ->label('Agama'),
                                Textarea::make('alamat')
                                    ->label('Alamat Lengkap')
                                    ->columnSpanFull(),
                                TextInput::make('no_telp')
                                    ->label('No. Telepon/HP')
                                    ->tel(),
                                TextInput::make('asal_sekolah')
                                    ->label('Asal Sekolah'),
                                TextInput::make('nama_ayah')
                                    ->label('Nama Ayah'),
                                TextInput::make('nama_ibu')
                                    ->label('Nama Ibu'),
                                TextInput::make('pekerjaan_ayah')
                                    ->label('Pekerjaan Ayah'),
                                TextInput::make('pekerjaan_ibu')
                                    ->label('Pekerjaan Ibu'),
                                TextInput::make('no_telp_ortu')
                                    ->label('No. Telepon Orang Tua')
                                    ->tel(),
                            ])
                            ->visible(fn () => auth()->user()->hasRole('siswa')),

                        Section::make('Data Profil Guru / Staf')
                            ->description('Lengkapi profil Anda.')
                            ->relationship('teacher')
                            ->columnSpan(['default' => 1, 'md' => 1, 'lg' => 2])
                            ->columns(['default' => 1, 'md' => 2])
                            ->schema([
                                TextInput::make('nip')
                                    ->label('NIP/NIG')
                                    ->required(),
                                TextInput::make('nuptk')
                                    ->label('NUPTK'),
                                TextInput::make('name')
                                    ->label('Nama Lengkap dengan Gelar')
                                    ->required(),
                                TextInput::make('position')
                                    ->label('Jabatan / Posisi')
                                    ->required(),
                                TextInput::make('subject')
                                    ->label('Mata Pelajaran yang Diampu'),
                                FileUpload::make('photo')
                                    ->label('Foto Profil')
                                    ->image()
                                    ->disk('public')
                                    ->directory('teacher_photos')
                                    ->maxSize(2048)
                                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/gif'])
                                    ->avatar(),
                            ])
                            ->visible(fn () => auth()->user()->hasRole('guru')),
                    ]),
            ]);
    }
}
