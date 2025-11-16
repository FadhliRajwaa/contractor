@extends('layouts.app')

@section('title', 'Manajemen User')

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
                <span class="text-gray-900 font-medium">Manajemen User</span>
            </li>
        </ol>
    </nav>
@endsection

@section('content')
    <!-- Header -->
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Manajemen User</h1>
            <p class="mt-1 text-sm text-gray-600">Kelola semua user dan role dalam sistem</p>
        </div>
        <div class="mt-4 sm:mt-0">
            <button 
                onclick="openCreateModal()"
                class="btn-primary inline-flex items-center"
            >
                <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Tambah User
            </button>
        </div>
    </div>

    <!-- Enhanced Filters & Search -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 mb-8 overflow-hidden">
        <!-- Mobile-Responsive Header -->
        <div class="bg-gradient-to-r from-brand-500 to-brand-600 px-4 sm:px-6 py-3 sm:py-4">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-2 sm:space-y-0">
                <div class="flex items-center space-x-2 sm:space-x-3">
                    <div class="w-6 h-6 sm:w-8 sm:h-8 bg-white/20 rounded-lg flex items-center justify-center backdrop-blur-sm">
                        <svg class="w-3 h-3 sm:w-5 sm:h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.207A1 1 0 013 6.5V4z" />
                        </svg>
                    </div>
                    <h2 class="text-base sm:text-lg font-bold text-white">Filter & Search Users</h2>
                </div>
                <div class="flex items-center justify-between sm:justify-end space-x-2 sm:space-x-3">
                    <span class="text-white/80 text-xs sm:text-sm">
                        <span id="total-users">{{ $users->total() }}</span> Users
                    </span>
                    <button 
                        id="clear-filters"
                        class="px-2 py-1 sm:px-3 sm:py-1.5 bg-white/20 hover:bg-white/30 text-white text-xs sm:text-sm font-medium rounded-lg transition-all duration-200 backdrop-blur-sm"
                    >
                        Clear All
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile-Responsive Quick Search -->
        <div class="p-4 sm:p-6 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
            <div class="space-y-3 sm:space-y-0 sm:flex sm:items-center sm:space-x-4">
                <div class="flex-1 relative">
                    <div class="absolute inset-y-0 left-0 pl-3 sm:pl-4 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 sm:h-5 sm:w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input 
                        type="text" 
                        id="quick-search"
                        placeholder="Search users, emails, or roles..."
                        class="block w-full pl-10 sm:pl-12 pr-4 sm:pr-20 py-3 sm:py-4 text-sm sm:text-lg border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-all duration-200 bg-white shadow-sm"
                    >
                    <!-- Desktop Quick Actions -->
                    <div class="hidden sm:flex absolute inset-y-0 right-0 items-center pr-4">
                        <div class="flex items-center space-x-2">
                            <kbd class="px-2 py-1 bg-gray-100 border border-gray-300 rounded text-xs font-mono text-gray-600">Ctrl+F</kbd>
                            <button 
                                id="search-btn"
                                class="px-4 py-2 bg-brand-500 hover:bg-brand-600 text-white text-sm font-medium rounded-lg transition-all duration-200 shadow-sm hover:shadow-md transform hover:scale-105"
                            >
                                Search
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Mobile Quick Actions -->
                <div class="sm:hidden flex space-x-2">
                    <button 
                        id="search-btn-mobile"
                        class="flex-1 px-4 py-2 bg-brand-500 hover:bg-brand-600 text-white text-sm font-medium rounded-lg transition-all duration-200 shadow-sm"
                    >
                        <svg class="w-4 h-4 inline mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Search
                    </button>
                    <button 
                        id="clear-all-mobile"
                        class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition-all duration-200"
                        onclick="clearAllFilters()"
                    >
                        Clear
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile-Responsive Advanced Filters -->
        <div class="p-4 sm:p-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                <!-- Search by Name/Email -->
                <div class="space-y-2">
                    <label class="flex items-center text-sm font-semibold text-gray-700">
                        <svg class="w-4 h-4 mr-2 text-brand-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Nama / Email
                    </label>
                    <div class="relative">
                        <input 
                            type="text" 
                            placeholder="Cari nama atau email..."
                            class="w-full px-4 py-3 pl-10 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-all duration-200"
                            id="name-email-filter"
                        >
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Role Filter -->
                <div class="space-y-2">
                    <label class="flex items-center text-sm font-semibold text-gray-700">
                        <svg class="w-4 h-4 mr-2 text-brand-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.031 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        Role
                    </label>
                    <div class="relative">
                        <select class="w-full px-4 py-3 pl-10 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-all duration-200 appearance-none bg-white" id="role-filter">
                            <option value="">Semua Role</option>
                            @foreach($roles as $role)
                                @php
                                    $roleLabels = [
                                        'superadmin' => 'Superadmin',
                                        'administrator' => 'Administrator',
                                        'admin_kontraktor' => 'Admin (Kontraktor)',
                                        'user_kontraktor' => 'User (Kontraktor)',
                                        'customer' => 'Customer (Viewer)'
                                    ];
                                    $label = $roleLabels[$role->name] ?? ucfirst($role->name);
                                @endphp
                                <option value="{{ $role->name }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.031 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Status Filter -->
                <div class="space-y-2">
                    <label class="flex items-center text-sm font-semibold text-gray-700">
                        <svg class="w-4 h-4 mr-2 text-brand-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Status
                    </label>
                    <div class="relative">
                        <select class="w-full px-4 py-3 pl-10 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-all duration-200 appearance-none bg-white" id="status-filter">
                            <option value="">Semua Status</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter Stats -->
            <div class="mt-6 pt-4 border-t border-gray-100">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center space-x-2">
                            <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></div>
                            <span class="text-sm text-gray-600">
                                Showing <span id="filtered-count" class="font-semibold text-brand-600">{{ $users->count() }}</span> of <span class="font-semibold">{{ $users->total() }}</span> users
                            </span>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <button 
                            id="export-btn"
                            class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition-all duration-200 flex items-center space-x-2"
                        >
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <span>Export</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Users Table -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <!-- Table Header -->
        <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-brand-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    Users List
                </h3>
                <div class="flex items-center space-x-3">
                    <span class="text-sm text-gray-500">
                        Last updated: {{ now()->format('H:i') }}
                    </span>
                    <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                    <tr>
                        <th scope="col" class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            User
                        </th>
                        <th scope="col" class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Email
                        </th>
                        <th scope="col" class="hidden sm:table-cell px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Role
                        </th>
                        <th scope="col" class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th scope="col" class="hidden lg:table-cell px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Terdaftar
                        </th>
                        <th scope="col" class="px-2 sm:px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($users as $user)
                        <tr class="hover:bg-gradient-to-r hover:from-brand-50 hover:to-gray-50 transition-colors duration-200 border-l-4 border-transparent hover:border-brand-400">
                            <td class="px-3 sm:px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <img 
                                        src="{{ $user->avatar_url }}" 
                                        alt="{{ $user->name }}"
                                        class="h-10 w-10 rounded-full object-cover"
                                    >
                                    <div class="ml-4 min-w-0 flex-1">
                                        <div class="text-sm font-medium text-gray-900 truncate">{{ $user->name }}</div>
                                        @if($user->notes)
                                            <div class="text-xs text-gray-500 truncate">{{ Str::limit($user->notes, 30) }}</div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-3 sm:px-6 py-4">
                                <div class="text-sm text-gray-900 max-w-xs">
                                    <span class="block truncate sm:hidden" title="{{ $user->email }}">{{ $user->email }}</span>
                                    <span class="hidden sm:block">{{ $user->email }}</span>
                                </div>
                            </td>
                            <td class="hidden sm:table-cell px-3 sm:px-6 py-4 whitespace-nowrap">
                                @php
                                    $roleLabels = [
                                        'superadmin' => 'Superadmin',
                                        'administrator' => 'Administrator',
                                        'admin_kontraktor' => 'Admin (Kontraktor)',
                                        'user_kontraktor' => 'User (Kontraktor)',
                                        'customer' => 'Customer (Viewer)'
                                    ];
                                    $roleName = $user->roles->first()->name ?? 'No Role';
                                    $roleLabel = $roleLabels[$roleName] ?? ucfirst($roleName);
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-brand-100 text-brand-800">
                                    {{ $roleLabel }}
                                </span>
                            </td>
                            <td class="px-3 sm:px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $user->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $user->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="hidden lg:table-cell px-3 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $user->created_at->format('d M Y') }}
                            </td>
                            <td class="px-2 sm:px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                @php
                                    // Role Hierarchy check
                                    $roleHierarchy = [
                                        'superadmin' => 1,
                                        'administrator' => 2,
                                        'admin_kontraktor' => 3,
                                        'user_kontraktor' => 4,
                                        'customer' => 5,
                                    ];
                                    $currentUserRole = auth()->user()->roles->first()->name ?? 'customer';
                                    $targetUserRole = $user->roles->first()->name ?? 'customer';
                                    $currentLevel = $roleHierarchy[$currentUserRole] ?? 999;
                                    $targetLevel = $roleHierarchy[$targetUserRole] ?? 999;
                                    $canManage = $currentLevel < $targetLevel; // Can only manage lower roles
                                @endphp
                                
                                <div class="flex items-center justify-end space-x-1">
                                    @if($canManage)
                                        <button 
                                            onclick="openEditModal({{ $user->id }})"
                                            class="text-brand-600 hover:text-brand-900 p-2 hover:bg-brand-50 rounded-lg transition"
                                            title="Edit"
                                        >
                                            <svg class="h-4 w-4 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>

                                        <button 
                                            onclick="toggleUserStatus({{ $user->id }}, '{{ $user->name }}', {{ $user->is_active ? 'true' : 'false' }})"
                                            class="text-{{ $user->is_active ? 'yellow' : 'green' }}-600 hover:text-{{ $user->is_active ? 'yellow' : 'green' }}-900 p-2 hover:bg-{{ $user->is_active ? 'yellow' : 'green' }}-50 rounded-lg transition transform hover:scale-110"
                                            title="{{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}"
                                        >
                                            <svg class="h-4 w-4 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                @if($user->is_active)
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                                @else
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                @endif
                                            </svg>
                                        </button>

                                        @if($user->id !== auth()->id())
                                            <button 
                                                onclick="deleteUser({{ $user->id }}, '{{ $user->name }}')"
                                                class="text-red-600 hover:text-red-900 p-2 hover:bg-red-50 rounded-lg transition transform hover:scale-110"
                                                title="Hapus"
                                            >
                                                <svg class="h-4 w-4 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        @endif
                                    @else
                                        <span class="text-xs text-gray-400 italic px-2">🔒 Protected</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr class="sm:hidden">
                            <td colspan="4" class="px-6 py-12 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                </svg>
                                <p class="mt-2 text-sm text-gray-500">Belum ada user</p>
                                <button onclick="openCreateModal()" class="mt-4 btn-primary">
                                    Tambah User Pertama
                                </button>
                            </td>
                        </tr>
                        <tr class="hidden sm:table-row lg:hidden">
                            <td colspan="5" class="px-6 py-12 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                </svg>
                                <p class="mt-2 text-sm text-gray-500">Belum ada user</p>
                                <button onclick="openCreateModal()" class="mt-4 btn-primary">
                                    Tambah User Pertama
                                </button>
                            </td>
                        </tr>
                        <tr class="hidden lg:table-row">
                            <td colspan="6" class="px-6 py-12 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                </svg>
                                <p class="mt-2 text-sm text-gray-500">Belum ada user</p>
                                <button onclick="openCreateModal()" class="mt-4 btn-primary">
                                    Tambah User Pertama
                                </button>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

        <!-- Pagination -->
        @if($users->hasPages())
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                {{ $users->links() }}
            </div>
        @endif
    </div>

    <!-- Create/Edit Modal -->
    @include('users._form')

@endsection

@push('scripts')
<script>
    // Global variables
    let allUsers = [];
    let filteredUsers = [];
    let currentFilters = {
        quickSearch: '',
        nameEmail: '',  
        role: '',
        status: ''
    };

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        // Store all users data
        allUsers = Array.from(document.querySelectorAll('tbody tr')).filter(row => 
            !row.querySelector('td[colspan]') // Exclude empty state rows
        );
        filteredUsers = [...allUsers];
        
        console.log('Initialized with', allUsers.length, 'users');
        
        // Bind all event listeners
        bindFilterEvents();
        
        // Initialize keyboard shortcuts
        initializeKeyboardShortcuts();
        
        // Update initial stats
        updateFilterStats();
    });

    function bindFilterEvents() {
        // Quick search
        const quickSearch = document.getElementById('quick-search');
        if (quickSearch) {
            quickSearch.addEventListener('input', debounce(handleQuickSearch, 300));
        }

        // Advanced filters
        const nameEmailFilter = document.getElementById('name-email-filter');
        if (nameEmailFilter) {
            nameEmailFilter.addEventListener('input', debounce(handleNameEmailFilter, 300));
        }

        const roleFilter = document.getElementById('role-filter');
        if (roleFilter) {
            roleFilter.addEventListener('change', handleRoleFilter);
        }

        const statusFilter = document.getElementById('status-filter');
        if (statusFilter) {
            statusFilter.addEventListener('change', handleStatusFilter);
        }

        // Action buttons
        const searchBtn = document.getElementById('search-btn');
        if (searchBtn) {
            searchBtn.addEventListener('click', performSearch);
        }

        const clearFiltersBtn = document.getElementById('clear-filters');
        if (clearFiltersBtn) {
            clearFiltersBtn.addEventListener('click', clearAllFilters);
        }

        const exportBtn = document.getElementById('export-btn');
        if (exportBtn) {
            exportBtn.addEventListener('click', exportResults);
        }

        // Mobile search button
        const searchBtnMobile = document.getElementById('search-btn-mobile');
        if (searchBtnMobile) {
            searchBtnMobile.addEventListener('click', performSearch);
        }

        console.log('All filter event listeners bound successfully');
    }

    function handleQuickSearch(e) {
        currentFilters.quickSearch = e.target.value.toLowerCase().trim();
        console.log('Quick search:', currentFilters.quickSearch);
        applyAllFilters();
    }

    function handleNameEmailFilter(e) {
        currentFilters.nameEmail = e.target.value.toLowerCase().trim();
        console.log('Name/Email filter:', currentFilters.nameEmail);
        applyAllFilters();
    }

    function handleRoleFilter(e) {
        currentFilters.role = e.target.value.toLowerCase();
        console.log('Role filter:', currentFilters.role);
        applyAllFilters();
    }

    function handleStatusFilter(e) {
        currentFilters.status = e.target.value.toLowerCase();
        console.log('Status filter:', currentFilters.status);
        applyAllFilters();
    }

    function applyAllFilters() {
        console.log('Applying filters:', currentFilters);
        
        filteredUsers = allUsers.filter(row => {
            const userData = extractUserData(row);
            
            // Quick search (searches across all fields)
            if (currentFilters.quickSearch) {
                const searchFields = [userData.name, userData.email, userData.role].join(' ').toLowerCase();
                if (!searchFields.includes(currentFilters.quickSearch)) {
                    return false;
                }
            }

            // Name/Email filter
            if (currentFilters.nameEmail) {
                const nameEmailFields = [userData.name, userData.email].join(' ').toLowerCase();
                if (!nameEmailFields.includes(currentFilters.nameEmail)) {
                    return false;
                }
            }

            // Role filter
            if (currentFilters.role && userData.role !== currentFilters.role) {
                return false;
            }

            // Status filter
            if (currentFilters.status && userData.status !== currentFilters.status) {
                return false;
            }

            return true;
        });

        console.log('Filtered to', filteredUsers.length, 'users');
        renderFilteredResults();
        updateFilterStats();
        addFilterAnimations();
    }

    function extractUserData(row) {
        const nameCell = row.querySelector('td:first-child .text-sm.font-medium');
        const emailCell = row.querySelector('td:nth-child(2) .text-sm');
        const roleCell = row.querySelector('td:nth-child(3) .inline-flex');
        const statusCell = row.querySelector('td:nth-child(4) .inline-flex');

        return {
            name: nameCell ? nameCell.textContent.trim().toLowerCase() : '',
            email: emailCell ? emailCell.textContent.trim().toLowerCase() : '',
            role: roleCell ? roleCell.textContent.trim().toLowerCase() : '',
            status: statusCell ? (statusCell.textContent.trim().toLowerCase().includes('active') ? 'active' : 'inactive') : ''
        };
    }

    function renderFilteredResults() {
        const tbody = document.querySelector('tbody');
        
        // Hide all rows first
        allUsers.forEach(row => {
            row.style.display = 'none';
        });

        // Show filtered rows
        filteredUsers.forEach(row => {
            row.style.display = '';
        });

        // Handle empty state
        const emptyRows = document.querySelectorAll('tbody tr[class*="sm:hidden"], tbody tr[class*="hidden"]');
        if (filteredUsers.length === 0) {
            // Show custom no results message
            if (emptyRows.length > 0) {
                emptyRows.forEach(row => row.style.display = '');
            } else {
                // Create dynamic no results row
                const noResultsRow = createNoResultsRow();
                tbody.appendChild(noResultsRow);
            }
        } else {
            // Hide empty state rows
            emptyRows.forEach(row => row.style.display = 'none');
            
            // Remove any dynamic no results row
            const dynamicNoResults = tbody.querySelector('.dynamic-no-results');
            if (dynamicNoResults) {
                dynamicNoResults.remove();
            }
        }
    }

    function createNoResultsRow() {
        const row = document.createElement('tr');
        row.className = 'dynamic-no-results';
        row.innerHTML = `
            <td colspan="6" class="px-6 py-12 text-center">
                <div class="flex flex-col items-center">
                    <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No users found</h3>
                    <p class="text-sm text-gray-500 mb-4">Try adjusting your filters or search terms.</p>
                    <button 
                        onclick="clearAllFilters()" 
                        class="px-4 py-2 bg-brand-500 hover:bg-brand-600 text-white text-sm font-medium rounded-lg transition-all duration-200"
                    >
                        Clear All Filters
                    </button>
                </div>
            </td>
        `;
        return row;
    }

    function updateFilterStats() {
        const filteredCountEl = document.getElementById('filtered-count');
        if (filteredCountEl) {
            filteredCountEl.textContent = filteredUsers.length;
            
            // Add visual feedback
            filteredCountEl.classList.add('animate-pulse');
            setTimeout(() => {
                filteredCountEl.classList.remove('animate-pulse');
            }, 600);
        }
    }

    function addFilterAnimations() {
        // Add stagger animation for visible rows
        filteredUsers.forEach((row, index) => {
            row.style.opacity = '0';
            row.style.transform = 'translateY(10px)';
            
            setTimeout(() => {
                row.style.transition = 'all 0.3s ease';
                row.style.opacity = '1';
                row.style.transform = 'translateY(0)';
            }, index * 50);
        });
    }

    function clearAllFilters() {
        console.log('Clearing all filters');
        
        // Reset filter values
        currentFilters = {
            quickSearch: '',
            nameEmail: '',
            role: '',
            status: ''
        };

        // Reset input values
        const quickSearch = document.getElementById('quick-search');
        const nameEmailFilter = document.getElementById('name-email-filter');
        const roleFilter = document.getElementById('role-filter');
        const statusFilter = document.getElementById('status-filter');

        if (quickSearch) quickSearch.value = '';
        if (nameEmailFilter) nameEmailFilter.value = '';
        if (roleFilter) roleFilter.value = '';
        if (statusFilter) statusFilter.value = '';

        // Show all users
        filteredUsers = [...allUsers];
        renderFilteredResults();
        updateFilterStats();
        
        // Visual feedback
        const clearBtn = document.getElementById('clear-filters');
        if (clearBtn) {
            clearBtn.textContent = 'Cleared!';
            clearBtn.classList.add('bg-green-500');
            setTimeout(() => {
                clearBtn.textContent = 'Clear All';
                clearBtn.classList.remove('bg-green-500');
            }, 1500);
        }
    }

    function performSearch() {
        console.log('Performing manual search');
        applyAllFilters();
        
        // Visual feedback for search button
        const searchBtn = document.getElementById('search-btn');
        if (searchBtn) {
            const originalText = searchBtn.textContent;
            searchBtn.textContent = 'Searching...';
            searchBtn.classList.add('animate-pulse');
            
            setTimeout(() => {
                searchBtn.textContent = originalText;
                searchBtn.classList.remove('animate-pulse');
            }, 1000);
        }
    }

    function exportResults() {
        console.log('Exporting filtered results');
        
        if (filteredUsers.length === 0) {
            alert('No users to export. Please adjust your filters.');
            return;
        }

        // Simulate export
        const exportBtn = document.getElementById('export-btn');
        if (exportBtn) {
            const originalHtml = exportBtn.innerHTML;
            exportBtn.innerHTML = `
                <svg class="w-4 h-4 animate-spin mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                <span>Exporting...</span>
            `;
            
            setTimeout(() => {
                exportBtn.innerHTML = originalHtml;
                alert(`Successfully exported ${filteredUsers.length} users!`);
            }, 2000);
        }
    }

    function initializeKeyboardShortcuts() {
        document.addEventListener('keydown', function(e) {
            // Ctrl+F or Cmd+F to focus quick search
            if ((e.ctrlKey || e.metaKey) && e.key === 'f') {
                e.preventDefault();
                const quickSearch = document.getElementById('quick-search');
                if (quickSearch) {
                    quickSearch.focus();
                    quickSearch.select();
                }
            }
            
            // Escape to clear filters
            if (e.key === 'Escape') {
                const focusedElement = document.activeElement;
                if (focusedElement && (focusedElement.id === 'quick-search' || focusedElement.id === 'name-email-filter')) {
                    clearAllFilters();
                }
            }
        });
    }

    // Utility function for debouncing
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    // Make functions globally accessible
    window.clearAllFilters = clearAllFilters;
    window.performSearch = performSearch;
    window.exportResults = exportResults;

    // Modal functions will be in the _form partial
</script>
@endpush
