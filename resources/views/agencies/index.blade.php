@extends('layouts.app')

@section('title', 'Agency / Kontraktor')

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
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 mb-8 p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2 text-brand-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            Tambah Agency / Kontraktor
        </h2>

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

            <div class="md:col-span-2 flex justify-end mt-2">
                <button type="submit" class="btn-primary inline-flex items-center">
                    <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Simpan Agency
                </button>
            </div>
        </form>
    </div>

    <!-- List Agency -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100">
        <div class="px  -6 py-4 border-b border-gray-200 flex items-center justify-between">
            <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                <svg class="w-5 h-5 mr-2 text-brand-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7l9-4 9 4-9 4-9-4zm0 6l9 4 9-4" />
                </svg>
                Daftar Agency / Kontraktor
            </h2>
            <span class="text-sm text-gray-500">Total: {{ $agencies->total() }} agency</span>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Kontraktor</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">PIC</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dibuat</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($agencies as $agency)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-sm text-gray-500">{{ $agency->id }}</td>
                            <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $agency->name }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $agency->email ?: '-' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $agency->phone ?: '-' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $agency->pic_name ?: '-' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-500">{{ $agency->created_at?->format('d M Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-sm text-gray-500">
                                Belum ada agency terdaftar. Tambahkan agency pertama di atas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($agencies->hasPages())
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                {{ $agencies->links() }}
            </div>
        @endif
    </div>
@endsection
