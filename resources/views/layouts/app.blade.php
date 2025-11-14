<!DOCTYPE html>
<html lang="id" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - ContractorApp</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full">
    <div class="min-h-full">
        <!-- Mobile Sidebar Toggle -->
        <div class="lg:hidden fixed top-0 left-0 right-0 z-50 bg-white border-b border-gray-200 px-4 py-2 sm:py-3 flex items-center justify-between">
            <div class="flex items-center">
                <button 
                    type="button" 
                    id="mobile-menu-btn"
                    class="text-gray-600 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-brand-500 rounded-lg p-2"
                >
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <span class="ml-2 text-lg sm:text-xl font-bold text-brand-600">ContractorApp</span>
            </div>
            <div class="flex items-center space-x-2">
                <button 
                    type="button"
                    id="mobile-search-btn" 
                    class="p-2 rounded-lg hover:bg-gray-100 transition-all duration-200 hover:scale-105"
                    onclick="toggleMobileSearch()"
                >
                    <svg class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Desktop Sidebar -->
        <div class="hidden lg:flex lg:w-64 lg:flex-col lg:fixed lg:inset-y-0 lg:overflow-hidden">
            <div class="flex flex-col h-full bg-white shadow-2xl">
                <!-- Logo -->
                <div class="flex items-center justify-center h-16 px-6 bg-gradient-to-br from-brand-500 via-brand-600 to-brand-700 relative overflow-hidden">
                    <!-- Background Pattern -->
                    <div class="absolute inset-0 opacity-10">
                        <div class="absolute top-0 -right-4 w-32 h-32 bg-white rounded-full"></div>
                        <div class="absolute bottom-0 -left-4 w-24 h-24 bg-white rounded-full"></div>
                    </div>
                    <div class="relative flex items-center space-x-2">
                        <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center shadow-lg">
                            <svg class="w-5 h-5 text-brand-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                            </svg>
                        </div>
                        <h1 class="text-xl font-bold text-white tracking-wide">ContractorApp</h1>
                    </div>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 overflow-y-auto py-6 px-3">
                    <div class="space-y-2">
                        <!-- Dashboard -->
                        <a 
                            href="{{ route('dashboard') }}" 
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-300 transform hover:scale-105 {{ request()->routeIs('dashboard') ? 'bg-gradient-to-r from-brand-50 to-brand-100 text-brand-700 shadow-md border-l-4 border-brand-500' : 'text-gray-700 hover:bg-gradient-to-r hover:from-gray-50 hover:to-gray-100 hover:shadow-sm' }}"
                        >
                            <div class="flex items-center justify-center w-8 h-8 mr-3 rounded-lg {{ request()->routeIs('dashboard') ? 'bg-brand-500 text-white' : 'bg-gray-100 text-gray-600 group-hover:bg-brand-100 group-hover:text-brand-600' }} transition-all duration-300">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                            </div>
                            <span class="font-semibold">Dashboard</span>
                            @if(request()->routeIs('dashboard'))
                                <div class="ml-auto w-2 h-2 bg-brand-500 rounded-full animate-pulse"></div>
                            @endif
                        </a>

                        <!-- User Management (Superadmin / Administrator) -->
                        @role('superadmin|superadministrator|administrator')
                        <a 
                            href="{{ route('users.index') }}" 
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-300 transform hover:scale-105 {{ request()->routeIs('users.*') ? 'bg-gradient-to-r from-brand-50 to-brand-100 text-brand-700 shadow-md border-l-4 border-brand-500' : 'text-gray-700 hover:bg-gradient-to-r hover:from-gray-50 hover:to-gray-100 hover:shadow-sm' }}"
                        >
                            <div class="flex items-center justify-center w-8 h-8 mr-3 rounded-lg {{ request()->routeIs('users.*') ? 'bg-brand-500 text-white' : 'bg-gray-100 text-gray-600 group-hover:bg-brand-100 group-hover:text-brand-600' }} transition-all duration-300">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </div>
                            <span class="font-semibold">Manajemen User</span>
                            @if(request()->routeIs('users.*'))
                                <div class="ml-auto w-2 h-2 bg-brand-500 rounded-full animate-pulse"></div>
                            @endif
                        </a>
                        @endrole

                        <!-- Agencies (Only for Admin Kontraktor) -->
                        @role('admin_kontraktor')
                        <a 
                            href="{{ route('agencies.index') }}" 
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-300 transform hover:scale-105 {{ request()->routeIs('agencies.*') ? 'bg-gradient-to-r from-brand-50 to-brand-100 text-brand-700 shadow-md border-l-4 border-brand-500' : 'text-gray-700 hover:bg-gradient-to-r hover:from-gray-50 hover:to-gray-100 hover:shadow-sm' }}"
                        >
                            <div class="flex items-center justify-center w-8 h-8 mr-3 rounded-lg {{ request()->routeIs('agencies.*') ? 'bg-brand-500 text-white' : 'bg-gray-100 text-gray-600 group-hover:bg-brand-100 group-hover:text-brand-600' }} transition-all duration-300">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7l9-4 9 4-9 4-9-4zm0 6l9 4 9-4" />
                                </svg>
                            </div>
                            <span class="font-semibold">Agencies / Kontraktor</span>
                            @if(request()->routeIs('agencies.*'))
                                <div class="ml-auto w-2 h-2 bg-brand-500 rounded-full animate-pulse"></div>
                            @endif
                        </a>
                        @endrole

                        <!-- Placeholder for future modules -->
                        <div class="pt-6 mt-6 border-t border-gray-100 relative">
                            <div class="flex items-center mb-4">
                                <div class="h-px bg-gradient-to-r from-transparent via-gray-300 to-transparent flex-1"></div>
                                <p class="px-3 text-xs font-bold text-gray-400 uppercase tracking-wider bg-white">
                                    Coming Soon
                                </p>
                                <div class="h-px bg-gradient-to-r from-transparent via-gray-300 to-transparent flex-1"></div>
                            </div>
                            <div class="space-y-2">
                                <div class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl cursor-not-allowed opacity-60 hover:opacity-75 transition-all duration-300">
                                    <div class="flex items-center justify-center w-8 h-8 mr-3 rounded-lg bg-gradient-to-br from-blue-100 to-blue-200 text-blue-600">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <span class="font-semibold text-gray-500">Projects</span>
                                    <div class="ml-auto flex items-center space-x-2">
                                        <span class="text-xs bg-gradient-to-r from-orange-400 to-pink-400 text-white px-3 py-1 rounded-full font-bold shadow-sm">
                                            Soon
                                        </span>
                                        <div class="w-1 h-1 bg-orange-400 rounded-full animate-ping"></div>
                                    </div>
                                </div>
                                <div class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl cursor-not-allowed opacity-60 hover:opacity-75 transition-all duration-300">
                                    <div class="flex items-center justify-center w-8 h-8 mr-3 rounded-lg bg-gradient-to-br from-green-100 to-green-200 text-green-600">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                    </div>
                                    <span class="font-semibold text-gray-500">Finance</span>
                                    <div class="ml-auto flex items-center space-x-2">
                                        <span class="text-xs bg-gradient-to-r from-purple-400 to-indigo-400 text-white px-3 py-1 rounded-full font-bold shadow-sm">
                                            Soon
                                        </span>
                                        <div class="w-1 h-1 bg-purple-400 rounded-full animate-ping"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>

                <!-- User Section -->
                <div class="flex-shrink-0 border-t border-gray-100 p-3 bg-gradient-to-r from-gray-50 to-white">
                    <div class="flex items-center p-2 rounded-xl hover:bg-white hover:shadow-lg transition-all duration-300 cursor-pointer group">
                        <div class="relative flex-shrink-0">
                            <img 
                                src="{{ auth()->user()->avatar_url }}" 
                                alt="{{ auth()->user()->name }}"
                                class="h-10 w-10 rounded-lg object-cover border-2 border-white shadow-md group-hover:border-brand-200 transition-all duration-300"
                            >
                            <div class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-green-500 rounded-full border-2 border-white shadow-sm"></div>
                        </div>
                        <div class="ml-3 flex-1 min-w-0 overflow-hidden max-w-[140px]">
                            <p class="text-sm font-bold text-gray-800 truncate group-hover:text-brand-700 transition-colors duration-300">
                                {{ auth()->user()->name }}
                            </p>
                            <div class="flex items-center mt-0.5">
                                <div class="w-1.5 h-1.5 bg-brand-500 rounded-full mr-2 animate-pulse flex-shrink-0"></div>
                                <p class="text-xs font-medium text-gray-500 truncate">
                                    {{ Str::limit(auth()->user()->roles->first()->name ?? 'User', 15) }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile Sidebar -->
        <div id="sidebar" class="fixed inset-y-0 left-0 z-40 w-64 bg-white shadow-2xl transform -translate-x-full transition-transform duration-300 ease-in-out lg:hidden">
            <div class="flex flex-col h-full">
                <!-- Logo -->
                <div class="flex items-center justify-between h-16 px-6 bg-gradient-to-br from-brand-500 via-brand-600 to-brand-700 relative overflow-hidden flex-shrink-0">
                    <!-- Background Pattern -->
                    <div class="absolute inset-0 opacity-10">
                        <div class="absolute top-0 -right-4 w-32 h-32 bg-white rounded-full"></div>
                        <div class="absolute bottom-0 -left-4 w-24 h-24 bg-white rounded-full"></div>
                    </div>
                    <div class="relative flex items-center space-x-2">
                        <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center shadow-lg">
                            <svg class="w-5 h-5 text-brand-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                            </svg>
                        </div>
                        <h1 class="text-xl font-bold text-white tracking-wide">ContractorApp</h1>
                    </div>
                    <!-- Close Button for Mobile -->
                    <button 
                        onclick="toggleSidebar()" 
                        class="relative lg:hidden text-white hover:bg-white/20 rounded-lg p-1.5 transition-colors duration-200"
                    >
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                
                <!-- Mobile Navigation -->
                <nav class="flex-1 overflow-y-auto py-4 px-3">
                    <div class="space-y-2">
                        <!-- Dashboard -->
                        <a href="{{ route('dashboard') }}" class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-300 transform hover:scale-105 {{ request()->routeIs('dashboard') ? 'bg-gradient-to-r from-brand-50 to-brand-100 text-brand-700 shadow-md border-l-4 border-brand-500' : 'text-gray-700 hover:bg-gradient-to-r hover:from-gray-50 hover:to-gray-100 hover:shadow-sm' }}">
                            <div class="flex items-center justify-center w-8 h-8 mr-3 rounded-lg {{ request()->routeIs('dashboard') ? 'bg-brand-500 text-white' : 'bg-gray-100 text-gray-600 group-hover:bg-brand-100 group-hover:text-brand-600' }} transition-all duration-300">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                            </div>
                            <span class="font-semibold">Dashboard</span>
                            @if(request()->routeIs('dashboard'))
                                <div class="ml-auto w-2 h-2 bg-brand-500 rounded-full animate-pulse"></div>
                            @endif
                        </a>
                        
                        @role('superadmin|superadministrator|administrator')
                        <a href="{{ route('users.index') }}" class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-300 transform hover:scale-105 {{ request()->routeIs('users.*') ? 'bg-gradient-to-r from-brand-50 to-brand-100 text-brand-700 shadow-md border-l-4 border-brand-500' : 'text-gray-700 hover:bg-gradient-to-r hover:from-gray-50 hover:to-gray-100 hover:shadow-sm' }}">
                            <div class="flex items-center justify-center w-8 h-8 mr-3 rounded-lg {{ request()->routeIs('users.*') ? 'bg-brand-500 text-white' : 'bg-gray-100 text-gray-600 group-hover:bg-brand-100 group-hover:text-brand-600' }} transition-all duration-300">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </div>
                            <span class="font-semibold">Manajemen User</span>
                            @if(request()->routeIs('users.*'))
                                <div class="ml-auto w-2 h-2 bg-brand-500 rounded-full animate-pulse"></div>
                            @endif
                        </a>
                        @endrole
                    </div>
                </nav>
                
                <!-- Mobile User Section with Logout -->
                <div class="flex-shrink-0 border-t border-gray-100 bg-gradient-to-r from-gray-50 to-white">
                    <!-- User Info -->
                    <div class="px-3 pt-3 pb-2">
                        <div class="flex items-center p-2 rounded-xl bg-white shadow-sm">
                            <div class="relative flex-shrink-0">
                                <img 
                                    src="{{ auth()->user()->avatar_url }}" 
                                    alt="{{ auth()->user()->name }}"
                                    class="h-10 w-10 rounded-lg object-cover border-2 border-white shadow-md"
                                >
                                <div class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-green-500 rounded-full border-2 border-white shadow-sm"></div>
                            </div>
                            <div class="ml-3 flex-1 min-w-0 overflow-hidden">
                                <p class="text-sm font-bold text-gray-800 truncate">
                                    {{ auth()->user()->name }}
                                </p>
                                <div class="flex items-center mt-0.5">
                                    <div class="w-1.5 h-1.5 bg-brand-500 rounded-full mr-2 animate-pulse flex-shrink-0"></div>
                                    <p class="text-xs font-medium text-gray-500 truncate">
                                        @php
                                            $roleLabels = [
                                                'superadmin' => 'Superadmin',
                                                'administrator' => 'Administrator',
                                                'admin_kontraktor' => 'Admin Kontraktor',
                                                'user_kontraktor' => 'User Kontraktor',
                                                'customer' => 'Customer'
                                            ];
                                            $roleName = auth()->user()->roles->first()->name ?? 'User';
                                            $roleLabel = $roleLabels[$roleName] ?? ucfirst($roleName);
                                        @endphp
                                        {{ Str::limit($roleLabel, 18) }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Logout Button -->
                    <div class="px-3 pb-3">
                        <form method="POST" action="{{ route('logout') }}" class="w-full">
                            @csrf
                            <button 
                                type="submit"
                                class="w-full flex items-center justify-center px-4 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-red-500 to-red-600 rounded-xl hover:from-red-600 hover:to-red-700 transition-all duration-300 shadow-md hover:shadow-lg transform hover:scale-[1.02]"
                            >
                                <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Desktop Search Modal -->
        <div 
            id="desktop-search-modal"
            class="fixed inset-0 z-50 hidden lg:flex items-start justify-center pt-20"
            style="display: none;"
        >
            <div 
                class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm desktop-search-backdrop" 
                data-close="true"
            ></div>
            <div 
                class="relative w-full max-w-2xl mx-4 bg-white rounded-2xl shadow-2xl overflow-hidden desktop-search-content"
                data-close="false"
            >
                <div class="flex items-center p-6 border-b border-gray-100">
                    <div class="flex-1 relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input 
                            type="text" 
                            id="desktop-search-input"
                            class="block w-full pl-12 pr-4 py-4 text-lg border-0 focus:ring-0 focus:outline-none"
                            placeholder="Search anything..."
                            onkeyup="performDesktopSearch()"
                        >
                    </div>
                    <button 
                        type="button"
                        id="desktop-search-close-btn"
                        class="ml-4 p-2 rounded-lg hover:bg-gray-100 transition-colors duration-200"
                        data-close="true"
                    >
                        <svg class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div id="desktop-search-results" class="max-h-96 overflow-y-auto p-6 hidden">
                    <!-- Search results akan muncul di sini -->
                </div>
                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                    <div class="flex items-center justify-between text-sm text-gray-500">
                        <span>Press <kbd class="px-2 py-1 bg-white border border-gray-300 rounded text-xs font-mono">Enter</kbd> to search</span>
                        <span>Press <kbd class="px-2 py-1 bg-white border border-gray-300 rounded text-xs font-mono">Esc</kbd> to close</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile Search Modal -->
        <div 
            id="mobile-search-modal"
            class="fixed inset-0 z-50 lg:hidden hidden"
        >
            <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm" onclick="closeMobileSearch()"></div>
            <div class="fixed top-0 left-0 right-0 bg-white border-b border-gray-200 p-4 shadow-lg">
                <div class="flex items-center space-x-3">
                    <button 
                        type="button"
                        onclick="closeMobileSearch()"
                        class="p-2 rounded-lg hover:bg-gray-100"
                    >
                        <svg class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                    <div class="flex-1 relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input 
                            type="text" 
                            id="mobile-search-input"
                            class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-brand-500 focus:border-brand-500 text-sm"
                            placeholder="Search users, dashboard..."
                            onkeyup="performMobileSearch()"
                        >
                    </div>
                </div>
                <div id="mobile-search-results" class="mt-4 max-h-96 overflow-y-auto hidden">
                    <!-- Search results akan muncul di sini -->
                </div>
            </div>
        </div>

        <!-- Mobile Sidebar Overlay -->
        <div 
            id="sidebar-overlay"
            class="sidebar-backdrop z-30 lg:hidden hidden"
        ></div>

        <!-- Main Content -->
        <div class="lg:pl-64 flex flex-col min-h-screen pt-16 lg:pt-0">
            <!-- Top Bar -->
            <div class="sticky top-0 z-10 bg-white border-b border-gray-200 lg:block hidden">
                <div class="px-4 sm:px-6 lg:px-8">
                    <div class="flex h-16 items-center justify-between">
                        <!-- Breadcrumb -->
                        <div class="flex-1">
                            @yield('breadcrumb')
                        </div>

                        <!-- Top Right Actions -->
                        <div class="flex items-center space-x-4">
                            <!-- Search -->
                            <button 
                                type="button"
                                id="desktop-search-btn"
                                class="p-2 rounded-lg hover:bg-gray-100 transition-all duration-200 hover:scale-105"
                                onclick="toggleDesktopSearch()"
                            >
                                <svg class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </button>

                            <!-- User Dropdown -->
                            <div class="relative" id="userDropdown">
                                <button 
                                    id="userDropdownButton"
                                    class="flex items-center space-x-3 p-3 rounded-xl hover:bg-gradient-to-r hover:from-gray-50 hover:to-gray-100 transition-all duration-300 transform hover:scale-105 group"
                                >
                                    <div class="relative">
                                        <img 
                                            src="{{ auth()->user()->avatar_url }}" 
                                            alt="{{ auth()->user()->name }}"
                                            class="h-10 w-10 rounded-full object-cover ring-2 ring-brand-200 group-hover:ring-brand-400 transition-all duration-300"
                                        >
                                        <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-500 border-2 border-white rounded-full animate-pulse"></div>
                                    </div>
                                    <div class="hidden sm:block text-left">
                                        <p class="text-sm font-semibold text-gray-900 group-hover:text-brand-700 transition-colors duration-300">
                                            {{ auth()->user()->name }}
                                        </p>
                                        <p class="text-xs text-gray-500 group-hover:text-brand-500 transition-colors duration-300">
                                            {{ auth()->user()->roles->first()->name ?? 'User' }}
                                        </p>
                                    </div>
                                    <svg class="h-4 w-4 text-gray-600 group-hover:text-brand-600 transform group-hover:rotate-180 transition-all duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>

                                <div 
                                    id="userDropdownMenu"
                                    class="absolute right-0 mt-3 w-64 bg-white rounded-2xl shadow-2xl border border-gray-100 backdrop-blur-sm bg-opacity-95 transform scale-95 opacity-0 pointer-events-none transition-all duration-300"
                                    style="display: none;"
                                >
                                    <!-- User Info -->
                                    <div class="px-4 py-4 border-b border-gray-100 bg-gradient-to-r from-brand-50 to-brand-100 rounded-t-2xl">
                                        <div class="flex items-center space-x-3">
                                            <img 
                                                src="{{ auth()->user()->avatar_url }}" 
                                                alt="{{ auth()->user()->name }}"
                                                class="h-12 w-12 rounded-full object-cover ring-2 ring-white shadow-lg"
                                            >
                                            <div>
                                                <p class="text-sm font-bold text-gray-900">{{ auth()->user()->name }}</p>
                                                <p class="text-xs text-brand-600 font-semibold">{{ auth()->user()->email }}</p>
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-brand-100 text-brand-800 mt-1">
                                                    {{ auth()->user()->roles->first()->name ?? 'User' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Menu Items -->
                                    <div class="py-2">
                                        <a href="#" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gradient-to-r hover:from-brand-50 hover:to-brand-100 hover:text-brand-700 transition-all duration-200 group">
                                            <svg class="h-5 w-5 mr-3 text-gray-400 group-hover:text-brand-500 transition-colors duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                            <span class="font-medium">Profil Saya</span>
                                            <svg class="ml-auto h-4 w-4 opacity-0 group-hover:opacity-100 transition-opacity duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </a>
                                        
                                        <a href="#" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gradient-to-r hover:from-blue-50 hover:to-blue-100 hover:text-blue-700 transition-all duration-200 group">
                                            <svg class="h-5 w-5 mr-3 text-gray-400 group-hover:text-blue-500 transition-colors duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            <span class="font-medium">Pengaturan</span>
                                            <svg class="ml-auto h-4 w-4 opacity-0 group-hover:opacity-100 transition-opacity duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </a>
                                        
                                        <hr class="my-2 border-gray-100">
                                        
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="flex items-center w-full px-4 py-3 text-sm text-red-600 hover:bg-gradient-to-r hover:from-red-50 hover:to-red-100 hover:text-red-700 transition-all duration-200 group">
                                                <svg class="h-5 w-5 mr-3 text-red-400 group-hover:text-red-500 transition-colors duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                                </svg>
                                                <span class="font-medium">Logout</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Page Content -->
            <main class="flex-1">
                <div class="px-3 py-4 sm:px-6 sm:py-6 lg:px-8 pb-8">
                    <!-- Flash Messages -->
                    @if(session('success'))
                        <div class="mb-4 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mb-4 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <!-- Mobile Sidebar Toggle Script -->
    <script>
        // Alpine.js alternative using vanilla JS
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuBtn = document.getElementById('mobile-menu-btn');
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');

            if (mobileMenuBtn) {
                mobileMenuBtn.addEventListener('click', function() {
                    sidebar.classList.toggle('-translate-x-full');
                    overlay.classList.toggle('hidden');
                });
            }

            if (overlay) {
                overlay.addEventListener('click', function() {
                    sidebar.classList.add('-translate-x-full');
                    overlay.classList.add('hidden');
                });
            }

            // Modern dropdown implementation
            const userDropdown = document.getElementById('userDropdown');
            const userDropdownButton = document.getElementById('userDropdownButton');
            const userDropdownMenu = document.getElementById('userDropdownMenu');
            
            if (userDropdownButton && userDropdownMenu) {
                userDropdownButton.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const isOpen = userDropdownMenu.style.display !== 'none';
                    
                    if (isOpen) {
                        // Close dropdown
                        userDropdownMenu.style.display = 'none';
                        userDropdownMenu.classList.remove('scale-100', 'opacity-100');
                        userDropdownMenu.classList.add('scale-95', 'opacity-0', 'pointer-events-none');
                    } else {
                        // Open dropdown
                        userDropdownMenu.style.display = 'block';
                        
                        requestAnimationFrame(() => {
                            userDropdownMenu.classList.remove('scale-95', 'opacity-0', 'pointer-events-none');
                            userDropdownMenu.classList.add('scale-100', 'opacity-100');
                        });
                    }
                });

                // Close dropdown when clicking outside
                document.addEventListener('click', function(e) {
                    if (!userDropdown.contains(e.target)) {
                        userDropdownMenu.style.display = 'none';
                        userDropdownMenu.classList.remove('scale-100', 'opacity-100');
                        userDropdownMenu.classList.add('scale-95', 'opacity-0', 'pointer-events-none');
                    }
                });
            }
        });
        
        // Desktop Search Functions - COMPLETELY REWRITTEN
        function toggleDesktopSearch() {
            console.log('Toggle desktop search called');
            const modal = document.getElementById('desktop-search-modal');
            const input = document.getElementById('desktop-search-input');
            
            if (!modal) {
                console.error('Desktop search modal not found');
                return;
            }
            
            // Use both style and class for visibility control
            modal.style.display = 'flex';
            modal.classList.remove('hidden');
            
            // Focus input after modal is visible
            setTimeout(() => {
                if (input) {
                    input.focus();
                    console.log('Input focused');
                } else {
                    console.error('Desktop search input not found');
                }
            }, 150);
        }
        
        function closeDesktopSearch() {
            console.log('Close desktop search called');
            const modal = document.getElementById('desktop-search-modal');
            const results = document.getElementById('desktop-search-results');
            const input = document.getElementById('desktop-search-input');
            
            if (!modal) {
                console.error('Desktop search modal not found for closing');
                return;
            }
            
            // Use both style and class for visibility control
            modal.style.display = 'none';
            modal.classList.add('hidden');
            
            if (results) {
                results.classList.add('hidden');
                console.log('Results hidden');
            }
            
            if (input) {
                input.value = '';
                console.log('Input cleared');
            }
            
            console.log('Desktop search modal closed successfully');
        }
        
        // Make functions globally accessible
        window.toggleDesktopSearch = toggleDesktopSearch;
        window.closeDesktopSearch = closeDesktopSearch;
        
        // COMPREHENSIVE EVENT INITIALIZATION
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded, initializing search events');
            
            const modal = document.getElementById('desktop-search-modal');
            const closeBtn = document.getElementById('desktop-search-close-btn');
            const backdrop = document.querySelector('.desktop-search-backdrop');
            const content = document.querySelector('.desktop-search-content');
            
            console.log('Elements found:', {
                modal: !!modal,
                closeBtn: !!closeBtn,
                backdrop: !!backdrop,
                content: !!content
            });
            
            // Close button event
            if (closeBtn) {
                closeBtn.addEventListener('click', function(e) {
                    console.log('Close button clicked');
                    e.preventDefault();
                    e.stopPropagation();
                    closeDesktopSearch();
                });
                console.log('Close button event listener added');
            } else {
                console.error('Close button not found');
            }
            
            // Backdrop click event
            if (backdrop) {
                backdrop.addEventListener('click', function(e) {
                    console.log('Backdrop clicked', e.target);
                    if (e.target === backdrop) {
                        closeDesktopSearch();
                    }
                });
                console.log('Backdrop event listener added');
            } else {
                console.error('Backdrop not found');
            }
            
            // Prevent modal content clicks from closing
            if (content) {
                content.addEventListener('click', function(e) {
                    console.log('Content clicked, preventing close');
                    e.stopPropagation();
                });
            }
            
            // Modal click delegation
            if (modal) {
                modal.addEventListener('click', function(e) {
                    console.log('Modal clicked, target:', e.target.className);
                    if (e.target === modal || e.target.classList.contains('desktop-search-backdrop')) {
                        closeDesktopSearch();
                    }
                });
                console.log('Modal event listener added');
            }
            
            // TESTING FUNCTION - Available in browser console
            window.testDesktopSearch = function() {
                console.log('=== DESKTOP SEARCH TEST ===');
                
                const modal = document.getElementById('desktop-search-modal');
                const closeBtn = document.getElementById('desktop-search-close-btn');
                const backdrop = document.querySelector('.desktop-search-backdrop');
                const content = document.querySelector('.desktop-search-content');
                const input = document.getElementById('desktop-search-input');
                
                console.log('Element check:', {
                    modal: !!modal,
                    closeBtn: !!closeBtn,
                    backdrop: !!backdrop,
                    content: !!content,
                    input: !!input
                });
                
                if (modal) {
                    console.log('Modal classes:', modal.className);
                    console.log('Modal style display:', modal.style.display);
                    console.log('Modal computed display:', window.getComputedStyle(modal).display);
                }
                
                console.log('Functions available:', {
                    toggleDesktopSearch: typeof window.toggleDesktopSearch,
                    closeDesktopSearch: typeof window.closeDesktopSearch
                });
                
                return {
                    modal, closeBtn, backdrop, content, input,
                    toggleFunction: window.toggleDesktopSearch,
                    closeFunction: window.closeDesktopSearch
                };
            };
            
            // Run initial test
            setTimeout(() => {
                console.log('Running initial desktop search test...');
                window.testDesktopSearch();
            }, 1000);
        });
        
        let desktopSearchTimeout;
        function performDesktopSearch() {
            clearTimeout(desktopSearchTimeout);
            const query = document.getElementById('desktop-search-input').value.trim();
            const resultsContainer = document.getElementById('desktop-search-results');
            
            if (query.length < 2) {
                resultsContainer.classList.add('hidden');
                return;
            }
            
            desktopSearchTimeout = setTimeout(() => {
                // Mock search results untuk demo - expanded untuk desktop
                const mockResults = [
                    { type: 'page', title: 'Dashboard', url: '/dashboard', description: 'Main dashboard with overview and statistics', icon: 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6' },
                    { type: 'page', title: 'Manajemen User', url: '/users', description: 'User management and administration', icon: 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z' },
                    { type: 'feature', title: 'Projects', url: '#', description: 'Coming soon - Project management features', icon: 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z' },
                    { type: 'feature', title: 'Finance', url: '#', description: 'Coming soon - Financial management tools', icon: 'M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z' }
                ];
                
                const filteredResults = mockResults.filter(item => 
                    item.title.toLowerCase().includes(query.toLowerCase()) ||
                    item.description.toLowerCase().includes(query.toLowerCase())
                );
                
                if (filteredResults.length > 0) {
                    resultsContainer.innerHTML = filteredResults.map(item => `
                        <a href="${item.url}" class="flex items-start p-4 hover:bg-gray-50 rounded-xl transition-colors duration-200 group" onclick="closeDesktopSearch()">
                            <div class="flex items-center justify-center w-12 h-12 mr-4 rounded-xl bg-brand-100 text-brand-600 group-hover:bg-brand-200 transition-colors duration-200">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${item.icon}" />
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="font-semibold text-gray-900 group-hover:text-brand-700 transition-colors duration-200">${item.title}</h3>
                                <p class="text-sm text-gray-500 mt-1 line-clamp-2">${item.description}</p>
                                <span class="inline-block mt-2 text-xs px-2 py-1 bg-gray-100 text-gray-600 rounded-full capitalize">${item.type}</span>
                            </div>
                            <div class="ml-4 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </div>
                        </a>
                    `).join('');
                } else {
                    resultsContainer.innerHTML = `
                        <div class="text-center py-12">
                            <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <h3 class="mt-4 text-lg font-medium text-gray-900">No results found</h3>
                            <p class="mt-2 text-sm text-gray-500">We couldn't find anything matching your search.<br>Try different keywords or browse our navigation.</p>
                        </div>
                    `;
                }
                
                resultsContainer.classList.remove('hidden');
            }, 300);
        }
        
        // ENHANCED KEYBOARD SHORTCUTS WITH DEBUGGING
        document.addEventListener('keydown', function(e) {
            console.log('Key pressed:', e.key, 'Ctrl:', e.ctrlKey, 'Meta:', e.metaKey);
            
            // Ctrl+K atau Cmd+K untuk open search
            if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                console.log('Ctrl+K detected, opening search');
                e.preventDefault();
                if (window.innerWidth >= 1024) {
                    toggleDesktopSearch();
                } else {
                    toggleMobileSearch();
                }
                return;
            }
            
            // ESC untuk close search modals
            if (e.key === 'Escape') {
                console.log('ESC key detected');
                const desktopModal = document.getElementById('desktop-search-modal');
                const mobileModal = document.getElementById('mobile-search-modal');
                
                console.log('Modal states:', {
                    desktop: desktopModal ? desktopModal.style.display : 'not found',
                    desktopHidden: desktopModal?.classList.contains('hidden'),
                    mobile: mobileModal ? mobileModal.style.display : 'not found',
                    mobileHidden: mobileModal?.classList.contains('hidden')
                });
                
                // Check desktop modal visibility using both style and class
                if (desktopModal && (desktopModal.style.display === 'flex' || !desktopModal.classList.contains('hidden'))) {
                    console.log('Closing desktop modal via ESC');
                    e.preventDefault();
                    closeDesktopSearch();
                    return;
                }
                
                // Check mobile modal visibility
                if (mobileModal && !mobileModal.classList.contains('hidden')) {
                    console.log('Closing mobile modal via ESC');
                    e.preventDefault();
                    closeMobileSearch();
                    return;
                }
                
                console.log('No modal to close');
            }
        });
        
        // Mobile Search Functions
        function toggleMobileSearch() {
            const modal = document.getElementById('mobile-search-modal');
            const input = document.getElementById('mobile-search-input');
            
            modal.classList.remove('hidden');
            setTimeout(() => {
                input.focus();
            }, 100);
        }
        
        function closeMobileSearch() {
            const modal = document.getElementById('mobile-search-modal');
            const results = document.getElementById('mobile-search-results');
            const input = document.getElementById('mobile-search-input');
            
            modal.classList.add('hidden');
            results.classList.add('hidden');
            input.value = '';
        }
        
        let mobileSearchTimeout;
        function performMobileSearch() {
            clearTimeout(mobileSearchTimeout);
            const query = document.getElementById('mobile-search-input').value.trim();
            const resultsContainer = document.getElementById('mobile-search-results');
            
            if (query.length < 2) {
                resultsContainer.classList.add('hidden');
                return;
            }
            
            mobileSearchTimeout = setTimeout(() => {
                // Mock search results untuk demo
                const mockResults = [
                    { type: 'page', title: 'Dashboard', url: '/dashboard', icon: 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6' },
                    { type: 'page', title: 'Manajemen User', url: '/users', icon: 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z' }
                ];
                
                const filteredResults = mockResults.filter(item => 
                    item.title.toLowerCase().includes(query.toLowerCase())
                );
                
                if (filteredResults.length > 0) {
                    resultsContainer.innerHTML = filteredResults.map(item => `
                        <a href="${item.url}" class="flex items-center p-3 hover:bg-gray-50 rounded-lg transition-colors duration-200" onclick="closeMobileSearch()">
                            <div class="flex items-center justify-center w-8 h-8 mr-3 rounded-lg bg-brand-100 text-brand-600">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${item.icon}" />
                                </svg>
                            </div>
                            <span class="font-medium text-gray-900">${item.title}</span>
                            <span class="ml-auto text-xs text-gray-500 capitalize">${item.type}</span>
                        </a>
                    `).join('');
                } else {
                    resultsContainer.innerHTML = `
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No results found</h3>
                            <p class="mt-1 text-sm text-gray-500">Try adjusting your search terms.</p>
                        </div>
                    `;
                }
                
                resultsContainer.classList.remove('hidden');
            }, 300);
        }
    </script>

    <!-- Toast Notifications -->
    @include('components.toast')

    <!-- Confirmation Modal -->
    @include('components.confirmation-modal')

    <!-- Page Scripts -->
    @stack('scripts')
</body>
</html>
