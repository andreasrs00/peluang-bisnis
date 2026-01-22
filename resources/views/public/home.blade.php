@extends('layouts.public')

@section('content')
<div class="w-full bg-white text-gray-900">
    <div class="w-full px-4 sm:px-6 lg:px-8 py-4 space-y-12">

        {{-- HERO SECTION --}}
        <section class="pt-6">
            <div class="rounded-2xl border border-brand-neutral bg-white shadow-sm overflow-hidden">
                <div class="p-6 sm:p-10">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">

                        {{-- LEFT --}}
                        <div>
                            <p class="text-[11px] font-semibold tracking-widest text-brand-primary uppercase">
                                Layanan Digital UMKM
                            </p>

                            <h1 class="mt-3 text-3xl sm:text-4xl font-extrabold leading-tight tracking-tight text-gray-900">
                                Pusat Informasi, Pendampingan, dan Kemitraan untuk UMKM Kota Medan
                            </h1>

                            <p class="mt-2 text-base sm:text-lg font-semibold leading-relaxed text-gray-800">
                                Akses program pembinaan, peluang pemasaran, dan kanal pengajuan kemitraan dalam satu platform yang terintegrasi.
                            </p>

                            <p class="mt-3 text-sm sm:text-[15px] leading-7 text-gray-600 max-w-xl">
                                Platform ini membantu pelaku UMKM menemukan informasi layanan yang relevan—mulai dari pelatihan dan legalitas usaha,
                                fasilitasi pemasaran, pembiayaan, hingga kolaborasi kemitraan. Informasi disajikan ringkas dan mudah ditelusuri
                                berdasarkan kategori kebutuhan, sehingga proses akses layanan menjadi lebih cepat dan terarah.
                            </p>

                            <div class="mt-6 flex flex-wrap items-center gap-3">
                                <a href="{{ route('register') }}"
                                   class="inline-flex items-center justify-center rounded-xl bg-brand-cta px-5 py-2.5 text-sm font-semibold text-white
                                          hover:bg-brand-cta/90 transition
                                          focus:outline-none focus:ring-2 focus:ring-brand-cta/30">
                                    Daftar sebagai Pelaku Usaha
                                </a>

                                <a href="{{ route('opportunities.index') }}"
                                   class="inline-flex items-center justify-center rounded-xl border border-brand-neutral bg-white px-5 py-2.5 text-sm font-semibold text-brand-primary
                                          hover:bg-brand-soft/10 hover:border-brand-primary/30 transition
                                          focus:outline-none focus:ring-2 focus:ring-brand-primary/20">
                                    Telusuri Program & Peluang
                                </a>
                            </div>

                            <div class="mt-6 border-t border-brand-neutral pt-4">
                                <p class="text-xs leading-5 text-gray-600">
                                    <span class="font-semibold text-gray-900">Catatan:</span>
                                    Informasi pada halaman ini merupakan ringkasan. Detail syarat, jadwal, dan mekanisme layanan dapat dilihat pada menu terkait
                                    atau melalui kanal layanan resmi.
                                </p>
                            </div>
                        </div>

                        {{-- RIGHT --}}
                        <div class="w-full">
                            <div class="rounded-2xl border border-brand-neutral bg-white overflow-hidden">
                                {{-- (DIISI GAMBAR: 1.jpg) --}}
                                <div class="aspect-[16/9]">
                                    <img
                                        src="{{ asset('images/home/1.jpg') }}"
                                        alt="Banner Program / Dokumentasi Kegiatan UMKM"
                                        class="h-full w-full object-cover"
                                        loading="lazy"
                                    >
                                </div>
                            </div>

                            <p class="mt-3 text-xs leading-5 text-gray-600">
                                Gunakan foto kegiatan pelatihan, pendampingan, pameran UMKM, kunjungan lapangan, atau banner resmi program (rasio 16:9).
                            </p>
                        </div>

                    </div>
                </div>
            </div>
        </section>

        {{-- FITUR UTAMA --}}
        <section>
            <div class="text-center">
                <p class="text-[11px] font-semibold tracking-widest text-brand-primary uppercase">
                    Informasi dan Layanan
                </p>
                <h2 class="mt-2 text-xl sm:text-2xl font-extrabold tracking-tight text-gray-900">
                    Fitur Utama Platform
                </h2>
                <p class="mt-2 text-sm sm:text-[15px] leading-7 text-gray-600 max-w-2xl mx-auto">
                    Dirancang untuk memudahkan pelaku usaha mendapatkan informasi yang tepat, mengakses pembinaan, serta menjalin kemitraan secara transparan.
                </p>
            </div>

            <div class="mt-8 grid grid-cols-2 md:grid-cols-4 gap-6">
                @php
                    $features = [
                        [
                            'kicker' => 'Informasi Program',
                            'title'  => 'Katalog Program Pembinaan UMKM',
                            'desc'   => 'Daftar program pelatihan, pendampingan, sertifikasi, dan fasilitasi yang dapat diakses pelaku usaha, lengkap dengan ringkasan tujuan dan sasaran.'
                        ],
                        [
                            'kicker' => 'Peluang & Kemitraan',
                            'title'  => 'Pemetaan Kebutuhan Mitra Usaha',
                            'desc'   => 'Temukan peluang kolaborasi dan kebutuhan kemitraan (produksi, distribusi, branding, pemasaran, dan lainnya) berdasarkan kategori yang relevan.'
                        ],
                        [
                            'kicker' => 'Panduan Layanan',
                            'title'  => 'Alur dan Persyaratan yang Jelas',
                            'desc'   => 'Ringkasan alur layanan, persyaratan dokumen, serta langkah pengajuan disajikan sederhana agar proses lebih cepat dan tidak membingungkan.'
                        ],
                        [
                            'kicker' => 'Pembaruan Berkala',
                            'title'  => 'Update Informasi dan Pengumuman',
                            'desc'   => 'Informasi terbaru terkait jadwal kegiatan, pendaftaran program, serta pengumuman penting ditampilkan agar pelaku usaha tidak ketinggalan.'
                        ],
                    ];
                @endphp

                @foreach($features as $i => $f)
                    <div class="rounded-2xl border border-brand-neutral bg-white shadow-sm overflow-hidden hover:shadow-md transition">

                        <div class="p-4">
                            <p class="text-xs font-semibold tracking-widest text-gray-500 uppercase">
                                {{ $f['kicker'] }}
                            </p>
                            <p class="mt-2 text-sm font-bold text-gray-900 leading-6">
                                {{ $f['title'] }}
                            </p>
                            <p class="mt-2 text-xs sm:text-[13px] leading-6 text-gray-600">
                                {{ $f['desc'] }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        {{-- TESTIMONIALS --}}
        <section>
            <div class="text-center">
                <p class="text-[11px] font-semibold tracking-widest text-brand-primary uppercase">
                    Umpan Balik Pengguna
                </p>
                <h2 class="mt-2 text-xl sm:text-2xl font-extrabold tracking-tight text-gray-900">
                    Testimoni Pelaku Usaha
                </h2>
                <p class="mt-2 text-sm sm:text-[15px] leading-7 text-gray-600 max-w-2xl mx-auto">
                    Ringkasan pengalaman pelaku usaha setelah mengakses informasi program, pendampingan, dan peluang kemitraan melalui platform ini.
                </p>
            </div>

            <div class="mt-8 flex justify-center">
                <div class="relative w-full max-w-2xl">
                    {{-- tail bubble --}}
                    <div class="absolute -left-5 top-10 h-10 w-10 rotate-45 border-l border-b border-brand-neutral bg-white"></div>

                    <div class="rounded-2xl border border-brand-neutral bg-white px-6 py-8 text-center shadow-sm">
                        <p class="text-base sm:text-lg font-bold leading-relaxed text-gray-900">
                            “Dengan adanya katalog program dan informasi persyaratan yang jelas, saya lebih mudah menentukan layanan yang sesuai.
                            Proses mencari peluang kemitraan juga jadi lebih cepat dan terarah.”
                        </p>

                        <div class="mx-auto mt-4 h-px w-40 bg-brand-neutral"></div>

                        <div class="mt-5 flex flex-col items-center gap-1.5">
                            <p class="text-sm font-semibold text-gray-900">
                                Rina Sari
                            </p>
                            <p class="text-xs text-gray-600">
                                UMKM Kuliner • Kecamatan Medan Area
                            </p>

                            <div class="mt-2 flex items-center gap-1 text-brand-primary">
                                @for($s=1; $s<=5; $s++)
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.709c-.783-.57-.38-1.81.588-1.81H7.03a1 1 0 00.95-.69l1.07-3.292z"/>
                                    </svg>
                                @endfor
                            </div>
                        </div>

                        <p class="mt-6 text-xs leading-5 text-gray-600">
                            Testimoni ditampilkan sebagai ringkasan. Publikasi nama dan profil mengikuti kebijakan pengelolaan data serta persetujuan pelaku usaha.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        {{-- CONTOH KASUS UMKM --}}
        <section>
            <div class="text-center">
                <p class="text-[11px] font-semibold tracking-widest text-brand-primary uppercase">
                    Praktik Baik
                </p>
                <h2 class="mt-2 text-xl sm:text-2xl font-extrabold tracking-tight text-gray-900">
                    Contoh Penerapan Program pada UMKM
                </h2>
                <p class="mt-2 text-sm sm:text-[15px] leading-7 text-gray-600 max-w-2xl mx-auto">
                    Ilustrasi singkat yang menunjukkan bagaimana program pendampingan dan kemitraan dapat berdampak pada peningkatan kapasitas usaha.
                </p>
            </div>

            @php
                $cases = [
                    [
                        'kicker' => 'Studi Kasus 01',
                        'title'  => 'Standarisasi Produksi dan Peningkatan Kapasitas',
                        'desc'   => 'Pelaku usaha mendapatkan pendampingan penyusunan SOP, perbaikan alur produksi, dan perencanaan kapasitas agar konsisten memenuhi permintaan pasar.',
                        'tags'   => ['Pendampingan', 'Produksi', 'Standarisasi'],
                    ],
                    [
                        'kicker' => 'Studi Kasus 02',
                        'title'  => 'Penguatan Branding dan Akses Pemasaran Digital',
                        'desc'   => 'UMKM dibantu dalam penguatan identitas merek, kemasan, serta strategi pemasaran digital untuk memperluas jangkauan pelanggan dan meningkatkan penjualan.',
                        'tags'   => ['Branding', 'Pemasaran', 'Digitalisasi'],
                    ],
                ];
            @endphp

            <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-10">
                @foreach($cases as $k => $c)
                    <div class="text-left">
                        <div class="rounded-2xl border border-brand-neutral bg-white overflow-hidden shadow-sm">
                            {{-- (DIISI GAMBAR: 2.jpg untuk kasus 01, 3.jpg untuk kasus 02) --}}
                            <div class="aspect-[16/9]">
                                <img
                                    src="{{ asset($k === 0 ? 'images/home/2.jpg' : 'images/home/3.jpg') }}"
                                    alt="Dokumentasi Kegiatan / Produk UMKM"
                                    class="h-full w-full object-cover"
                                    loading="lazy"
                                >
                            </div>
                        </div>

                        <div class="mt-4">
                            <p class="text-xs font-semibold tracking-widest text-gray-500 uppercase">
                                {{ $c['kicker'] }}
                            </p>
                            <p class="mt-2 text-base font-bold leading-7 text-gray-900">
                                {{ $c['title'] }}
                            </p>
                            <p class="mt-2 text-sm leading-7 text-gray-600">
                                {{ $c['desc'] }}
                            </p>

                            <div class="mt-4 flex flex-wrap gap-2">
                                @foreach($c['tags'] as $t)
                                    <span class="inline-flex items-center rounded-full border border-brand-neutral bg-white px-3 py-1 text-xs font-semibold text-brand-primary">
                                        {{ $t }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        {{-- CALL TO ACTION --}}
        <section class="pb-12">
            <div class="rounded-2xl border border-brand-neutral bg-brand-soft/10 p-8 sm:p-10 text-center">
                <p class="text-[11px] font-semibold tracking-widest text-brand-primary uppercase">
                    Ajukan Layanan
                </p>
                <h2 class="mt-2 text-xl sm:text-2xl font-extrabold tracking-tight text-gray-900">
                    Mulai Akses Layanan dan Informasi UMKM
                </h2>
                <p class="mt-2 text-sm sm:text-[15px] leading-7 text-gray-600 max-w-2xl mx-auto">
                    Lakukan pendaftaran untuk mengakses fitur, menelusuri program, serta mengajukan kebutuhan pendampingan atau kemitraan sesuai kategori usaha Anda.
                </p>

                <div class="mt-6 flex justify-center">
                    <a href="{{ route('register') }}"
                       class="inline-flex items-center justify-center rounded-xl bg-brand-primary px-12 py-3 text-sm font-semibold text-white
                              hover:bg-brand-primary/90 transition
                              focus:outline-none focus:ring-2 focus:ring-brand-primary/30">
                        Daftar Sekarang
                    </a>
                </div>

                <p class="mt-4 text-center text-xs leading-5 text-gray-600">
                    Jika membutuhkan bantuan, silakan hubungi kanal layanan resmi pada halaman kontak atau menu informasi layanan.
                </p>
            </div>
        </section>

    </div>
</div>
@endsection
