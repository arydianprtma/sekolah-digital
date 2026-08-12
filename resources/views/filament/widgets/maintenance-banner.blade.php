<x-filament-widgets::widget>
    <div style="background-color: #fffbe completed; background-color: #fef3c7; border: 1px solid #fcd34d; border-radius: 0.75rem; padding: 1rem 1.25rem; display: flex; align-items: flex-start; gap: 1rem;">
        <div style="flex-shrink: 0; margin-top: 0.125rem;">
            <div style="width: 2.25rem; height: 2.25rem; border-radius: 0.5rem; background-color: #fde68a; border: 1px solid #fcd34d; display: flex; align-items: center; justify-center: center;">
                <svg style="width: 1.25rem; height: 1.25rem; color: #d97706; display: block;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a1 1 0 01-1-1v-3a1 1 0 011-1h1a2 2 0 100-4H4a1 1 0 01-1-1V7a1 1 0 011-1h3a1 1 0 001-1V4z" />
                </svg>
            </div>
        </div>
        <div style="flex: 1 1 0%; min-width: 0;">
            <p style="font-size: 0.875rem; font-weight: 700; color: #92400e; margin: 0;">Mode Pemeliharaan Sedang Aktif</p>
            <p style="font-size: 0.875rem; color: #b45309; margin-top: 0.25rem; margin-bottom: 0;">
                {{ $this->getMaintenanceMessage() }}
            </p>
            <p style="font-size: 0.75rem; color: #d97706; margin-top: 0.5rem; margin-bottom: 0;">
                Pengunjung publik saat ini melihat banner peringatan di website. Nonaktifkan di
                <a href="{{ route('filament.portal.pages.manage-settings') }}" style="text-decoration: underline; font-weight: 600; color: #92400e;">
                    Pengaturan &amp; Maintenance
                </a>.
            </p>
        </div>
        <div style="flex-shrink: 0;">
            <span style="display: inline-flex; align-items: center; gap: 0.375rem; border-radius: 9999px; background-color: #fde68a; border: 1px solid #fcd34d; padding: 0.25rem 0.625rem; font-size: 0.75rem; font-weight: 600; color: #92400e;">
                <span style="width: 0.375rem; height: 0.375rem; border-radius: 9999px; background-color: #f59e0b;"></span>
                Aktif
            </span>
        </div>
    </div>
</x-filament-widgets::widget>
