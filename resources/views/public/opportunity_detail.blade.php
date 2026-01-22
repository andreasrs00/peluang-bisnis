@extends('layouts.public')

@section('content')
{{-- Leaflet --}}
<link
    rel="stylesheet"
    href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
    crossorigin=""
/>
<script
    src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
    crossorigin=""
></script>

@php
    $imgUrl = !empty($item->image_path) ? asset('storage/'.$item->image_path) : '';
@endphp

<div class="w-full mx-auto px-4 py-6">
    <div class="max-w-6xl mx-auto">

        {{-- TOP BAR --}}
        <div class="flex items-start justify-between gap-4">
            <div>
                <p class="text-[11px] font-semibold tracking-widest text-brand-primary uppercase">Detail Peluang Bisnis</p>
                <h1 class="mt-1 text-2xl sm:text-3xl font-extrabold tracking-tight text-gray-900">
                    {{ $item->product_name }}
                </h1>
                <p class="mt-1 text-sm text-gray-500">
                    Informasi lengkap + lokasi pada peta.
                </p>
            </div>

            <a href="{{ route('opportunities.index') }}"
               class="inline-flex items-center gap-2 rounded-xl border border-brand-neutral bg-white px-4 py-2 text-sm font-bold text-gray-700
                      hover:bg-gray-50 hover:border-brand-primary/30 transition">
                ← Kembali
            </a>
        </div>

        <div class="mt-6 grid grid-cols-1 lg:grid-cols-12 gap-6">

            {{-- LEFT --}}
            <div class="lg:col-span-7">
                <div class="overflow-hidden rounded-2xl border border-brand-neutral bg-white shadow-sm">
                    <div class="aspect-[16/9] bg-gray-50">
                        @if($imgUrl)
                            <img src="{{ $imgUrl }}"
                                 alt="Gambar {{ $item->product_name }}"
                                 class="h-full w-full object-cover"
                                 loading="lazy">
                        @else
                            <div class="h-full w-full flex items-center justify-center text-sm font-semibold text-gray-500">
                                Tidak ada gambar
                            </div>
                        @endif
                    </div>

                    <div class="p-5">
                        <div class="flex flex-wrap gap-2">
                            @if(!empty($item->category))
                                <span class="rounded-full bg-brand-soft/15 border border-brand-neutral px-3 py-1 text-xs font-semibold text-brand-primary">
                                    {{ $item->category }}
                                </span>
                            @endif

                            @if((int)($item->is_featured ?? 0) === 1)
                                <span class="rounded-full border border-yellow-200 bg-yellow-50 px-3 py-1 text-xs font-semibold text-yellow-700">
                                    ⭐ Unggulan
                                </span>
                            @endif

                            @if(!empty($item->partner_need))
                                <span class="rounded-full border border-brand-primary/20 bg-brand-soft/15 px-3 py-1 text-xs font-semibold text-brand-primary">
                                    🤝 {{ $item->partner_need }}
                                </span>
                            @endif
                        </div>

                        <div class="mt-4 space-y-2 text-sm text-gray-600">
                            @if($item->social_media)
                                <div class="truncate">📣 {{ $item->social_media }}</div>
                            @endif
                            @if($item->website)
                                <div class="truncate">
                                    🌐 <a href="{{ $item->website }}" target="_blank" rel="noopener"
                                          class="font-bold text-brand-primary hover:underline">
                                          {{ $item->website }}
                                    </a>
                                </div>
                            @endif
                        </div>

                        <div class="mt-4 grid grid-cols-2 gap-3">
                            <div class="rounded-xl border border-brand-neutral bg-gray-50 p-3">
                                <div class="text-[11px] font-semibold text-gray-500">Latitude</div>
                                <div class="mt-1 text-sm font-extrabold text-gray-900">{{ $item->lat }}</div>
                            </div>
                            <div class="rounded-xl border border-brand-neutral bg-gray-50 p-3">
                                <div class="text-[11px] font-semibold text-gray-500">Longitude</div>
                                <div class="mt-1 text-sm font-extrabold text-gray-900">{{ $item->lng }}</div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- RIGHT: MAP --}}
            <div class="lg:col-span-5">
                <div class="rounded-2xl border border-brand-neutral bg-white p-5 shadow-sm">
                    <div class="text-sm font-extrabold text-gray-900">Lokasi</div>

                    <div class="mt-3 overflow-hidden rounded-xl border border-brand-neutral bg-white">
                        <div id="detailMap" class="h-[360px] w-full"></div>
                    </div>

                    <div class="mt-3 text-xs text-gray-500">
                        Klik marker untuk lihat nama bisnis.
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const lat = parseFloat(@json($item->lat));
    const lng = parseFloat(@json($item->lng));
    const name = @json($item->product_name ?? 'Lokasi');

    const center = (Number.isFinite(lat) && Number.isFinite(lng)) ? [lat, lng] : [3.5952, 98.6722];
    const zoom   = (Number.isFinite(lat) && Number.isFinite(lng)) ? 15 : 12;

    const m = L.map('detailMap', { scrollWheelZoom: false }).setView(center, zoom);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(m);

    if (Number.isFinite(lat) && Number.isFinite(lng)) {
        L.marker([lat, lng]).addTo(m).bindPopup(`<b>${String(name).replaceAll('<','&lt;').replaceAll('>','&gt;')}</b>`).openPopup();
    }

    setTimeout(() => m.invalidateSize(), 150);
});
</script>
@endsection
