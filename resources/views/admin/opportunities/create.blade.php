<x-app-layout>
    <x-slot name="header">
        <div class="w-full">
            <p class="text-[11px] font-semibold tracking-widest text-brand-primary uppercase">Admin</p>
            <h2 class="mt-1 text-2xl font-bold tracking-tight text-gray-900">Tambah Peluang Bisnis</h2>
            <p class="mt-1 text-sm text-gray-600">Tambahkan data peluang bisnis dan tentukan titik lokasi pada peta.</p>
        </div>
    </x-slot>

    {{-- Leaflet CDN --}}
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
        $categories = [
            'Pangan' => 'Pangan',
            'Sandang' => 'Sandang',
            'Manufaktur' => 'Manufaktur',
            'Teknologi Informasi' => 'Teknologi Informasi',
            'Material Maju' => 'Material Maju',
            'Kesehatan & kosmetik' => 'Kesehatan dan Kosmetik',
            'Jasa Lainnya' => 'Jasa Lainnya',
        ];

        $partners = [
            'Investor' => 'Investor',
            'Reseller' => 'Reseller',
            'Distributor' => 'Distributor',
            'Buyer' => 'Buyer',
        ];
    @endphp

    <div class="bg-gray-50">
        <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8 mt-6 lg:mt-8">

            <div class="rounded-3xl bg-white shadow-sm border border-brand-neutral overflow-hidden">

                <div class="flex items-start justify-between border-b border-brand-neutral px-6 py-6">
                    <div>
                        <div class="text-sm font-extrabold text-gray-900">Form Tambah Data</div>
                        <div class="mt-1 text-xs text-gray-500">Field bertanda * wajib diisi.</div>
                    </div>

                    <a href="{{ route('admin.peluang_bisnis.index') }}"
                       class="inline-flex items-center gap-2 rounded-xl border border-brand-neutral bg-white px-4 py-2.5 text-sm font-semibold text-brand-primary shadow-sm transition
                              hover:bg-brand-soft/10 hover:border-brand-primary/30
                              focus:outline-none focus:ring-2 focus:ring-brand-primary/20 focus:ring-offset-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                        Kembali
                    </a>
                </div>

                <div class="p-6 sm:p-8">
                    @if($errors->any())
                        <div class="mb-8 rounded-2xl border border-red-200 bg-white px-4 py-4 shadow-sm">
                            <div class="flex items-start gap-3">
                                <div class="mt-0.5 flex h-9 w-9 items-center justify-center rounded-xl bg-red-50 text-red-700 border border-red-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v4m0 4h.01M10.29 3.86l-8.13 14.07A2 2 0 004 21h16a2 2 0 001.84-3.07L13.71 3.86a2 2 0 00-3.42 0z" />
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <div class="text-sm font-semibold text-gray-900">Validasi gagal</div>
                                    <ul class="mt-2 list-disc pl-5 text-sm text-gray-600 space-y-1">
                                        @foreach($errors->all() as $err)
                                            <li>{{ $err }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form method="POST"
                          action="{{ route('admin.peluang_bisnis.store') }}"
                          enctype="multipart/form-data"
                          class="space-y-14">
                        @csrf

                        {{-- SECTION: DATA --}}
                        <section class="space-y-6">
                            <div>
                                <p class="text-[11px] font-semibold tracking-widest text-brand-primary uppercase">Data</p>
                                <div class="mt-1 text-sm font-semibold text-gray-900">Informasi Produk</div>
                                <div class="mt-1 text-xs text-gray-500">Lengkapi data dasar produk.</div>
                            </div>

                            <div class="grid grid-cols-1 gap-10 md:grid-cols-2">

                                <div>
                                    <label class="block text-sm font-medium text-gray-900">
                                        Kategori Produk <span class="text-red-500">*</span>
                                    </label>
                                    <select name="category"
                                            class="mt-3 w-full rounded-xl border border-brand-neutral bg-white px-3 py-2.5 text-sm text-gray-900 shadow-sm
                                                   focus:outline-none focus:border-brand-primary/40 focus:ring-2 focus:ring-brand-primary/20"
                                            required>
                                        <option value="">-- Pilih kategori --</option>
                                        @foreach($categories as $val => $label)
                                            <option value="{{ $val }}" @selected(old('category') === $val)>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-900">
                                        Nama Produk <span class="text-red-500">*</span>
                                    </label>
                                    <input name="product_name" value="{{ old('product_name') }}"
                                           class="mt-3 w-full rounded-xl border border-brand-neutral bg-white px-3 py-2.5 text-sm text-gray-900 shadow-sm
                                                  focus:outline-none focus:border-brand-primary/40 focus:ring-2 focus:ring-brand-primary/20"
                                           required>
                                </div>

                                {{-- ✅ BARU: JENIS PRODUK (setelah Nama Produk) --}}
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-900">
                                        Jenis Produk <span class="text-red-500">*</span>
                                    </label>
                                    <input name="product_type" value="{{ old('product_type') }}"
                                           class="mt-3 w-full rounded-xl border border-brand-neutral bg-white px-3 py-2.5 text-sm text-gray-900 shadow-sm
                                                  focus:outline-none focus:border-brand-primary/40 focus:ring-2 focus:ring-brand-primary/20"
                                           placeholder="contoh: Makanan ringan / Fashion / Jasa desain"
                                           required>
                                    <p class="mt-2 text-xs text-gray-500">Contoh: makanan, minuman, jasa, kerajinan, fashion, dll.</p>
                                </div>
                                {{-- ✅ END BARU --}}

                                <div>
                                    <label class="block text-sm font-medium text-gray-900">Media Sosial</label>
                                    <input name="social_media" value="{{ old('social_media') }}"
                                           class="mt-3 w-full rounded-xl border border-brand-neutral bg-white px-3 py-2.5 text-sm text-gray-900 shadow-sm
                                                  focus:outline-none focus:border-brand-primary/40 focus:ring-2 focus:ring-brand-primary/20"
                                           placeholder="contoh: @akun / link IG / TikTok">
                                    <p class="mt-2 text-xs text-gray-500">Opsional.</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-900">Website</label>
                                    <input name="website" value="{{ old('website') }}"
                                           class="mt-3 w-full rounded-xl border border-brand-neutral bg-white px-3 py-2.5 text-sm text-gray-900 shadow-sm
                                                  focus:outline-none focus:border-brand-primary/40 focus:ring-2 focus:ring-brand-primary/20"
                                           placeholder="https://...">
                                    <p class="mt-2 text-xs text-gray-500">Opsional.</p>
                                </div>

                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-900">Mencari Mitra</label>
                                    <select name="partner_need"
                                            class="mt-3 w-full rounded-xl border border-brand-neutral bg-white px-3 py-2.5 text-sm text-gray-900 shadow-sm
                                                   focus:outline-none focus:border-brand-primary/40 focus:ring-2 focus:ring-brand-primary/20">
                                        <option value="">-- Pilih mitra --</option>
                                        @foreach($partners as $val => $label)
                                            <option value="{{ $val }}" @selected(old('partner_need') === $val)>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    <p class="mt-2 text-xs text-gray-500">Kosongkan jika tidak mencari mitra.</p>
                                </div>
                            </div>
                        </section>

                        <div class="border-t border-brand-neutral"></div>

                        {{-- SECTION: MEDIA (GAMBAR) --}}
                        <section class="space-y-6">
                            <div>
                                <p class="text-[11px] font-semibold tracking-widest text-brand-primary uppercase">Media</p>
                                <div class="mt-1 text-sm font-semibold text-gray-900">Gambar Produk</div>
                                <div class="mt-1 text-xs text-gray-500">Upload 1 gambar (JPG/PNG/WEBP, max 2MB). Opsional.</div>
                            </div>

                            <div class="grid grid-cols-1 gap-10 md:grid-cols-2 items-start">
                                <div>
                                    <label class="block text-sm font-medium text-gray-900">File Gambar</label>

                                    <input id="imageInput"
                                           type="file"
                                           name="image"
                                           accept="image/*"
                                           class="mt-3 w-full rounded-xl border border-brand-neutral bg-white px-3 py-2.5 text-sm text-gray-900 shadow-sm
                                                  file:mr-4 file:rounded-lg file:border-0 file:bg-brand-soft/20 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-brand-primary
                                                  hover:file:bg-brand-soft/30
                                                  focus:outline-none focus:border-brand-primary/40 focus:ring-2 focus:ring-brand-primary/20">

                                    <p class="mt-2 text-xs text-gray-500">
                                        Rekomendasi: rasio 16:9 biar cocok buat hero/card. Kalau beda rasio, akan di-crop oleh <code class="text-[11px]">object-cover</code>.
                                    </p>
                                </div>

                                <div>
                                    <div class="text-sm font-medium text-gray-900">Preview</div>

                                    <div class="mt-3 overflow-hidden rounded-2xl border border-brand-neutral bg-white shadow-sm">
                                        <div class="aspect-[16/9] bg-gray-50">
                                            <img id="imagePreview"
                                                 src=""
                                                 alt="Preview gambar"
                                                 class="h-full w-full object-cover hidden">
                                            <div id="imageEmpty"
                                                 class="h-full w-full flex items-center justify-center text-xs text-gray-500">
                                                Belum ada gambar dipilih
                                            </div>
                                        </div>
                                    </div>

                                    <button type="button"
                                            id="imageClearBtn"
                                            class="mt-3 inline-flex items-center gap-2 rounded-xl border border-brand-neutral bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm transition
                                                   hover:bg-gray-50 hover:border-brand-primary/30 hover:text-gray-900
                                                   focus:outline-none focus:ring-2 focus:ring-brand-primary/20 focus:ring-offset-2">
                                        Hapus pilihan gambar
                                    </button>
                                </div>
                            </div>
                        </section>

                        <div class="border-t border-brand-neutral"></div>

                        {{-- SECTION: MAP --}}
                        <section class="space-y-6">
                            <div>
                                <p class="text-[11px] font-semibold tracking-widest text-brand-primary uppercase">Lokasi</p>
                                <div class="mt-1 text-sm font-semibold text-gray-900">Titik Koordinat</div>
                                <div class="mt-1 text-xs text-gray-500">
                                    Klik pada peta untuk set pin. Pin bisa di-drag untuk mengubah koordinat.
                                </div>
                            </div>

                            <div class="overflow-hidden rounded-2xl border border-brand-neutral bg-white shadow-sm">
                                <div id="map" class="w-full" style="height: 420px;"></div>
                            </div>

                            <div class="grid grid-cols-1 gap-10 md:grid-cols-2">
                                <div>
                                    <label class="block text-sm font-medium text-gray-900">
                                        Latitude <span class="text-red-500">*</span>
                                    </label>
                                    <input id="lat" name="lat" value="{{ old('lat') }}"
                                           class="mt-3 w-full rounded-xl border border-brand-neutral bg-gray-50 px-3 py-2.5 text-sm text-gray-900 shadow-sm"
                                           readonly required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-900">
                                        Longitude <span class="text-red-500">*</span>
                                    </label>
                                    <input id="lng" name="lng" value="{{ old('lng') }}"
                                           class="mt-3 w-full rounded-xl border border-brand-neutral bg-gray-50 px-3 py-2.5 text-sm text-gray-900 shadow-sm"
                                           readonly required>
                                </div>
                            </div>
                        </section>

                        <div class="border-t border-brand-neutral"></div>

                        {{-- SECTION: STATUS --}}
                        <section class="space-y-6">
                            <div>
                                <p class="text-[11px] font-semibold tracking-widest text-brand-primary uppercase">Status</p>
                                <div class="mt-1 text-sm font-semibold text-gray-900">Pengaturan Tampil</div>
                                <div class="mt-1 text-xs text-gray-500">Atur status tampil di halaman publik.</div>
                            </div>

                            <div class="grid grid-cols-1 gap-8 md:grid-cols-2">
                                <label class="flex items-center justify-between rounded-2xl border border-brand-neutral bg-white px-5 py-4 shadow-sm hover:bg-brand-soft/10 cursor-pointer transition">
                                    <div>
                                        <div class="text-sm font-semibold text-gray-900">Aktif</div>
                                        <div class="mt-1 text-xs text-gray-500">Ditampilkan di halaman publik.</div>
                                    </div>
                                    <input type="checkbox" name="is_active" value="1"
                                           class="h-5 w-5 rounded border-brand-neutral text-brand-primary focus:ring-2 focus:ring-brand-primary/30"
                                           @checked(old('is_active', true))>
                                </label>

                                <label class="flex items-center justify-between rounded-2xl border border-brand-neutral bg-white px-5 py-4 shadow-sm hover:bg-brand-soft/10 cursor-pointer transition">
                                    <div>
                                        <div class="text-sm font-semibold text-gray-900">Unggulan</div>
                                        <div class="mt-1 text-xs text-gray-500">Prioritas tampil di daftar.</div>
                                    </div>
                                    <input type="checkbox" name="is_featured" value="1"
                                           class="h-5 w-5 rounded border-brand-neutral text-brand-primary focus:ring-2 focus:ring-brand-primary/30"
                                           @checked(old('is_featured', false))>
                                </label>
                            </div>
                        </section>

                        {{-- ACTIONS --}}
                        <div class="border-t border-brand-neutral pt-8">
                            <div class="flex flex-col gap-3 sm:flex-row sm:justify-end">

                                <a href="{{ route('admin.peluang_bisnis.index') }}"
                                   class="inline-flex items-center justify-center rounded-xl border border-brand-neutral bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 shadow-sm transition
                                          hover:bg-gray-50 hover:border-brand-primary/30 hover:text-gray-900
                                          focus:outline-none focus:ring-2 focus:ring-brand-primary/20 focus:ring-offset-2">
                                    Batal
                                </a>

                                <button type="submit"
                                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-brand-primary px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition
                                           hover:bg-brand-primary/90
                                           focus:outline-none focus:ring-2 focus:ring-brand-primary/30 focus:ring-offset-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Simpan
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // ===== Map =====
            const defaultLat = {{ old('lat', 3.5952) }};
            const defaultLng = {{ old('lng', 98.6722) }};
            const defaultZoom = 12;

            const map = L.map('map').setView([defaultLat, defaultLng], defaultZoom);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19
            }).addTo(map);

            const latInput = document.getElementById('lat');
            const lngInput = document.getElementById('lng');

            let marker = L.marker([defaultLat, defaultLng], { draggable: true }).addTo(map);

            if (!latInput.value) latInput.value = Number(defaultLat).toFixed(7);
            if (!lngInput.value) lngInput.value = Number(defaultLng).toFixed(7);

            function setLatLng(lat, lng) {
                marker.setLatLng([lat, lng]);
                latInput.value = Number(lat).toFixed(7);
                lngInput.value = Number(lng).toFixed(7);
            }

            map.on('click', (e) => setLatLng(e.latlng.lat, e.latlng.lng));

            marker.on('dragend', () => {
                const pos = marker.getLatLng();
                setLatLng(pos.lat, pos.lng);
            });

            // ===== Preview Upload Gambar =====
            const imageInput = document.getElementById('imageInput');
            const imagePreview = document.getElementById('imagePreview');
            const imageEmpty = document.getElementById('imageEmpty');
            const imageClearBtn = document.getElementById('imageClearBtn');

            function clearImage() {
                if (imageInput) imageInput.value = '';
                if (imagePreview) {
                    imagePreview.src = '';
                    imagePreview.classList.add('hidden');
                }
                if (imageEmpty) imageEmpty.classList.remove('hidden');
            }

            if (imageInput) {
                imageInput.addEventListener('change', () => {
                    const file = imageInput.files && imageInput.files[0];
                    if (!file) return clearImage();
                    if (!file.type.startsWith('image/')) return clearImage();

                    const url = URL.createObjectURL(file);
                    imagePreview.src = url;
                    imagePreview.classList.remove('hidden');
                    imageEmpty.classList.add('hidden');
                });
            }

            if (imageClearBtn) {
                imageClearBtn.addEventListener('click', clearImage);
            }
        });
    </script>
</x-app-layout>
