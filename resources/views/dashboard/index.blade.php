@extends('layouts.app')

@section('title', 'Dashboard')

@push('styles')
<style>
    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .animate-slideInUp {
        animation: slideInUp 0.5s ease-out forwards;
        opacity: 0;
    }
</style>
@endpush

@section('breadcrumb')
    <nav class="flex" aria-label="Breadcrumb">
        <ol class="flex items-center space-x-2 text-sm">
            <li>
                <span class="text-gray-500">Dashboard</span>
            </li>
        </ol>
    </nav>
@endsection

@section('content')
    <!-- Welcome Section -->
    <div class="mb-6 sm:mb-8 animate-slideInUp px-2 sm:px-0">
        <h1 class="text-2xl sm:text-3xl font-bold bg-gradient-to-r from-brand-500 to-brand-700 bg-clip-text text-transparent">Selamat Datang, {{ auth()->user()->name }}! 👋</h1>
        <p class="mt-2 text-base sm:text-lg text-gray-600">Berikut adalah ringkasan sistem Anda</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 gap-4 mb-6 sm:grid-cols-2 lg:grid-cols-4 sm:gap-6 sm:mb-8">
        <!-- Total Users -->
        <div class="card hover:shadow-2xl hover:scale-105 transition-all duration-700 hover:-translate-y-3 animate-slideInUp cursor-pointer bg-gradient-to-r from-brand-50 via-brand-100 to-brand-200 border-brand-300 group overflow-hidden relative" style="animation-delay: 0.1s;" onclick="animateCard(this)">
            <div class="absolute inset-0 bg-gradient-to-r from-brand-500 to-brand-600 opacity-0 group-hover:opacity-10 transition-opacity duration-500"></div>
            <div class="flex items-center justify-between relative z-10">
                <div class="transform group-hover:scale-105 transition-transform duration-500">
                    <h3 class="text-sm font-bold text-brand-600 uppercase tracking-wider">Total Users</h3>
                    <p class="text-3xl sm:text-4xl font-black text-brand-800 mt-2 group-hover:text-brand-900 transition-colors duration-300">{{ \App\Models\User::count() }}</p>
                    <p class="text-xs text-brand-600 mt-1 font-semibold">Registered users in system</p>
                </div>
                <div class="flex-shrink-0 bg-gradient-to-br from-brand-500 to-brand-700 rounded-2xl p-3 sm:p-4 shadow-2xl transform group-hover:rotate-6 group-hover:scale-110 transition-all duration-500">
                    <svg class="h-8 w-8 sm:h-10 sm:w-10 text-white group-hover:animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
            </div>
            <div class="absolute -bottom-2 -right-2 w-16 h-16 bg-brand-300 rounded-full opacity-20 group-hover:opacity-40 transform group-hover:scale-150 transition-all duration-700"></div>
        </div>

        <!-- Active Users -->
        <div class="card hover:shadow-xl transition-all duration-500 hover:-translate-y-2 animate-slideInUp cursor-pointer bg-gradient-to-r from-green-50 to-green-100 border-green-200" style="animation-delay: 0.2s;">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-semibold text-green-600 uppercase tracking-wide">Active Users</h3>
                    <p class="text-3xl font-bold text-green-700 mt-2">{{ \App\Models\User::where('is_active', true)->count() }}</p>
                    <p class="text-xs text-green-500 mt-1">Currently active accounts</p>
                </div>
                <div class="flex-shrink-0 bg-green-500 rounded-xl p-3 shadow-lg">
                    <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Inactive Users -->
        <div class="card hover:shadow-xl transition-all duration-500 hover:-translate-y-2 animate-slideInUp cursor-pointer bg-gradient-to-r from-red-50 to-red-100 border-red-200" style="animation-delay: 0.3s;">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-semibold text-red-600 uppercase tracking-wide">Inactive Users</h3>
                    <p class="text-3xl font-bold text-red-700 mt-2">{{ \App\Models\User::where('is_active', false)->count() }}</p>
                    <p class="text-xs text-red-500 mt-1">Disabled user accounts</p>
                </div>
                <div class="flex-shrink-0 bg-red-500 rounded-xl p-3 shadow-lg">
                    <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Roles -->
        <div class="card hover:shadow-xl transition-all duration-500 hover:-translate-y-2 animate-slideInUp cursor-pointer bg-gradient-to-r from-blue-50 to-blue-100 border-blue-200" style="animation-delay: 0.4s;">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-semibold text-blue-600 uppercase tracking-wide">System Roles</h3>
                    <p class="text-3xl font-bold text-blue-700 mt-2">{{ \Spatie\Permission\Models\Role::count() }}</p>
                    <p class="text-xs text-blue-500 mt-1">Available user roles</p>
                </div>
                <div class="flex-shrink-0 bg-blue-500 rounded-xl p-3 shadow-lg">
                    <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>


    <!-- Recent Activity & Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6 mb-8">
        <!-- Recent Users -->
        <div class="card bg-gradient-to-br from-white to-gray-50">
            <div class="flex items-center justify-between mb-4 sm:mb-6">
                <h3 class="text-lg sm:text-xl font-bold text-gray-900 flex items-center">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 mr-2 text-brand-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    Recent Users
                </h3>
                <a href="{{ route('users.index') }}" class="inline-flex items-center px-2 sm:px-3 py-2 text-xs sm:text-sm font-medium text-brand-600 hover:text-white hover:bg-brand-600 border border-brand-600 rounded-lg transition-all duration-300">
                    View all
                    <svg class="ml-1 w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
            <div class="space-y-3 sm:space-y-4" id="recentUsersList">
                @php
                    $recentUsers = \App\Models\User::latest()->take(5)->get();
                @endphp
                @forelse($recentUsers as $user)
                    <div class="flex items-center p-3 sm:p-4 bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-300 border border-gray-100">
                        <img 
                            src="{{ $user->avatar_url }}" 
                            alt="{{ $user->name }}"
                            class="h-10 w-10 sm:h-12 sm:w-12 rounded-full object-cover ring-2 ring-gray-200"
                        >
                        <div class="ml-3 sm:ml-4 flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-900 truncate">{{ $user->name }}</p>
                            <p class="text-xs text-gray-500 truncate" title="{{ $user->email }}">{{ $user->email }}</p>
                            <p class="text-xs text-gray-400 mt-1">{{ $user->created_at->diffForHumans() }}</p>
                        </div>
                        <div class="flex flex-col items-end space-y-2">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium 
                                {{ $user->is_active ? 'bg-green-100 text-green-800 border border-green-200' : 'bg-red-100 text-red-800 border border-red-200' }}">
                                {{ $user->is_active ? 'Active' : 'Inactive' }}
                            </span>
                            @if($user->roles->count() > 0)
                                <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-blue-100 text-blue-800 border border-blue-200">
                                    {{ $user->roles->first()->name }}
                                </span>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No users found</h3>
                        <p class="mt-1 text-sm text-gray-500">Get started by creating a new user.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card bg-gradient-to-br from-white to-gray-50">
            <div class="flex items-center mb-4 sm:mb-6">
                <svg class="w-5 h-5 sm:w-6 sm:h-6 mr-2 text-brand-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
                <h3 class="text-lg sm:text-xl font-bold text-gray-900">Quick Actions</h3>
            </div>
            <div class="space-y-3 sm:space-y-4">
                @hasanyrole('superadmin|superadministrator|administrator')
                    <button onclick="openCreateUserModal()" class="w-full flex items-center justify-center px-4 sm:px-6 py-3 sm:py-4 bg-gradient-to-r from-brand-500 to-brand-600 text-white rounded-xl hover:from-brand-600 hover:to-brand-700 transition-all duration-300 shadow-lg hover:shadow-xl group" type="button">
                        <svg class="h-5 w-5 mr-3 transition-transform duration-300 group-hover:scale-110" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        <span class="font-semibold">Add New User</span>
                    </button>
                @endhasanyrole

                <button onclick="refreshDashboard()" class="w-full flex items-center justify-center px-4 sm:px-6 py-3 sm:py-4 bg-gradient-to-r from-green-500 to-green-600 text-white rounded-xl hover:from-green-600 hover:to-green-700 transition-all duration-300 shadow-lg hover:shadow-xl group" type="button">
                    <svg class="h-5 w-5 mr-3 transition-transform duration-300 group-hover:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    <span class="font-semibold">Refresh Data</span>
                </button>

                <a href="{{ route('users.index') }}" class="w-full flex items-center justify-center px-4 sm:px-6 py-3 sm:py-4 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-xl hover:from-blue-600 hover:to-blue-700 transition-all duration-300 shadow-lg hover:shadow-xl group">
                    <svg class="h-5 w-5 mr-3 transition-transform duration-300 group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <span class="font-semibold">Manage Users</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Search Results -->
    <div id="searchResults" class="mt-6" style="display: none;">
        <div class="card">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Search Results</h3>
                <button onclick="clearSearch()" class="text-sm text-gray-500 hover:text-gray-700">Clear</button>
            </div>
            <div id="searchResultsList"></div>
        </div>
    </div>

    <!-- System Info -->
    <div class="mt-8 card">
        <div class="flex items-center mb-6">
            <svg class="w-6 h-6 mr-2 text-brand-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l6.213-6.213a1 1 0 011.414 0l6.213 6.213a1 1 0 010 1.414L16.627 19.627a1 1 0 01-1.414 0L9 13.414a1 1 0 010-1.414z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7.828 10.828L12 15l4.172-4.172a4 4 0 000-5.656L12 1 7.828 5.172a4 4 0 000 5.656z" />
            </svg>
            <h3 class="text-xl font-bold text-gray-900">System Information</h3>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-4 rounded-xl border border-blue-200">
                <div class="text-sm font-semibold text-blue-600 uppercase tracking-wide">Laravel Version</div>
                <div class="text-xl font-bold text-blue-700 mt-1">{{ app()->version() }}</div>
            </div>
            <div class="bg-gradient-to-br from-purple-50 to-purple-100 p-4 rounded-xl border border-purple-200">
                <div class="text-sm font-semibold text-purple-600 uppercase tracking-wide">PHP Version</div>
                <div class="text-xl font-bold text-purple-700 mt-1">{{ PHP_VERSION }}</div>
            </div>
            <div class="bg-gradient-to-br from-green-50 to-green-100 p-4 rounded-xl border border-green-200">
                <div class="text-sm font-semibold text-green-600 uppercase tracking-wide">Environment</div>
                <div class="text-xl font-bold text-green-700 mt-1 capitalize">{{ app()->environment() }}</div>
            </div>
        </div>
    </div>
@endsection

<script>
// Global Toast Functions
window.showInfo = function(title, message, duration = 3000) {
    createToast('info', title, message, duration);
}

window.showSuccess = function(title, message, duration = 3000) {
    createToast('success', title, message, duration);
}

window.showError = function(title, message, duration = 5000) {
    createToast('error', title, message, duration);
}

function createToast(type, title, message, duration) {
    // Create toast container if it doesn't exist
    let container = document.getElementById('toast-container');
    if (!container) {
        container = document.createElement('div');
        container.id = 'toast-container';
        container.className = 'fixed top-4 right-4 z-50 space-y-2';
        document.body.appendChild(container);
    }

    // Check for duplicate toasts with same title and message
    const existingToasts = container.querySelectorAll('.toast-item');
    for (let existingToast of existingToasts) {
        const existingTitle = existingToast.querySelector('.toast-title')?.textContent;
        const existingMessage = existingToast.querySelector('.toast-message')?.textContent;
        if (existingTitle === title && existingMessage === message) {
            console.log('Duplicate toast prevented:', title, message);
            return; // Don't create duplicate toast
        }
    }

    // Create toast element
    const toast = document.createElement('div');
    const colors = {
        info: 'bg-blue-500',
        success: 'bg-green-500', 
        error: 'bg-red-500'
    };

    toast.className = `toast-item ${colors[type]} text-white px-4 py-3 rounded-lg shadow-lg transform translate-x-full transition-transform duration-300`;
    toast.innerHTML = `
        <div class="toast-title font-semibold">${title}</div>
        <div class="toast-message text-sm opacity-90">${message}</div>
    `;

    container.appendChild(toast);

    // Animate in
    setTimeout(() => {
        toast.classList.remove('translate-x-full');
    }, 10);

    // Auto remove
    setTimeout(() => {
        toast.classList.add('translate-x-full');
        setTimeout(() => {
            if (toast.parentNode) {
                toast.parentNode.removeChild(toast);
            }
        }, 300);
    }, duration);
}

// Global Search Functionality
let searchTimeout;
let mockUsers = [
    { name: 'Fadhli Raihan Rahman', email: 'fadhli@example.com', role: 'admin', status: 'active', avatar_url: 'https://ui-avatars.com/api/?name=Fadhli+Rahman&color=7F9CF5&background=EBF4FF' },
    { name: 'Super Administrator', email: 'superadmin@example.com', role: 'superadministrator', status: 'active', avatar_url: 'https://ui-avatars.com/api/?name=Super+Administrator&color=7F9CF5&background=EBF4FF' },
    { name: 'John Doe', email: 'john@example.com', role: 'user', status: 'inactive', avatar_url: 'https://ui-avatars.com/api/?name=John+Doe&color=7F9CF5&background=EBF4FF' },
    { name: 'Jane Smith', email: 'jane@example.com', role: 'user', status: 'active', avatar_url: 'https://ui-avatars.com/api/?name=Jane+Smith&color=7F9CF5&background=EBF4FF' },
    { name: 'Admin User', email: 'admin@example.com', role: 'admin', status: 'active', avatar_url: 'https://ui-avatars.com/api/?name=Admin+User&color=7F9CF5&background=EBF4FF' }
];

function performGlobalSearch() {
    clearTimeout(searchTimeout);
    
    searchTimeout = setTimeout(() => {
        const query = document.getElementById('globalSearch').value.toLowerCase().trim();
        const filter = document.getElementById('searchFilter').value;
        
        console.log('Searching for:', query, 'Filter:', filter);
        
        if (query.length === 0) {
            hideSearchPreview();
            return;
        }

        // Filter users based on search and status
        let filteredUsers = mockUsers.filter(user => {
            const matchesSearch = user.name.toLowerCase().includes(query) ||
                                user.email.toLowerCase().includes(query) ||
                                user.role.toLowerCase().includes(query);
            
            const matchesFilter = filter === 'all' || user.status === filter;
            
            return matchesSearch && matchesFilter;
        });

        updateSearchPreview(filteredUsers, query);
        updateSearchStats(filteredUsers.length);
        
    }, 300);
}

function updateSearchPreview(results, query) {
    const preview = document.getElementById('search-preview');
    const resultsContainer = document.getElementById('preview-results');
    
    if (results.length === 0) {
        resultsContainer.innerHTML = `
            <div class="text-center py-4">
                <svg class="mx-auto h-8 w-8 text-gray-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <p class="text-sm text-gray-500">No users found for "${query}"</p>
            </div>
        `;
    } else {
        resultsContainer.innerHTML = results.slice(0, 3).map(user => `
            <div class="flex items-center p-2 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                <div class="w-8 h-8 bg-brand-100 rounded-full flex items-center justify-center mr-3">
                    <img src="${user.avatar_url}" alt="${user.name}" class="w-8 h-8 rounded-full object-cover">
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 truncate">${highlightQuery(user.name, query)}</p>
                    <p class="text-xs text-gray-500 truncate">${highlightQuery(user.email, query)} • ${user.role}</p>
                </div>
                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium ${
                    user.status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'
                }">
                    ${user.status}
                </span>
            </div>
        `).join('');
        
        if (results.length > 3) {
            resultsContainer.innerHTML += `
                <div class="text-center py-2">
                    <p class="text-xs text-gray-500">+${results.length - 3} more results</p>
                </div>
            `;
        }
    }
    
    if (preview) {
        preview.classList.remove('hidden');
    }
}

function highlightQuery(text, query) {
    if (!query) return text;
    const regex = new RegExp(`(${query})`, 'gi');
    return text.replace(regex, '<mark class="bg-yellow-200 px-1 rounded">$1</mark>');
}

function hideSearchPreview() {
    const preview = document.getElementById('search-preview');
    if (preview) {
        preview.classList.add('hidden');
    }
    updateSearchStats(0);
}

function updateSearchStats(count) {
    const countEl = document.getElementById('search-results-count');
    const clearBtn = document.getElementById('clear-search');
    
    if (count > 0) {
        if (countEl) {
            countEl.textContent = `${count} result${count > 1 ? 's' : ''}`;
            countEl.classList.remove('hidden');
        }
        if (clearBtn) {
            clearBtn.classList.remove('hidden');
        }
    } else {
        if (countEl) {
            countEl.classList.add('hidden');
        }
        if (clearBtn) {
            clearBtn.classList.add('hidden');
        }
    }
}

function displaySearchResults(results) {
    const resultsContainer = document.getElementById('searchResultsList');
    const searchResults = document.getElementById('searchResults');
    
    if (results.length === 0) {
        resultsContainer.innerHTML = `
            <div class="text-center py-8">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No results found</h3>
                <p class="mt-1 text-sm text-gray-500">Try adjusting your search terms.</p>
            </div>
        `;
    } else {
        resultsContainer.innerHTML = results.map(user => `
            <div class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200 mb-3">
                <img src="${user.avatar_url}" alt="${user.name}" class="h-10 w-10 rounded-full object-cover">
                <div class="ml-3 flex-1">
                    <p class="text-sm font-medium text-gray-900">${user.name}</p>
                    <p class="text-xs text-gray-500">${user.email}</p>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${user.is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}">
                        ${user.is_active ? 'Active' : 'Inactive'}
                    </span>
                    ${user.roles.length > 0 ? `<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">${user.roles[0].name}</span>` : ''}
                </div>
            </div>
        `).join('');
    }
    
    searchResults.style.display = 'block';
}

function clearSearch() {
    document.getElementById('globalSearch').value = '';
    document.getElementById('searchResults').style.display = 'none';
}

function clearGlobalSearch() {
    document.getElementById('globalSearch').value = '';
    document.getElementById('searchFilter').value = 'all';
    hideSearchPreview();
    
    // Visual feedback
    const clearBtn = document.getElementById('clear-search');
    if (clearBtn) {
        clearBtn.textContent = 'Cleared!';
        setTimeout(() => {
            clearBtn.textContent = 'Clear';
        }, 1000);
    }
}

// Card animation function
function animateCard(element) {
    element.classList.add('toast-pulse');
    setTimeout(() => {
        element.classList.remove('toast-pulse');
    }, 600);
}

// FIXED Quick Action Functions - With Debouncing to Prevent Duplicates
let refreshInProgress = false;

window.refreshDashboard = function(event) {
    console.log('refreshDashboard called, inProgress:', refreshInProgress);
    
    // Prevent multiple simultaneous calls
    if (refreshInProgress) {
        console.log('Refresh already in progress, ignoring duplicate call');
        return;
    }
    
    if (event) {
        event.preventDefault();
        event.stopPropagation();
    }
    
    try {
        refreshInProgress = true;
        
        // Show loading state
        showInfo('Refreshing Dashboard', 'Memuat ulang data dashboard...');
        
        // Find the refresh button and add loading state
        const refreshBtn = event ? event.target.closest('button') : document.querySelector('button[onclick="refreshDashboard()"]');
        
        if (refreshBtn) {
            const originalContent = refreshBtn.innerHTML;
            refreshBtn.innerHTML = `
                <svg class="h-5 w-5 mr-3 animate-spin" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                <span class="font-semibold">Refreshing...</span>
            `;
            refreshBtn.disabled = true;
            
            // Restore button after delay
            setTimeout(() => {
                showSuccess('Success', 'Dashboard refreshed successfully!');
                setTimeout(() => {
                    window.location.reload();
                }, 500);
            }, 2000);
        } else {
            // Fallback if button not found
            setTimeout(() => {
                showSuccess('Success', 'Dashboard refreshed successfully!');
                setTimeout(() => {
                    window.location.reload();
                }, 500);
            }, 1500);
        }
        
    } catch (error) {
        console.error('Error in refreshDashboard:', error);
        showError('Error', 'Failed to refresh dashboard');
        refreshInProgress = false; // Reset flag on error
    }
};

let addUserInProgress = false;

window.openCreateUserModal = function(event) {
    console.log('openCreateUserModal called, inProgress:', addUserInProgress);
    
    // Prevent multiple simultaneous calls
    if (addUserInProgress) {
        console.log('Add User already in progress, ignoring duplicate call');
        return;
    }
    
    if (event) {
        event.preventDefault(); 
        event.stopPropagation();
    }
    
    try {
        addUserInProgress = true;
        
        // Show loading state
        showInfo('Redirecting', 'Mengarahkan ke halaman manajemen user...');
        
        // Find the add user button
        const createBtn = event ? event.target.closest('button') : document.querySelector('button[onclick="openCreateUserModal()"]');
        
        if (createBtn) {
            // Add visual feedback
            createBtn.classList.add('animate-pulse');
            createBtn.disabled = true;
            
            // Change button text temporarily
            const originalContent = createBtn.innerHTML;
            createBtn.innerHTML = `
                <svg class="h-5 w-5 mr-3 animate-spin" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                <span class="font-semibold">Redirecting...</span>
            `;
        }
        
        // Redirect after delay
        setTimeout(() => {
            window.location.href = '/users';
        }, 1200);
        
    } catch (error) {
        console.error('Error in openCreateUserModal:', error);
        showError('Error', 'Failed to redirect to user management');
        addUserInProgress = false; // Reset flag on error
    }
};

// Initialize dashboard
document.addEventListener('DOMContentLoaded', function() {
    console.log('Dashboard initialized successfully');
    console.log('Quick Actions available:');
    console.log('- Add New User (redirects to /users)');
    console.log('- Refresh Dashboard (reloads page)'); 
    console.log('- Manage Users (direct link to users page)');
    
    // Additional event listeners sebagai backup untuk memastikan buttons bekerja
    setupButtonEventListeners();
});

// Setup event listeners sebagai backup HANYA jika onclick tidak ada
function setupButtonEventListeners() {
    // Refresh Dashboard button - hanya tambah listener jika onclick tidak ada
    const refreshBtn = document.querySelector('button[onclick="refreshDashboard()"]');
    if (refreshBtn) {
        const hasOnclick = refreshBtn.getAttribute('onclick');
        if (!hasOnclick) {
            refreshBtn.addEventListener('click', function(e) {
                console.log('Refresh button clicked via event listener (no onclick)');
                window.refreshDashboard(e);
            });
            console.log('Refresh button event listener attached as fallback');
        } else {
            console.log('Refresh button using onclick attribute:', hasOnclick);
        }
    }
    
    // Add User button - hanya tambah listener jika onclick tidak ada
    const addUserBtn = document.querySelector('button[onclick="openCreateUserModal()"]');
    if (addUserBtn) {
        const hasOnclick = addUserBtn.getAttribute('onclick');
        if (!hasOnclick) {
            addUserBtn.addEventListener('click', function(e) {
                console.log('Add User button clicked via event listener (no onclick)');
                window.openCreateUserModal(e);
            });
            console.log('Add User button event listener attached as fallback');
        } else {
            console.log('Add User button using onclick attribute:', hasOnclick);
        }
    }
}

// Test function untuk debugging Quick Actions
window.testQuickActions = function() {
    console.log('=== QUICK ACTIONS TEST ===');
    
    // Test function availability
    console.log('refreshDashboard function:', typeof window.refreshDashboard);
    console.log('openCreateUserModal function:', typeof window.openCreateUserModal);
    
    // Test toast functions
    console.log('showInfo function:', typeof window.showInfo);
    console.log('showSuccess function:', typeof window.showSuccess);
    console.log('showError function:', typeof window.showError);
    
    // Test elements exist
    const refreshBtn = document.querySelector('button[onclick="refreshDashboard()"]');
    const addUserBtn = document.querySelector('button[onclick="openCreateUserModal()"]');
    const manageUsersLink = document.querySelector('a[href*="users"]');
    
    console.log('Refresh button exists:', !!refreshBtn);
    console.log('Add User button exists:', !!addUserBtn);
    console.log('Manage Users link exists:', !!manageUsersLink);
    
    if (refreshBtn) console.log('Refresh button onclick:', refreshBtn.getAttribute('onclick'));
    if (addUserBtn) console.log('Add User button onclick:', addUserBtn.getAttribute('onclick'));
    
    console.log('=== TEST COMPLETED ===');
    return 'Quick Actions test completed. Check console for details.';
};

// Manual test functions
window.testRefreshDashboard = function() {
    console.log('Testing Refresh Dashboard manually...');
    refreshInProgress = false; // Reset flag for testing
    window.refreshDashboard();
};

window.testAddNewUser = function() {
    console.log('Testing Add New User manually...');
    addUserInProgress = false; // Reset flag for testing
    window.openCreateUserModal();
};

// Function to clear all toasts (useful for debugging)
window.clearAllToasts = function() {
    const container = document.getElementById('toast-container');
    if (container) {
        container.innerHTML = '';
        console.log('All toasts cleared');
    }
};

// Function to reset all flags (useful for debugging)
window.resetAllFlags = function() {
    refreshInProgress = false;
    addUserInProgress = false;
    console.log('All progress flags reset');
};
</script>
