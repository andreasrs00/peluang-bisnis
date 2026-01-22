<x-app-layout>
    <x-slot name="header">
        <div class="w-full">
            <p class="text-[11px] font-semibold tracking-widest text-brand-primary uppercase">Admin</p>
            <h2 class="mt-1 text-2xl font-bold tracking-tight text-gray-900">
                Edit Peluang Bisnis
            </h2>
            <p class="mt-1 text-sm text-gray-600">
                Perbarui data produk, mitra, dan koordinat lokasi.
            </p>
        </div>
    </x-slot>

    <div class="bg-gray-50">
        <div class="mx-auto max-w-3xl px-4 py-8 sm:px-6 lg:px-8">

            <div class="rounded-3xl bg-white shadow-sm border border-brand-neutral overflow-hidden">

                {{-- Header Card --}}
                <div class="flex items-start justify-between border-b border-brand-neutral px-6 py-6">
                    <div>
                        <div class="text-sm font-extrabold text-gray-900">Form Edit Data</div>
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

                    <form method="POST" action="{{ route('admin.peluang_bisnis.update', $item->id) }}" class="space-y-10">
                        @csrf
                        @method('PUT')

                        {{-- Informasi Produk --}}
                        <section class="space-y-6">
                            <div>
                                <p class="text-[11px] font-semibold tracking-widest text-brand-primary uppercase">Data</p>
                                <div class="mt-1 text-sm font-semibold text-gray-900">Informasi Produk</div>
                                <div class="mt-1 text-xs text-gray-500">Perbarui data dasar produk.</div>
                            </div>

                            <div class="grid grid-cols-1 gap-8">
                                <div>
                                    <label class="block text-sm font-medium text-gray-900">
                                        Kategori Produk <span class="text-red-500">*</span>
                                    </label>
                                    <input name="category" value="{{ old('category', $item->category) }}"
                                           class="mt-3 w-full rounded-xl border border-brand-neutral bg-white px-3 py-2.5 text-sm text-gray-900 shadow-sm
                                                  focus:outline-none focus:border-brand-primary/40 focus:ring-2 focus:ring-brand-primary/20"
                                           required>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-900">
                                        Nama Produk <span class="text-red-500">*</span>
                                    </label>
                                    <input name="product_name" value="{{ old('product_name', $item->product_name) }}"
                                           class="mt-3 w-full rounded-xl border border-brand-neutral bg-white px-3 py-2.5 text-sm text-gray-900 shadow-sm
                                                  focus:outline-none focus:border-brand-primary/40 focus:ring-2 focus:ring-brand-primary/20"
                                           required>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-900">Media Sosial</label>
                                    <input name="social_media" value="{{ old('social_media', $item->social_media) }}"
                                           class="mt-3 w-full rounded-xl border border-brand-neutral bg-white px-3 py-2.5 text-sm text-gray-900 shadow-sm
                                                  focus:outline-none focus:border-brand-primary/40 focus:ring-2 focus:ring-brand-primary/20">
                                    <p class="mt-2 text-xs text-gray-500">Opsional.</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-900">Website</label>
                                    <input name="website" value="{{ old('website', $item->website) }}"
                                           class="mt-3 w-full rounded-xl border border-brand-neutral bg-white px-3 py-2.5 text-sm text-gray-900 shadow-sm
                                                  focus:outline-none focus:border-brand-primary/40 focus:ring-2 focus:ring-brand-primary/20">
                                    <p class="mt-2 text-xs text-gray-500">Opsional.</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-900">Mencari Mitra</label>
                                    <textarea name="partner_need" rows="3"
                                              class="mt-3 w-full rounded-xl border border-brand-neutral bg-white px-3 py-2.5 text-sm text-gray-900 shadow-sm
                                                     focus:outline-none focus:border-brand-primary/40 focus:ring-2 focus:ring-brand-primary/20"
                                    >{{ old('partner_need', $item->partner_need) }}</textarea>
                                    <p class="mt-2 text-xs text-gray-500">Opsional.</p>
                                </div>
                            </div>
                        </section>

                        <div class="border-t border-brand-neutral"></div>

                        {{-- Koordinat --}}
                        <section class="space-y-6">
                            <div>
                                <p class="text-[11px] font-semibold tracking-widest text-brand-primary uppercase">Lokasi</p>
                                <div class="mt-1 text-sm font-semibold text-gray-900">Koordinat</div>
                                <div class="mt-1 text-xs text-gray-500">Perbarui latitude & longitude jika diperlukan.</div>
                            </div>

                            <div class="grid grid-cols-1 gap-8 md:grid-cols-2">
                                <div>
                                    <label class="block text-sm font-medium text-gray-900">
                                        Latitude <span class="text-red-500">*</span>
                                    </label>
                                    <input name="lat" value="{{ old('lat', $item->lat) }}"
                                           class="mt-3 w-full rounded-xl border border-brand-neutral bg-white px-3 py-2.5 text-sm text-gray-900 shadow-sm
                                                  focus:outline-none focus:border-brand-primary/40 focus:ring-2 focus:ring-brand-primary/20"
                                           required>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-900">
                                        Longitude <span class="text-red-500">*</span>
                                    </label>
                                    <input name="lng" value="{{ old('lng', $item->lng) }}"
                                           class="mt-3 w-full rounded-xl border border-brand-neutral bg-white px-3 py-2.5 text-sm text-gray-900 shadow-sm
                                                  focus:outline-none focus:border-brand-primary/40 focus:ring-2 focus:ring-brand-primary/20"
                                           required>
                                </div>
                            </div>
                        </section>

                        <div class="border-t border-brand-neutral"></div>

                        {{-- Status --}}
                        <section class="space-y-6">
                            <div>
                                <p class="text-[11px] font-semibold tracking-widest text-brand-primary uppercase">Status</p>
                                <div class="mt-1 text-sm font-semibold text-gray-900">Pengaturan Tampil</div>
                                <div class="mt-1 text-xs text-gray-500">Atur apakah data ini tampil di publik.</div>
                            </div>

                            <label class="flex items-center justify-between rounded-2xl border border-brand-neutral bg-white px-5 py-4 shadow-sm hover:bg-brand-soft/10 cursor-pointer transition">
                                <div>
                                    <div class="text-sm font-semibold text-gray-900">Aktif</div>
                                    <div class="mt-1 text-xs text-gray-500">Ditampilkan di halaman publik.</div>
                                </div>

                                <input type="checkbox" name="is_active" value="1"
                                       class="h-5 w-5 rounded border-brand-neutral text-brand-primary focus:ring-2 focus:ring-brand-primary/30"
                                       {{ old('is_active', $item->is_active) ? 'checked' : '' }}>
                            </label>
                        </section>

                        {{-- Actions --}}
                        <div class="border-t border-brand-neutral pt-8">
                            <div class="flex flex-col gap-3 sm:flex-row sm:justify-end">
                                <a href="{{ route('admin.peluang_bisnis.index') }}"
                                   class="inline-flex items-center justify-center rounded-xl border border-brand-neutral bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 shadow-sm transition
                                          hover:bg-gray-50 hover:border-brand-primary/30 hover:text-gray-900
                                          focus:outline-none focus:ring-2 focus:ring-brand-primary/20 focus:ring-offset-2">
                                    Batal
                                </a>

                                <button type="submit"
                                        class="inline-flex items-center justify-center rounded-xl bg-brand-primary px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition
                                               hover:bg-brand-primary/90
                                               focus:outline-none focus:ring-2 focus:ring-brand-primary/30 focus:ring-offset-2">
                                    Update
                                </button>
                            </div>
                        </div>

                    </form>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
