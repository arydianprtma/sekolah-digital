<x-filament-panels::page>
    <style>
        .analytics-grid { display: grid; gap: 1rem; grid-template-columns: repeat(1, 1fr); }
        @media (min-width: 640px) { .analytics-grid { grid-template-columns: repeat(4, 1fr); } }
        .analytics-card { padding: 1.25rem; border-radius: 0.75rem; border: 1px solid var(--gray-200); background-color: white; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); }
        .dark .analytics-card { background-color: var(--gray-900); border-color: var(--gray-700); }
        .analytics-card-title { font-size: 0.875rem; color: var(--gray-500); }
        .dark .analytics-card-title { color: var(--gray-400); }
        .analytics-card-value { margin-top: 0.25rem; font-size: 1.875rem; font-weight: 700; color: var(--primary-600); }
        .analytics-card.green { background-color: #f0fdf4; border-color: #bbf7d0; }
        .dark .analytics-card.green { background-color: rgba(20, 83, 45, 0.2); border-color: #15803d; }
        .analytics-card.green .analytics-card-title { color: #15803d; }
        .analytics-card.green .analytics-card-value { color: #15803d; }
        .dark .analytics-card.green .analytics-card-title { color: #4ade80; }
        .dark .analytics-card.green .analytics-card-value { color: #86efac; }
        .analytics-card.orange { background-color: #fff7ed; border-color: #fed7aa; }
        .dark .analytics-card.orange { background-color: rgba(124, 45, 18, 0.2); border-color: #c2410c; }
        .analytics-card.orange .analytics-card-title { color: #c2410c; }
        .analytics-card.orange .analytics-card-value { color: #c2410c; }
        .dark .analytics-card.orange .analytics-card-title { color: #fb923c; }
        .dark .analytics-card.orange .analytics-card-value { color: #fdba74; }
        .list-row { display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 1.5rem; border-bottom: 1px solid var(--gray-100); }
        .dark .list-row { border-bottom-color: var(--gray-700); }
        .list-row:last-child { border-bottom: none; }
        .badge { display: inline-block; padding: 0.125rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600; background-color: var(--primary-100); color: var(--primary-700); }
        .dark .badge { background-color: var(--primary-900); color: var(--primary-300); }
    </style>
    
    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
        {{-- Stats Grid --}}
        <div class="analytics-grid">
            <div class="analytics-card">
                <p class="analytics-card-title">Kunjungan Hari Ini</p>
                <p class="analytics-card-value">{{ number_format($viewsHariIni) }}</p>
            </div>
            <div class="analytics-card">
                <p class="analytics-card-title">7 Hari Terakhir</p>
                <p class="analytics-card-value">{{ number_format($views7Hari) }}</p>
            </div>
            <div class="analytics-card">
                <p class="analytics-card-title">30 Hari Terakhir</p>
                <p class="analytics-card-value">{{ number_format($views30Hari) }}</p>
            </div>
            <div class="analytics-card">
                <p class="analytics-card-title">Total Kunjungan</p>
                <p class="analytics-card-value">{{ number_format($totalViews) }}</p>
            </div>
        </div>

        {{-- Second row: Subscribers & Messages --}}
        <div class="analytics-grid">
            <div class="analytics-card green">
                <p class="analytics-card-title">Subscriber Aktif</p>
                <p class="analytics-card-value">{{ number_format($totalSubscriber) }}</p>
            </div>
            <div class="analytics-card green">
                <p class="analytics-card-title">Subscriber Baru (30hr)</p>
                <p class="analytics-card-value">{{ number_format($subscriberBaru) }}</p>
            </div>
            <div class="analytics-card orange">
                <p class="analytics-card-title">Pesan Kontak Baru</p>
                <p class="analytics-card-value">{{ number_format($pesanBaru) }}</p>
            </div>
            <div class="analytics-card">
                @php $p = $perangkat; @endphp
                <p class="analytics-card-title">Perangkat (30hr)</p>
                <div style="margin-top: 0.5rem; display: flex; flex-direction: column; gap: 0.25rem; font-size: 0.875rem;">
                    <div style="display: flex; justify-content: space-between;"><span>Desktop</span><span style="font-weight: 600;">{{ number_format($p['desktop'] ?? 0) }}</span></div>
                    <div style="display: flex; justify-content: space-between;"><span>Mobile</span><span style="font-weight: 600;">{{ number_format($p['mobile'] ?? 0) }}</span></div>
                    <div style="display: flex; justify-content: space-between;"><span>Tablet</span><span style="font-weight: 600;">{{ number_format($p['tablet'] ?? 0) }}</span></div>
                </div>
            </div>
        </div>

        {{-- Halaman Populer --}}
        <x-filament::section>
            <x-slot name="heading">
                Halaman Paling Banyak Dikunjungi (30 Hari)
            </x-slot>

            <div style="margin: -1.5rem;">
                @forelse($halamanPopuler as $halaman)
                    <div class="list-row">
                        <span style="font-size: 0.875rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 70%;">/{{ $halaman->url }}</span>
                        <span class="badge">
                            {{ number_format($halaman->total) }} kunjungan
                        </span>
                    </div>
                @empty
                    <div class="list-row">
                        <span style="font-size: 0.875rem; color: var(--gray-500);">Belum ada data kunjungan.</span>
                    </div>
                @endforelse
            </div>
        </x-filament::section>
    </div>
</x-filament-panels::page>
