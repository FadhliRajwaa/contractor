@extends('layouts.app')

@section('title', 'Agency / Kontraktor')

@php use Illuminate\Support\Str; @endphp

@section('breadcrumb')
    <nav class="flex" aria-label="Breadcrumb">
        <ol class="flex items-center space-x-2 text-sm">
            <li>
                <a href="{{ route('dashboard') }}" class="text-gray-500 hover:text-gray-700">Dashboard</a>
            </li>
            <li>
                <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                </svg>
            </li>
            <li>
                <span class="text-gray-900 font-medium">Agency / Kontraktor</span>
            </li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Agency / Kontraktor</h1>
            <p class="mt-1 text-sm text-gray-600">
                Data ini akan menjadi naungan invoice dan PKS, berisi informasi kontraktor: PT / Nama Kontraktor, alamat, kontak, dan PIC.
            </p>
        </div>
    </div>

    <!-- Form Tambah Agency -->
    @can('create agencies')
    <div class="bg-gradient-to-br from-white via-white to-brand-50 rounded-2xl shadow-lg border border-gray-100 mb-8 p-6 md:p-7">
        <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4 mb-4">
            <div>
                <h2 class="text-lg md:text-xl font-semibold text-gray-900 flex items-center">
                    <span class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-brand-100 text-brand-600 mr-3">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                    </span>
                    Tambah Agency / Kontraktor
                </h2>
                <p class="mt-1 text-xs md:text-sm text-gray-500">
                    Lengkapi data utama kontraktor (nama, alamat, kontak, dan PIC) yang akan menjadi dasar pembuatan PKS & invoice.
                </p>
            </div>
            <div class="flex items-center gap-2 bg-white/70 border border-dashed border-brand-200 rounded-xl px-3 py-2 text-[11px] md:text-xs text-gray-600">
                <span class="inline-flex items-center justify-center w-6 h-6 rounded-lg bg-brand-100 text-brand-600 mr-1">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7l9-4 9 4-9 4-9-4zm0 6l9 4 9-4" />
                    </svg>
                </span>
                <div class="leading-tight">
                    <p class="font-semibold text-gray-800">Tip</p>
                    <p>Gunakan nama resmi sesuai legal dokumen (PT/CV) untuk menghindari salah penagihan.</p>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('agencies.store') }}" class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
            @csrf

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kontraktor <span class="text-red-500">*</span></label>
                <input 
                    type="text" 
                    name="name" 
                    value="{{ old('name') }}" 
                    required
                    class="input-field w-full"
                    placeholder="PT Nama Kontraktor"
                >
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                <textarea 
                    name="address" 
                    rows="3"
                    class="input-field w-full"
                    placeholder="Alamat lengkap kantor / workshop Kontraktor"
                >{{ old('address') }}</textarea>
                @error('address')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input 
                    type="email" 
                    name="email" 
                    value="{{ old('email') }}"
                    class="input-field w-full"
                    placeholder="email@kontraktor.com"
                >
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                <input 
                    type="text" 
                    name="phone" 
                    value="{{ old('phone') }}"
                    class="input-field w-full"
                    placeholder="Nomor telepon / WhatsApp"
                >
                @error('phone')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">PIC (Penanggung Jawab)</label>
                <input 
                    type="text" 
                    name="pic_name" 
                    value="{{ old('pic_name') }}"
                    class="input-field w-full"
                    placeholder="Nama PIC / Penanggung Jawab"
                >
                @error('pic_name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="md:col-span-2 flex flex-col sm:flex-row sm:items-center sm:justify-between mt-3 gap-3">
                <p class="text-[11px] text-gray-500 flex items-center">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 mr-2 animate-pulse"></span>
                    Data agency akan digunakan di berbagai modul (invoice, PKS, dan manajemen proyek).
                </p>
                <button type="submit" class="btn-primary inline-flex items-center justify-center w-full sm:w-auto">
                    <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Simpan Agency
                </button>
            </div>
        </form>
    </div>
    @endcan

    <!-- List Agency -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100">
        <div class="px-6 py-4 border-b border-gray-200 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                <svg class="w-5 h-5 mr-2 text-brand-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7l9-4 9 4-9 4-9-4zm0 6l9 4 9-4" />
                </svg>
                Daftar Agency / Kontraktor
            </h2>
            <div class="flex flex-col sm:flex-row sm:items-center gap-2 md:gap-3">
                <span class="text-sm text-gray-500">Total: {{ $agencies->total() }} agency</span>
                <div class="relative w-full sm:w-64">
                    <span class="absolute inset-y-0 left-2 flex items-center text-gray-400">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M11 6a5 5 0 100 10 5 5 0 000-10z" />
                        </svg>
                    </span>
                    <input
                        id="agencySearch"
                        type="text"
                        class="input-field w-full pl-8 pr-3 py-2 text-xs sm:text-sm"
                        placeholder="Cari agency (nama, email, phone, PIC)"
                    >
                </div>
            </div>
        </div>

        <!-- Mobile: Card list -->
        <div class="block md:hidden px-4 pt-3 pb-4 space-y-3">
            @forelse($agencies as $agency)
                <div class="agency-card rounded-xl border border-gray-100 bg-gradient-to-br from-gray-50 to-white shadow-sm hover:shadow-md transition-all duration-200">
                    <div class="p-3.5 flex items-start gap-3">
                        <div class="w-10 h-10 rounded-xl bg-brand-100 text-brand-600 flex items-center justify-center flex-shrink-0">
                            <span class="text-sm font-bold">{{ Str::of($agency->name)->substr(0,2)->upper() }}</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between gap-2">
                                <p class="text-sm font-semibold text-gray-900 truncate">{{ $agency->name }}</p>
                                <div class="flex items-center gap-1.5">
                                    <span class="text-[10px] px-2 py-0.5 rounded-full bg-gray-100 text-gray-600 border border-gray-200">
                                        ID #{{ $agencies->firstItem() ? $agencies->firstItem() + $loop->index : $loop->iteration }}
                                    </span>
                                    <span class="text-[10px] px-2 py-0.5 rounded-full {{ $agency->is_active ? 'bg-green-100 text-green-700 border-green-200' : 'bg-red-100 text-red-700 border-red-200' }} border">
                                        {{ $agency->is_active ? 'Aktif' : 'Non-Aktif' }}
                                    </span>
                                </div>
                            </div>
                            <p class="mt-0.5 text-xs text-gray-500 line-clamp-2">{{ $agency->address ?: 'Alamat belum diisi' }}</p>

                            <div class="mt-2 flex flex-wrap gap-2 text-[11px]">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-blue-50 text-blue-700 border border-blue-100">
                                    <svg class="w-3 h-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14v7" />
                                    </svg>
                                    {{ $agency->email ?: 'Email belum diisi' }}
                                </span>

                                <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-green-50 text-green-700 border border-green-100">
                                    <svg class="w-3 h-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h2.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-1.257.628a11.042 11.042 0 005.516 5.516l.628-1.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                    {{ $agency->phone ?: 'No. telepon belum diisi' }}
                                </span>

                                <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-purple-50 text-purple-700 border border-purple-100">
                                    <svg class="w-3 h-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    {{ $agency->pic_name ?: 'PIC belum diisi' }}
                                </span>
                            </div>

                            <div class="mt-2 flex items-center justify-between text-[11px] text-gray-500">
                                <span>
                                    Dibuat {{ $agency->created_at?->format('d/m/Y H:i') ?? '-' }}
                                </span>
                            </div>

                            <div class="mt-3 flex items-center justify-end gap-2">
                                @can('edit agencies')
                                    <button
                                        type="button"
                                        class="inline-flex items-center px-2.5 py-1 rounded-lg text-[11px] font-medium {{ $agency->is_active ? 'bg-yellow-50 text-yellow-700 border-yellow-200 hover:bg-yellow-100' : 'bg-green-50 text-green-700 border-green-200 hover:bg-green-100' }} border transition-colors"
                                        onclick="toggleAgencyStatus({{ $agency->id }}, this)"
                                    >
                                        <svg class="w-3.5 h-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M{{ $agency->is_active ? '18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636' : '9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z' }}" />
                                        </svg>
                                        {{ $agency->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                    </button>
                                @endcan

                                @can('edit agencies')
                                    <button
                                        type="button"
                                        class="inline-flex items-center px-2.5 py-1 rounded-lg text-[11px] font-medium bg-amber-50 text-amber-700 border border-amber-200 hover:bg-amber-100 transition-colors"
                                        onclick="openEditAgencyModal(this)"
                                        data-agency-id="{{ $agency->id }}"
                                        data-agency-name="{{ $agency->name }}"
                                        data-agency-address="{{ $agency->address }}"
                                        data-agency-email="{{ $agency->email }}"
                                        data-agency-phone="{{ $agency->phone }}"
                                        data-agency-pic="{{ $agency->pic_name }}"
                                    >
                                        <svg class="w-3.5 h-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5h2m-1 0v2m-6 4h10M5 19h14" />
                                        </svg>
                                        Edit
                                    </button>
                                @endcan

                                @can('delete agencies')
                                    <form
                                        method="POST"
                                        action="{{ route('agencies.destroy', $agency) }}"
                                        class="inline delete-agency-form"
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            type="button"
                                            onclick="openDeleteAgencyModal(this)"
                                            data-agency-name="{{ $agency->name }}"
                                            class="inline-flex items-center px-2.5 py-1 rounded-lg text-[11px] font-medium bg-red-50 text-red-600 border border-red-200 hover:bg-red-100 transition-colors"
                                        >
                                            <svg class="w-3.5 h-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 7h12M9 7V5a1 1 0 011-1h4a1 1 0 011 1v2m-1 4v6m-4-6v6M5 7l1 12a2 2 0 002 2h8a2 2 0 002-2l1-12" />
                                            </svg>
                                            Hapus
                                        </button>
                                    </form>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="px-2 py-6 text-center text-sm text-gray-500">
                    Belum ada agency terdaftar. Tambahkan agency pertama di atas.
                </div>
            @endforelse
        </div>

        <!-- Desktop: Tabel -->
        <div class="hidden md:block overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Kontraktor</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">PIC</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dibuat</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($agencies as $agency)
                        <tr class="agency-row hover:bg-gray-50">
                            <td class="px-4 py-3 text-sm text-gray-500">#{{ $agencies->firstItem() ? $agencies->firstItem() + $loop->index : $loop->iteration }}</td>
                            <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $agency->name }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $agency->email ?: '-' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $agency->phone ?: '-' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $agency->pic_name ?: '-' }}</td>
                            <td class="px-4 py-3 text-sm">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $agency->is_active ? 'bg-green-100 text-green-800 border border-green-200' : 'bg-red-100 text-red-800 border border-red-200' }}">
                                    {{ $agency->is_active ? 'Aktif' : 'Non-Aktif' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-500">{{ $agency->created_at?->format('d M Y') }}</td>
                            <td class="px-4 py-3 text-sm text-right whitespace-nowrap space-x-1">
                                @can('edit agencies')
                                    <button
                                        type="button"
                                        class="inline-flex items-center px-2.5 py-1.5 rounded-lg text-xs font-medium {{ $agency->is_active ? 'bg-yellow-50 text-yellow-700 border-yellow-200 hover:bg-yellow-100' : 'bg-green-50 text-green-700 border-green-200 hover:bg-green-100' }} border transition-colors"
                                        onclick="toggleAgencyStatus({{ $agency->id }}, this)"
                                    >
                                        <svg class="w-3.5 h-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M{{ $agency->is_active ? '18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636' : '9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z' }}" />
                                        </svg>
                                        {{ $agency->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                    </button>
                                @endcan

                                @can('edit agencies')
                                    <button
                                        type="button"
                                        class="inline-flex items-center px-2.5 py-1.5 rounded-lg text-xs font-medium bg-amber-50 text-amber-700 border border-amber-200 hover:bg-amber-100 transition-colors"
                                        onclick="openEditAgencyModal(this)"
                                        data-agency-id="{{ $agency->id }}"
                                        data-agency-name="{{ $agency->name }}"
                                        data-agency-address="{{ $agency->address }}"
                                        data-agency-email="{{ $agency->email }}"
                                        data-agency-phone="{{ $agency->phone }}"
                                        data-agency-pic="{{ $agency->pic_name }}"
                                    >
                                        <svg class="w-3.5 h-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5h2m-1 0v2m-6 4h10M5 19h14" />
                                        </svg>
                                        Edit
                                    </button>
                                @endcan

                                @can('delete agencies')
                                    <form
                                        method="POST"
                                        action="{{ route('agencies.destroy', $agency) }}"
                                        class="inline delete-agency-form"
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            type="button"
                                            onclick="openDeleteAgencyModal(this)"
                                            data-agency-name="{{ $agency->name }}"
                                            class="inline-flex items-center px-2.5 py-1.5 rounded-lg text-xs font-medium bg-red-50 text-red-600 border border-red-200 hover:bg-red-100 transition-colors"
                                        >
                                            <svg class="w-3.5 h-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 7h12M9 7V5a1 1 0 011-1h4a1 1 0 011 1v2m-1 4v6m-4-6v6M5 7l1 12a2 2 0 002 2h8a2 2 0 002-2l1-12" />
                                            </svg>
                                            Hapus
                                        </button>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-8 text-center text-sm text-gray-500">
                                Belum ada agency terdaftar. Tambahkan agency pertama di atas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div id="agencySearchEmpty" class="hidden px-6 py-6 text-center text-sm text-gray-500 border-t border-gray-50">
            Tidak ada agency yang cocok dengan pencarian.
        </div>

        @if($agencies->hasPages())
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                {{ $agencies->links() }}
            </div>
        @endif
    </div>

    @can('edit agencies')
    <!-- Edit Agency Modal -->
    <div 
        id="editAgencyModal" 
        class="modal-backdrop z-50 flex items-center justify-center p-4 opacity-0"
        style="display: none;"
    >
        <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full max-h-[90vh] overflow-y-auto transform transition-all duration-500 scale-95 opacity-0 mx-2 sm:mx-0" id="editAgencyModalContent">
            <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-xl bg-brand-100 text-brand-600 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5h2m-1 0v2m-6 4h10M5 19h14" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-gray-900">Edit Agency / Kontraktor</h3>
                        <p class="text-[11px] text-gray-500">Perbarui informasi agency dengan hati-hati.</p>
                    </div>
                </div>
                <button type="button" onclick="closeEditAgencyModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form id="editAgencyForm" method="POST" action="#" class="px-5 py-4 space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Nama Kontraktor <span class="text-red-500">*</span></label>
                    <input
                        type="text"
                        name="name"
                        id="editAgencyName"
                        class="input-field w-full text-sm"
                        required
                    >
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Alamat</label>
                    <textarea
                        name="address"
                        id="editAgencyAddress"
                        rows="3"
                        class="input-field w-full text-sm"
                    ></textarea>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Email</label>
                        <input
                            type="email"
                            name="email"
                            id="editAgencyEmail"
                            class="input-field w-full text-sm"
                        >
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Phone</label>
                        <input
                            type="text"
                            name="phone"
                            id="editAgencyPhone"
                            class="input-field w-full text-sm"
                        >
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">PIC (Penanggung Jawab)</label>
                    <input
                        type="text"
                        name="pic_name"
                        id="editAgencyPic"
                        class="input-field w-full text-sm"
                    >
                </div>

                <div class="flex items-center justify-end gap-2 pt-1 pb-2">
                    <button type="button" onclick="closeEditAgencyModal()" class="px-3 py-2 text-xs sm:text-sm rounded-lg border border-gray-200 text-gray-600 hover:bg-gray-50">Batal</button>
                    <button type="submit" class="btn-primary inline-flex items-center justify-center px-4 py-2 text-xs sm:text-sm">
                        <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endcan
@endsection

<script>
    // ===== Edit Agency Modal (follow user management style) =====
    function openEditAgencyModal(button) {
        const modal = document.getElementById('editAgencyModal');
        const modalContent = document.getElementById('editAgencyModalContent');
        const form = document.getElementById('editAgencyForm');

        if (!modal || !form || !modalContent) return;

        const id = button.getAttribute('data-agency-id');
        const name = button.getAttribute('data-agency-name') || '';
        const address = button.getAttribute('data-agency-address') || '';
        const email = button.getAttribute('data-agency-email') || '';
        const phone = button.getAttribute('data-agency-phone') || '';
        const pic = button.getAttribute('data-agency-pic') || '';

        document.getElementById('editAgencyName').value = name;
        document.getElementById('editAgencyAddress').value = address;
        document.getElementById('editAgencyEmail').value = email;
        document.getElementById('editAgencyPhone').value = phone;
        document.getElementById('editAgencyPic').value = pic;

        form.action = '{{ url('agencies') }}' + '/' + id;

        // Show modal with smooth animation (same pattern as user modal)
        modal.style.display = 'flex';
        modal.offsetHeight; // force reflow

        setTimeout(() => {
            modal.classList.remove('opacity-0');
            modal.classList.add('opacity-100');
            modalContent.classList.remove('scale-95', 'opacity-0');
            modalContent.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    function closeEditAgencyModal() {
        const modal = document.getElementById('editAgencyModal');
        const modalContent = document.getElementById('editAgencyModalContent');
        if (!modal || !modalContent) return;

        // Animate out (same pattern as user modal)
        modalContent.classList.remove('scale-100', 'opacity-100');
        modalContent.classList.add('scale-95', 'opacity-0');
        modal.classList.remove('opacity-100');
        modal.classList.add('opacity-0');

        setTimeout(() => {
            modal.style.display = 'none';
        }, 300);
    }

    // Close modal on Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeEditAgencyModal();
        }
    });

    // Close modal when clicking backdrop
    document.getElementById('editAgencyModal')?.addEventListener('click', function(event) {
        if (event.target === this) {
            closeEditAgencyModal();
        }
    });

    // ===== Delete Agency Confirmation (use global confirmDelete like user management) =====
    function openDeleteAgencyModal(button) {
        const form = button.closest('form.delete-agency-form');
        if (!form) return;

        const name = button.getAttribute('data-agency-name') || 'agency ini';

        confirmDelete(name, () => {
            form.submit();
        });
    }

    // ===== Toggle Agency Status =====
    async function toggleAgencyStatus(agencyId, button) {
        // Get agency name and current status from button attributes
        const agencyName = button.closest('.agency-card, .agency-row')?.querySelector('[class*="font-semibold"], [class*="font-medium"]')?.textContent?.trim() || 'agency ini';
        const isCurrentlyActive = button.textContent.includes('Nonaktifkan');
        
        // Show confirmation dialog first
        if (isCurrentlyActive) {
            // Agency is active, ask to disable
            confirmDisable(agencyName, async () => {
                await executeToggleStatus(agencyId, button);
            });
        } else {
            // Agency is inactive, ask to enable
            confirmEnable(agencyName, async () => {
                await executeToggleStatus(agencyId, button);
            });
        }
    }

    // Actual toggle execution after confirmation
    async function executeToggleStatus(agencyId, button) {
        try {
            button.disabled = true;
            button.style.opacity = '0.6';

            const response = await fetch(`/agencies/${agencyId}/toggle-status`, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            });

            const data = await response.json();

            if (data.success) {
                // Show success message
                if (typeof showSuccess === 'function') {
                    showSuccess(data.message);
                }

                // Reload the page to update all status displays
                setTimeout(() => {
                    window.location.reload();
                }, 500);
            } else {
                throw new Error(data.message || 'Gagal mengubah status');
            }
        } catch (error) {
            console.error('Error toggling agency status:', error);
            if (typeof showError === 'function') {
                showError('Terjadi kesalahan saat mengubah status agency.');
            } else {
                alert('Terjadi kesalahan saat mengubah status agency.');
            }
            button.disabled = false;
            button.style.opacity = '1';
        }
    }

    // ===== Client-side Search Filter =====
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('agencySearch');
        if (!searchInput) return;

        const cards = Array.from(document.querySelectorAll('.agency-card'));
        const rows = Array.from(document.querySelectorAll('.agency-row'));
        const emptyState = document.getElementById('agencySearchEmpty');

        function normalize(text) {
            return (text || '').toString().toLowerCase();
        }

        function getAgencyTextFromCard(card) {
            return normalize(card.textContent);
        }

        function getAgencyTextFromRow(row) {
            return normalize(row.textContent);
        }

        function applyFilter() {
            const term = normalize(searchInput.value);
            let visibleCount = 0;

            cards.forEach(card => {
                const match = term === '' || getAgencyTextFromCard(card).includes(term);
                if (match) {
                    card.style.display = '';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                } else {
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(4px)';
                    setTimeout(() => {
                        card.style.display = 'none';
                    }, 150);
                }
                if (match) visibleCount++;
            });

            rows.forEach(row => {
                const match = term === '' || getAgencyTextFromRow(row).includes(term);
                if (match) {
                    row.style.display = '';
                    row.style.opacity = '1';
                    row.style.transform = 'translateY(0)';
                } else {
                    row.style.opacity = '0';
                    row.style.transform = 'translateY(4px)';
                    setTimeout(() => {
                        row.style.display = 'none';
                    }, 150);
                }
                if (match) visibleCount++;
            });

            if (emptyState) {
                if (term && visibleCount === 0) {
                    emptyState.classList.remove('hidden');
                } else {
                    emptyState.classList.add('hidden');
                }
            }
        }

        let debounceTimer;
        searchInput.addEventListener('input', function() {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(applyFilter, 160);
        });
    });
</script>
