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
    $categoryList = [
        'Pangan',
        'Sandang',
        'Manufaktur',
        'Teknologi Informasi',
        'Material Maju',
        'Kesehatan & kosmetik',
        'Jasa Lainnya',
    ];

    // ✅ 1 sumber kebenaran untuk style kategori (dipakai card + marker)
    $categoryMeta = [
        'Pangan'               => ['color' => '#16a34a', 'label' => 'Pa', 'emoji' => '🍃'],
        'Sandang'              => ['color' => '#db2777', 'label' => 'Sa', 'emoji' => '👕'],
        'Manufaktur'           => ['color' => '#f59e0b', 'label' => 'Mn', 'emoji' => '🏭'],
        'Teknologi Informasi'  => ['color' => '#2563eb', 'label' => 'TI', 'emoji' => '💻'],
        'Material Maju'        => ['color' => '#7c3aed', 'label' => 'MM', 'emoji' => '🧪'],
        'Kesehatan & kosmetik' => ['color' => '#ef4444', 'label' => 'Ks', 'emoji' => '🩺'],
        'Jasa Lainnya'         => ['color' => '#0f766e', 'label' => 'Js', 'emoji' => '🛠️'],
        '__default__'          => ['color' => '#111827', 'label' => '•',  'emoji' => '📍'],
    ];

    $categoryOptions = collect($items)
        ->pluck('category')
        ->filter()
        ->map(fn($x) => trim((string)$x))
        ->unique()
        ->values();

    $hasFeatured = collect($items)->contains(fn($x) => (int)($x->is_featured ?? 0) === 1);

    $partnerOptions = collect($items)
        ->pluck('partner_need')
        ->filter()
        ->map(fn($x) => trim((string)$x))
        ->unique()
        ->values();

    $partnerList = ['Investor','Reseller','Distributor','Buyer'];
@endphp

<div class="w-full mx-auto px-4 py-4">
    {{-- GRID 2 kolom (desktop), 1 kolom (mobile) --}}
    <div class="grid grid-cols-1 lg:grid-cols-[320px_1fr] gap-4">

        {{-- LEFT TOP: KATEGORI --}}
        <aside class="order-1">
            <div class="rounded-2xl border border-brand-neutral bg-white p-4 shadow-sm">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <div class="text-sm font-extrabold text-gray-900">Filter Kategori</div>
                        <div class="mt-0.5 text-xs text-gray-500">Mempengaruhi Peluang Bisnis & Map</div>
                    </div>

                    <button id="resetCategory" type="button"
                        class="rounded-xl border border-brand-neutral bg-white px-3 py-2 text-xs font-bold text-gray-700
                               hover:border-brand-primary/30 hover:bg-brand-soft/10 hover:text-brand-primary
                               focus:outline-none focus:ring-2 focus:ring-brand-primary/20 transition">
                        Reset
                    </button>
                </div>

                <div class="mt-4 flex flex-col gap-2" id="categoryWrap">
                    <button type="button"
                        class="cat-chip cat-active w-full rounded-xl border border-brand-primary bg-brand-primary px-3 py-2.5 text-left text-xs font-bold text-white"
                        data-category="__all__">
                        Semua
                    </button>

                    <button type="button"
                        class="cat-chip w-full rounded-xl border border-brand-neutral bg-white px-3 py-2.5 text-left text-xs font-bold text-gray-700
                               hover:bg-gray-50 hover:border-brand-primary/30 hover:text-gray-900
                               disabled:cursor-not-allowed disabled:opacity-60 transition"
                        data-category="__featured__"
                        {{ $hasFeatured ? '' : 'disabled' }}>
                        ⭐ Unggulan
                        @if(!$hasFeatured)
                            <span class="ml-1 text-[10px] text-gray-400">(0)</span>
                        @endif
                    </button>

                    @foreach($categoryList as $cat)
                        @php
                            $available = $categoryOptions->contains($cat);
                            $meta = $categoryMeta[$cat] ?? $categoryMeta['__default__'];
                        @endphp

                        <button type="button"
                            class="cat-chip w-full rounded-xl border border-brand-neutral bg-white px-3 py-2.5 text-left text-xs font-bold text-gray-700
                                   hover:bg-gray-50 hover:border-brand-primary/30 hover:text-gray-900
                                   disabled:cursor-not-allowed disabled:opacity-60 transition"
                            data-category="{{ $cat }}"
                            {{ $available ? '' : 'disabled' }}>
                            <span class="inline-flex items-center gap-2">
                                <span class="inline-block h-2.5 w-2.5 rounded-full" style="background: {{ $meta['color'] }}"></span>
                                {{ $cat }}
                                <span class="text-[10px] font-extrabold text-gray-400">({{ $meta['label'] }})</span>
                            </span>
                            @if(!$available)
                                <span class="ml-1 text-[10px] text-gray-400">(0)</span>
                            @endif
                        </button>
                    @endforeach
                </div>
            </div>
        </aside>

        {{-- RIGHT TOP: TITLE + MAP --}}
        <section class="order-2">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <p class="text-[11px] font-semibold tracking-widest text-brand-primary uppercase">Peta & Direktori</p>
                    <h1 class="mt-1 text-xl font-extrabold tracking-tight text-gray-900">Peluang Bisnis</h1>
                    <p class="mt-1 text-sm text-gray-500">Map mengikuti filter kategori. Card mengikuti kategori + mitra.</p>
                </div>

                <button id="resetAll" type="button"
                    class="rounded-xl bg-brand-primary px-3 py-2 text-xs font-bold text-white
                           hover:bg-brand-primary/90
                           focus:outline-none focus:ring-2 focus:ring-brand-primary/30 transition">
                    Reset Semua
                </button>
            </div>

            <div class="mt-3 overflow-hidden rounded-2xl border border-brand-neutral bg-white shadow-sm">
                <div id="map" class="h-[420px] w-full"></div>
            </div>
        </section>

        {{-- LEFT BOTTOM: MITRA --}}
        <aside class="order-3">
            <div class="rounded-2xl border border-brand-neutral bg-white p-4 shadow-sm">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <div class="text-sm font-extrabold text-gray-900">Filter Mencari Mitra</div>
                        <div class="mt-0.5 text-xs text-gray-500">Hanya mempengaruhi Card Bisnis</div>
                    </div>

                    <button id="resetPartner" type="button"
                        class="rounded-xl border border-brand-neutral bg-white px-3 py-2 text-xs font-bold text-gray-700
                               hover:border-brand-primary/30 hover:bg-brand-soft/10 hover:text-brand-primary
                               focus:outline-none focus:ring-2 focus:ring-brand-primary/20 transition">
                        Reset
                    </button>
                </div>

                <div class="mt-4 flex flex-col gap-2" id="partnerWrap">
                    <button type="button"
                        class="partner-chip partner-active w-full rounded-xl border border-brand-primary bg-brand-primary px-3 py-2.5 text-left text-xs font-bold text-white"
                        data-partner="__all_partner__">
                        Semua
                    </button>

                    @foreach($partnerList as $p)
                        @php $available = $partnerOptions->contains($p); @endphp
                        <button type="button"
                            class="partner-chip w-full rounded-xl border border-brand-neutral bg-white px-3 py-2.5 text-left text-xs font-bold text-gray-700
                                   hover:bg-gray-50 hover:border-brand-primary/30 hover:text-gray-900
                                   disabled:cursor-not-allowed disabled:opacity-60 transition"
                            data-partner="{{ $p }}"
                            {{ $available ? '' : 'disabled' }}>
                            {{ $p }}
                            @if(!$available)
                                <span class="ml-1 text-[10px] text-gray-400">(0)</span>
                            @endif
                        </button>
                    @endforeach
                </div>

                <div class="mt-4 rounded-xl bg-brand-soft/10 p-3 text-xs text-gray-600 border border-brand-neutral">
                    Klik marker atau tombol <b>Fokus Map</b> untuk fokus lokasi. Tombol <b>Lihat Detail</b> untuk halaman detail.
                </div>
            </div>
        </aside>

        {{-- RIGHT BOTTOM: CARDS --}}
        <section class="order-4">
            <div id="bizCards" class="flex gap-4 overflow-x-auto py-1 pr-1 scroll-smooth">
                @forelse($items as $item)
                    @php
                        $imgUrl = !empty($item->image_path) ? asset('storage/'.$item->image_path) : '';
                        $detailUrl = route('opportunities.show', $item->slug);

                        $cat = trim((string)($item->category ?? ''));
                        $meta = $categoryMeta[$cat] ?? $categoryMeta['__default__'];

                        $catColor = $meta['color'];
                        $catLabel = $meta['label'];
                        $catEmoji = $meta['emoji'];
                    @endphp

                    <div
                        class="biz-card w-72 flex-none rounded-2xl border border-brand-neutral bg-white p-4 text-left shadow-sm transition
                               hover:-translate-y-0.5 hover:shadow-lg hover:border-brand-primary/20 cursor-pointer select-none"
                        role="button"
                        tabindex="0"
                        data-id="{{ $item->id }}"
                        data-lat="{{ $item->lat }}"
                        data-lng="{{ $item->lng }}"
                        data-name="{{ $item->product_name }}"
                        data-category="{{ $cat }}"
                        data-featured="{{ (int)($item->is_featured ?? 0) }}"
                        data-partner="{{ trim((string)($item->partner_need ?? '')) }}"
                        data-image="{{ $imgUrl }}"

                        {{-- ✅ sync marker <-> card --}}
                        data-cat-color="{{ $catColor }}"
                        data-cat-label="{{ $catLabel }}"
                        data-cat-emoji="{{ $catEmoji }}"
                    >
                        {{-- THUMBNAIL --}}
                        <div class="mb-3 overflow-hidden rounded-xl border border-brand-neutral bg-gray-50">
                            <div class="aspect-[16/9]">
                                @if($imgUrl)
                                    <img
                                        src="{{ $imgUrl }}"
                                        alt="Gambar {{ $item->product_name }}"
                                        class="h-full w-full object-cover"
                                        loading="lazy"
                                    >
                                @else
                                    <div class="h-full w-full flex items-center justify-center text-[11px] font-semibold text-gray-500">
                                        Tidak ada gambar
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            {{-- ✅ Ikon kiri selaras kategori (warna + emoji) --}}
                            <div class="h-9 w-9 rounded-xl text-white flex items-center justify-center shadow-sm"
                                 style="background: {{ $catColor }};">
                                <span class="text-base leading-none">{{ $catEmoji }}</span>
                            </div>

                            <div class="min-w-0">
                                <div class="truncate text-sm font-extrabold text-gray-900">
                                    {{ $item->product_name }}
                                </div>

                                <div class="mt-2 flex flex-wrap gap-1.5">
                                    {{-- ✅ Badge kategori selaras (dot warna + label) --}}
                                    <span class="inline-flex items-center gap-2 rounded-full border border-brand-neutral bg-brand-soft/15 px-3 py-1 text-xs font-semibold text-gray-800">
                                        <span class="h-2 w-2 rounded-full" style="background: {{ $catColor }};"></span>
                                        <span class="truncate">{{ $cat ?: 'Tanpa Kategori' }}</span>
                                        <span class="text-[10px] font-extrabold text-gray-400">({{ $catLabel }})</span>
                                    </span>

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
                            </div>
                        </div>

                        <div class="mt-3 space-y-1.5 text-sm text-gray-500">
                            @if($item->social_media)
                                <div class="truncate">📣 {{ $item->social_media }}</div>
                            @endif
                            @if($item->website)
                                <div class="truncate">🌐 {{ $item->website }}</div>
                            @endif
                        </div>

                        {{-- ACTIONS --}}
                        <div class="mt-4 flex items-center justify-between gap-2">
                            <button type="button"
                                class="btn-focus-map inline-flex items-center justify-center rounded-xl
                                       border border-brand-neutral bg-white px-3 py-2 text-xs font-extrabold text-gray-800
                                       hover:bg-gray-50 hover:border-brand-primary/30 transition">
                                Fokus Map
                            </button>

                            <a href="{{ $detailUrl }}"
                               class="btn-detail inline-flex items-center justify-center rounded-xl
                                      bg-brand-primary px-3 py-2 text-xs font-extrabold text-white
                                      hover:bg-brand-primary/90 transition">
                                Lihat Detail →
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="py-2 text-sm text-gray-500">Belum ada peluang bisnis.</div>
                @endforelse
            </div>
        </section>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // ===== MAP INIT =====
    const map = L.map('map');
    const defaultCenter = [3.5952, 98.6722];
    const defaultZoom = 12;

    map.setView(defaultCenter, defaultZoom);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    setTimeout(() => map.invalidateSize(), 200);

    // ===== ELEMENTS =====
    const cardsContainer = document.getElementById('bizCards');
    const cards = Array.from(document.querySelectorAll('.biz-card'));

    const categoryChips = Array.from(document.querySelectorAll('.cat-chip'));
    const partnerChips  = Array.from(document.querySelectorAll('.partner-chip'));

    const resetCategoryBtn = document.getElementById('resetCategory');
    const resetPartnerBtn  = document.getElementById('resetPartner');
    const resetAllBtn      = document.getElementById('resetAll');

    // ===== STATE =====
    const markers = {}; // id -> marker
    const markerLayer = L.layerGroup().addTo(map);

    let currentCategory = '__all__';
    let currentPartner  = '__all_partner__';

    // ===== HELPERS =====
    function escapeHtml(str) {
        return String(str)
            .replaceAll('&', '&amp;')
            .replaceAll('<', '&lt;')
            .replaceAll('>', '&gt;')
            .replaceAll('"', '&quot;')
            .replaceAll("'", '&#039;');
    }
    function escapeAttr(str) {
        return String(str)
            .replaceAll('&', '&amp;')
            .replaceAll('"', '&quot;')
            .replaceAll("'", '&#039;')
            .replaceAll('<', '&lt;')
            .replaceAll('>', '&gt;');
    }

    function clearActiveCard() {
        cards.forEach(c => c.classList.remove('ring-2','ring-brand-primary/25','shadow-lg','border-brand-primary/20'));
    }

    function setActiveCard(card) {
        clearActiveCard();
        if (!card) return;
        card.classList.add('ring-2','ring-brand-primary/25','shadow-lg','border-brand-primary/20');
        card.scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' });
    }

    function setActiveCategoryChip(val) {
        categoryChips.forEach(ch => {
            ch.classList.remove('bg-brand-primary','text-white','border-brand-primary');
            ch.classList.add('bg-white','text-gray-700','border-brand-neutral');
        });
        const found = categoryChips.find(ch => ch.dataset.category === val) || categoryChips[0];
        found.classList.add('bg-brand-primary','text-white','border-brand-primary');
        found.classList.remove('bg-white','text-gray-700','border-brand-neutral');
    }

    function setActivePartnerChip(val) {
        partnerChips.forEach(ch => {
            ch.classList.remove('bg-brand-primary','text-white','border-brand-primary');
            ch.classList.add('bg-white','text-gray-700','border-brand-neutral');
        });
        const found = partnerChips.find(ch => ch.dataset.partner === val) || partnerChips[0];
        found.classList.add('bg-brand-primary','text-white','border-brand-primary');
        found.classList.remove('bg-white','text-gray-700','border-brand-neutral');
    }

    // =========================================================
    // ✅ ICON MARKER ambil style dari CARD (biar selaras 100%)
    // =========================================================
    function getMetaFromCard(card) {
        return {
            color: (card.dataset.catColor || '#111827').trim(),
            label: (card.dataset.catLabel || '•').trim(),
            emoji: (card.dataset.catEmoji || '📍').trim(),
            category: (card.dataset.category || '').trim(),
        };
    }

    function buildMarkerIconFromCard(card) {
        const meta = getMetaFromCard(card);

        const svg = `
          <svg width="44" height="44" viewBox="0 0 44 44" xmlns="http://www.w3.org/2000/svg">
            <defs>
              <filter id="s" x="-30%" y="-30%" width="160%" height="160%">
                <feDropShadow dx="0" dy="2" stdDeviation="2" flood-color="rgba(0,0,0,0.25)"/>
              </filter>
            </defs>

            <path filter="url(#s)"
              d="M22 2c-7.2 0-13 5.8-13 13 0 9.7 11.4 25.5 12 26.3.5.7 1.5.7 2 0 .6-.8 12-16.6 12-26.3C35 7.8 29.2 2 22 2z"
              fill="${meta.color}" />

            <circle cx="22" cy="15" r="8" fill="white" opacity="0.95"/>
            <text x="22" y="18" text-anchor="middle" font-size="10" font-family="ui-sans-serif, system-ui"
              font-weight="900" fill="${meta.color}">
              ${escapeHtml(meta.label)}
            </text>
          </svg>
        `;

        return L.divIcon({
            className: '',
            html: svg,
            iconSize: [44, 44],
            iconAnchor: [22, 42],
            popupAnchor: [0, -40]
        });
    }

    // =========================================================
    // ✅ Legend/Info map (dibangun dari card yang tampil)
    //    Supaya legend juga otomatis ngikut mapping card
    // =========================================================
    const legendControl = L.control({ position: 'topright' });

    legendControl.onAdd = function () {
        const div = L.DomUtil.create('div', 'map-legend');

        div.style.background = 'rgba(255,255,255,0.92)';
        div.style.border = '1px solid #e5e7eb';
        div.style.borderRadius = '14px';
        div.style.boxShadow = '0 8px 20px rgba(0,0,0,0.08)';
        div.style.padding = '10px 12px';
        div.style.fontFamily = 'ui-sans-serif, system-ui';
        div.style.maxWidth = '240px';

        div.innerHTML = `
          <div style="display:flex;align-items:center;justify-content:space-between;gap:10px;">
            <div>
              <div style="font-size:12px;font-weight:900;color:#111827;">Info Marker</div>
              <div style="font-size:11px;color:#6b7280;font-weight:700;margin-top:2px;">
                Warna/label = kategori (selaras dengan card)
              </div>
            </div>
            <button type="button" id="legendToggle"
              style="border:1px solid #e5e7eb;background:#fff;border-radius:10px;padding:6px 8px;font-size:11px;font-weight:900;color:#111827;cursor:pointer;">
              Hide
            </button>
          </div>
          <div id="legendBody" style="margin-top:8px;"></div>
        `;

        L.DomEvent.disableClickPropagation(div);
        L.DomEvent.disableScrollPropagation(div);

        setTimeout(() => {
            const btn = div.querySelector('#legendToggle');
            const body = div.querySelector('#legendBody');
            if (btn && body) {
                btn.addEventListener('click', () => {
                    const hidden = body.style.display === 'none';
                    body.style.display = hidden ? 'block' : 'none';
                    btn.textContent = hidden ? 'Hide' : 'Show';
                });
            }
        }, 0);

        return div;
    };

    legendControl.addTo(map);

    function renderLegendFromCards(list) {
        const legendEl = document.querySelector('.map-legend #legendBody');
        if (!legendEl) return;

        const uniq = new Map(); // category -> meta
        list.forEach(card => {
            const meta = getMetaFromCard(card);
            if (!meta.category) return;
            if (!uniq.has(meta.category)) uniq.set(meta.category, meta);
        });

        const rows = Array.from(uniq.values()).map(meta => `
            <div style="display:flex;align-items:center;gap:8px;margin-top:6px;">
              <span style="width:10px;height:10px;border-radius:999px;background:${meta.color};display:inline-block;"></span>
              <div style="font-size:12px;color:#111827;font-weight:800;line-height:1.2;">
                ${escapeHtml(meta.category)}
                <span style="margin-left:6px;font-size:11px;color:#6b7280;font-weight:900;">(${escapeHtml(meta.label)})</span>
              </div>
            </div>
        `).join('');

        legendEl.innerHTML = `
          ${rows || `<div style="font-size:11px;color:#6b7280;font-weight:700;">Tidak ada kategori tampil.</div>`}
          <div style="margin-top:10px;font-size:11px;color:#6b7280;font-weight:700;">
            Klik marker untuk highlight card.
          </div>
        `;
    }

    // ===== FILTER RULES =====
    function passCategoryFor(card) {
        const cat = (card.dataset.category || '').trim();
        const isFeatured = (parseInt(card.dataset.featured || '0', 10) === 1);

        if (currentCategory === '__all__') return true;
        if (currentCategory === '__featured__') return isFeatured;
        return cat === currentCategory;
    }

    function passPartnerFor(card) {
        const partner = (card.dataset.partner || '').trim();
        if (currentPartner === '__all_partner__') return true;
        return partner === currentPartner;
    }

    function applyCardsFilter() {
        cards.forEach(card => {
            const show = passCategoryFor(card) && passPartnerFor(card);
            card.classList.toggle('hidden', !show);
        });
    }

    function getCardsForMap() {
        return cards.filter(card => passCategoryFor(card)); // map: category only
    }

    function fitBoundsFor(list) {
        const bounds = [];
        list.forEach(card => {
            const lat = parseFloat(card.dataset.lat);
            const lng = parseFloat(card.dataset.lng);
            if (Number.isFinite(lat) && Number.isFinite(lng)) bounds.push([lat, lng]);
        });

        if (bounds.length > 0) map.fitBounds(bounds, { padding: [30, 30] });
        else map.setView(defaultCenter, defaultZoom);
    }

    // ===== MARKERS RENDER (selaras dengan card) =====
    function renderMarkersByCategory() {
        markerLayer.clearLayers();
        Object.keys(markers).forEach(k => delete markers[k]);

        const list = getCardsForMap();

        list.forEach(card => {
            const id = card.dataset.id;
            const lat = parseFloat(card.dataset.lat);
            const lng = parseFloat(card.dataset.lng);
            if (!Number.isFinite(lat) || !Number.isFinite(lng)) return;

            const name = card.dataset.name || 'Lokasi';
            const img = (card.dataset.image || '').trim();
            const meta = getMetaFromCard(card);

            const popupHtml = `
                <div style="min-width:180px; max-width:240px;">
                    ${img ? `
                        <div style="overflow:hidden; border-radius:12px; border:1px solid #e5e7eb; margin-bottom:8px;">
                            <div style="aspect-ratio:16/9; background:#f9fafb;">
                                <img src="${escapeAttr(img)}" alt="" style="width:100%; height:100%; object-fit:cover; display:block;">
                            </div>
                        </div>
                    ` : ``}

                    <div style="font-weight:900; font-size:13px; color:#111827;">
                      ${escapeHtml(name)}
                    </div>

                    ${meta.category ? `
                      <div style="margin-top:6px; display:inline-flex; align-items:center; gap:8px;
                                  border:1px solid #e5e7eb; background:#fff; border-radius:999px;
                                  padding:4px 10px; font-size:11px; font-weight:900; color:#111827;">
                        <span style="width:8px;height:8px;border-radius:999px;background:${meta.color};display:inline-block;"></span>
                        <span>${escapeHtml(meta.category)}</span>
                        <span style="color:#6b7280;">(${escapeHtml(meta.label)})</span>
                      </div>
                    ` : ``}
                </div>
            `;

            const marker = L.marker([lat, lng], { icon: buildMarkerIconFromCard(card) })
                .bindPopup(popupHtml);

            marker.addTo(markerLayer);
            markers[id] = marker;

            marker.on('click', () => setActiveCard(card));
        });

        // legend juga ikut update sesuai yang tampil
        renderLegendFromCards(list);

        fitBoundsFor(list);
    }

    function focusMapFromCard(card) {
        if (!card || card.classList.contains('hidden')) return;

        const id = card.dataset.id;
        const lat = parseFloat(card.dataset.lat);
        const lng = parseFloat(card.dataset.lng);
        if (!Number.isFinite(lat) || !Number.isFinite(lng)) return;

        setActiveCard(card);
        map.flyTo([lat, lng], 15, { animate: true, duration: 0.8 });
        if (markers[id]) markers[id].openPopup();
    }

    function refreshAll() {
        clearActiveCard();
        applyCardsFilter();        // cards: category + partner
        renderMarkersByCategory(); // map: category only
        cardsContainer?.scrollTo({ left: 0, behavior: 'smooth' });
    }

    // ===== CARD BEHAVIOR =====
    cards.forEach(card => {
        card.addEventListener('click', (e) => {
            if (e.target.closest('.btn-detail')) return;

            if (e.target.closest('.btn-focus-map')) {
                e.preventDefault();
                e.stopPropagation();
                focusMapFromCard(card);
                return;
            }

            focusMapFromCard(card);
        });

        card.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' || e.key === ' ') {
                if (e.target.closest('.btn-detail')) return;
                e.preventDefault();
                focusMapFromCard(card);
            }
        });

        const detail = card.querySelector('.btn-detail');
        detail?.addEventListener('click', (e) => e.stopPropagation());
    });

    // ===== CHIP CLICK =====
    categoryChips.forEach(chip => {
        chip.addEventListener('click', () => {
            if (chip.hasAttribute('disabled')) return;
            currentCategory = chip.dataset.category;
            setActiveCategoryChip(currentCategory);
            refreshAll();
        });
    });

    partnerChips.forEach(chip => {
        chip.addEventListener('click', () => {
            if (chip.hasAttribute('disabled')) return;
            currentPartner = chip.dataset.partner;
            setActivePartnerChip(currentPartner);
            refreshAll();
        });
    });

    // ===== RESET =====
    resetCategoryBtn?.addEventListener('click', () => {
        currentCategory = '__all__';
        setActiveCategoryChip('__all__');
        refreshAll();
    });

    resetPartnerBtn?.addEventListener('click', () => {
        currentPartner = '__all_partner__';
        setActivePartnerChip('__all_partner__');
        refreshAll();
    });

    resetAllBtn?.addEventListener('click', () => {
        currentCategory = '__all__';
        currentPartner  = '__all_partner__';
        setActiveCategoryChip('__all__');
        setActivePartnerChip('__all_partner__');
        map.closePopup();
        refreshAll();
    });

    // ===== INIT =====
    setActiveCategoryChip('__all__');
    setActivePartnerChip('__all_partner__');
    refreshAll();
});
</script>
@endsection
