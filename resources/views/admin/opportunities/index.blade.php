<x-app-layout>
    <x-slot name="header">
        <div class="w-full">
            <p class="text-[11px] font-semibold tracking-widest text-brand-primary uppercase">Admin</p>
            <h2 class="mt-1 text-2xl font-bold tracking-tight text-gray-900">Data Peluang Bisnis</h2>
            <p class="mt-1 text-sm text-gray-600">Kelola data peluang bisnis yang tampil di halaman publik.</p>
        </div>
    </x-slot>

    <div class="bg-gray-50">
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">

            {{-- ACTION BAR --}}
            <div class="mb-5 flex items-center justify-end">
                <a href="{{ route('admin.peluang_bisnis.create') }}"
                   class="group inline-flex items-center gap-2 rounded-xl
                          bg-brand-primary px-4 py-2.5 text-sm font-semibold text-white
                          shadow-sm transition
                          hover:bg-brand-primary/90 hover:shadow
                          focus:outline-none focus:ring-2 focus:ring-brand-primary/30 focus:ring-offset-2">

                    <span class="flex h-9 w-9 items-center justify-center rounded-lg
                                 bg-white/15 ring-1 ring-white/20
                                 transition group-hover:bg-white/20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 4v16m8-8H4"/>
                        </svg>
                    </span>

                    <span class="leading-none">Tambah Data</span>
                </a>
            </div>

            @if(session('success'))
                <div class="mb-5 rounded-2xl border border-brand-neutral bg-white px-4 py-3 shadow-sm">
                    <div class="flex items-start gap-3">
                        <div class="mt-0.5 flex h-8 w-8 items-center justify-center rounded-xl bg-brand-cta/15 text-brand-cta border border-brand-cta/30">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="text-sm font-semibold text-gray-900">Berhasil</div>
                            <div class="text-sm text-gray-600">{{ session('success') }}</div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- CARD --}}
            <div class="rounded-3xl bg-white shadow-sm border border-brand-neutral overflow-hidden">

                {{-- TOP BAR --}}
                <div class="flex items-center justify-between border-b border-brand-neutral px-5 py-4">
                    <div>
                        <div class="text-sm font-extrabold text-gray-900">Data Peluang Bisnis</div>
                        <div class="text-xs text-gray-500">Total: {{ $items->total() }} data</div>
                    </div>

                    <div class="text-xs text-gray-600">
                        <span class="inline-flex items-center gap-2 rounded-full bg-brand-soft/10 px-3 py-1 border border-brand-neutral">
                            <span class="h-1.5 w-1.5 rounded-full bg-brand-primary"></span>
                            Terakhir update: {{ now()->format('d M Y') }}
                        </span>
                    </div>
                </div>

                {{-- TABLE --}}
                <div class="overflow-x-auto">
                    <table class="w-full table-fixed border-collapse">
                        <colgroup>
                            <col class="w-[36%]">  {{-- Produk --}}
                            <col class="w-[16%]">  {{-- Kategori --}}
                            <col class="w-[18%]">  {{-- Koordinat --}}
                            <col class="w-[12%]">  {{-- Unggulan --}}
                            <col class="w-[10%]">  {{-- Aktif --}}
                            <col class="w-[8%]">   {{-- Aksi --}}
                        </colgroup>

                        <thead class="bg-white">
                            <tr class="border-b border-brand-neutral text-xs font-semibold uppercase tracking-wider text-gray-500">
                                <th class="px-6 py-4 text-center">Produk</th>
                                <th class="px-6 py-4 text-center">Kategori</th>
                                <th class="px-6 py-4 text-center">Koordinat</th>
                                <th class="px-6 py-4 text-center">Unggulan</th>
                                <th class="px-6 py-4 text-center">Aktif</th>
                                <th class="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-brand-neutral">
                            @forelse($items as $item)
                                <tr class="hover:bg-gray-50/70">

                                    {{-- PRODUK (Nama + Jenis) --}}
                                    <td class="px-6 py-4 align-middle">
                                        <div class="flex w-full justify-center">
                                            <div class="flex items-center gap-3 max-w-full">
                                                <div class="h-9 w-9 rounded-xl bg-brand-primary text-white flex items-center justify-center shrink-0">
                                                    ◎
                                                </div>

                                                <div class="min-w-0 text-center">
                                                    <div class="text-sm font-semibold text-gray-900 truncate">
                                                        {{ $item->product_name }}
                                                    </div>

                                                    <div class="mt-0.5 text-xs text-gray-500 truncate">
                                                        {{ $item->product_type ?? '—' }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- KATEGORI --}}
                                    <td class="px-6 py-4 align-middle">
                                        <div class="flex w-full justify-center">
                                            <span class="rounded-full bg-brand-soft/15 px-3 py-1.5 text-xs font-semibold text-brand-primary border border-brand-neutral">
                                                {{ $item->category }}
                                            </span>
                                        </div>
                                    </td>

                                    {{-- KOORDINAT --}}
                                    <td class="px-6 py-4 align-middle">
                                        <div class="flex w-full justify-center">
                                            <div class="rounded-xl bg-gray-50 px-3 py-2 text-xs text-gray-700 border border-brand-neutral text-left">
                                                <div><span class="text-gray-500">Lat:</span> {{ $item->lat }}</div>
                                                <div><span class="text-gray-500">Lng:</span> {{ $item->lng }}</div>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- UNGGULAN --}}
                                    <td class="px-6 py-4 align-middle">
                                        <div class="flex w-full justify-center">
                                            @if($item->is_featured)
                                                <span class="min-w-[90px] rounded-full bg-yellow-50 px-3 py-1.5 text-xs font-semibold text-yellow-800 border border-yellow-200 text-center">
                                                    Unggulan
                                                </span>
                                            @else
                                                <span class="min-w-[90px] rounded-full bg-gray-50 px-3 py-1.5 text-xs font-semibold text-gray-600 border border-brand-neutral text-center">
                                                    —
                                                </span>
                                            @endif
                                        </div>
                                    </td>

                                    {{-- AKTIF --}}
                                    <td class="px-6 py-4 align-middle">
                                        <div class="flex w-full justify-center">
                                            @if($item->is_active)
                                                <span class="min-w-[90px] rounded-full bg-brand-cta/15 px-3 py-1.5 text-xs font-semibold text-brand-cta border border-brand-cta/30 text-center">
                                                    Aktif
                                                </span>
                                            @else
                                                <span class="min-w-[90px] rounded-full bg-gray-50 px-3 py-1.5 text-xs font-semibold text-gray-700 border border-brand-neutral text-center">
                                                    Nonaktif
                                                </span>
                                            @endif
                                        </div>
                                    </td>

                                    {{-- AKSI --}}
                                    <td class="px-6 py-4 align-middle">
                                        <div class="flex w-full justify-center gap-2">

                                            {{-- DELETE --}}
                                            <form action="{{ route('admin.peluang_bisnis.destroy', $item->id) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Yakin hapus data ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        title="Hapus"
                                                        class="inline-flex h-9 w-9 items-center justify-center rounded-lg
                                                               border border-brand-neutral bg-white text-gray-700 shadow-sm
                                                               transition hover:bg-red-50 hover:border-red-200 hover:text-red-700
                                                               focus:outline-none focus:ring-2 focus:ring-red-200 focus:ring-offset-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                         viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3m-4 0h14"/>
                                                    </svg>
                                                </button>
                                            </form>

                                        </div>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-14 text-center text-gray-600">
                                        Belum ada data
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- BOTTOM --}}
                <div class="flex flex-col gap-3 border-t border-brand-neutral px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
                    <div class="text-xs text-gray-500">
                        Menampilkan {{ $items->firstItem() ?? 0 }} – {{ $items->lastItem() ?? 0 }} dari {{ $items->total() }} data
                    </div>

                    <div class="text-sm">
                        {{ $items->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
