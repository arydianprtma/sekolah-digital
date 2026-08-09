<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Schemas\Components as SchemaComponents;
use Filament\Schemas\Schema;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class ManageSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static \UnitEnum|string|null $navigationGroup = 'Sistem & Keamanan';

    protected static ?string $title = 'Pengaturan Sistem';

    protected static ?string $navigationLabel = 'Pengaturan & Maintenance';

    protected static ?int $navigationSort = 3;

    protected string $view = 'filament.pages.manage-settings';

    public static function canAccess(): bool
    {
        return auth()->user()?->hasRole('Super Admin') || auth()->user()?->hasRole('admin');
    }

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'maintenance_mode' => Setting::get('maintenance_mode', false),
            'maintenance_message' => Setting::get('maintenance_message', 'Website sedang dalam pemeliharaan berkala.'),
            'social_instagram' => Setting::get('social_instagram', ''),
            'social_facebook' => Setting::get('social_facebook', ''),
            'social_youtube' => Setting::get('social_youtube', ''),
            'seo_title' => Setting::get('seo_title', 'Digital School - CMS Portal'),
            'seo_description' => Setting::get('seo_description', 'Portal Resmi Sekolah Digital'),
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                SchemaComponents\Section::make('Mode Pemeliharaan (Maintenance Mode)')
                    ->description('Aktifkan untuk menampilkan halaman pemeliharaan kepada pengunjung publik.')
                    ->schema([
                        Forms\Components\Toggle::make('maintenance_mode')
                            ->label('Aktifkan Mode Pemeliharaan Publik'),

                        Forms\Components\Textarea::make('maintenance_message')
                            ->label('Pesan Pemeliharaan Publik')
                            ->rows(3),
                    ]),

                SchemaComponents\Section::make('Media Sosial Sekolah')
                    ->schema([
                        Forms\Components\TextInput::make('social_instagram')
                            ->label('URL Instagram'),

                        Forms\Components\TextInput::make('social_facebook')
                            ->label('URL Facebook'),

                        Forms\Components\TextInput::make('social_youtube')
                            ->label('URL YouTube'),
                    ])->columns(3),

                SchemaComponents\Section::make('Pengaturan SEO Global')
                    ->schema([
                        Forms\Components\TextInput::make('seo_title')
                            ->label('Default Title Tag'),

                        Forms\Components\Textarea::make('seo_description')
                            ->label('Default Meta Description')
                            ->rows(2),
                    ]),
            ])
            ->statePath('data');
    }

    public function submit(): void
    {
        $state = $this->form->getState();

        Setting::set('maintenance_mode', (bool) $state['maintenance_mode'], 'system');
        Setting::set('maintenance_message', $state['maintenance_message'], 'system');
        Setting::set('social_instagram', $state['social_instagram'], 'social');
        Setting::set('social_facebook', $state['social_facebook'], 'social');
        Setting::set('social_youtube', $state['social_youtube'], 'social');
        Setting::set('seo_title', $state['seo_title'], 'seo');
        Setting::set('seo_description', $state['seo_description'], 'seo');

        Notification::make()
            ->title('Pengaturan Berhasil Disimpan!')
            ->success()
            ->send();
    }
}
