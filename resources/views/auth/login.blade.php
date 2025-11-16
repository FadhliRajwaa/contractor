<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Contractor Management</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-20px);
            }
        }
        
        @keyframes gradient {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }
        
        .animate-fadeInUp {
            animation: fadeInUp 0.6s ease-out;
        }
        
        .animate-float {
            animation: float 3s ease-in-out infinite;
        }
        
        .bg-animated {
            background: linear-gradient(-45deg, #FFE6D4, #FFC69D, #E06B80, #CD2C58);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
        }
    </style>
</head>
<body class="h-full bg-animated">
    <!-- Decorative Elements -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-0 left-0 w-64 h-64 bg-white opacity-10 rounded-full blur-3xl animate-float"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-white opacity-10 rounded-full blur-3xl animate-float" style="animation-delay: 1s;"></div>
    </div>

    <div class="min-h-full flex items-center justify-center px-4 sm:px-6 lg:px-8 py-12 relative z-10">
        <div class="max-w-md w-full space-y-8">
            <!-- Logo -->
            <div class="text-center animate-fadeInUp">
                <div class="inline-block bg-white/90 backdrop-blur-sm text-brand-500 px-8 py-4 rounded-2xl shadow-2xl transform hover:scale-110 transition-all duration-500 hover:rotate-3">
                    <h1 class="text-4xl font-bold bg-gradient-to-r from-brand-500 to-brand-700 bg-clip-text text-transparent">ContractorApp</h1>
                </div>
                <h2 class="mt-8 text-3xl font-bold text-white drop-shadow-lg">
                    Selamat Datang
                </h2>
                <p class="mt-3 text-base text-white/90 drop-shadow">
                    Silakan login untuk melanjutkan
                </p>
            </div>

            <!-- Session Messages -->
            @if(session('error'))
                <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg shadow-lg animate-fadeInUp" style="animation-delay: 0.1s;">
                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-red-500 mr-3 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div class="flex-1">
                            <p class="text-sm font-semibold text-red-800">{{ session('error') }}</p>
                            @if(session('info'))
                                <p class="text-xs text-red-600 mt-1">{{ session('info') }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-lg shadow-lg animate-fadeInUp" style="animation-delay: 0.1s;">
                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="text-sm font-semibold text-green-800">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if(session('info')  && !session('error'))
                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-lg shadow-lg animate-fadeInUp" style="animation-delay: 0.1s;">
                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-blue-500 mr-3 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="text-sm font-semibold text-blue-800">{{ session('info') }}</p>
                    </div>
                </div>
            @endif

            <!-- Login Card -->
            <div class="bg-white/95 backdrop-blur-md rounded-3xl shadow-2xl p-8 transform hover:shadow-3xl transition-all duration-500 animate-fadeInUp border border-white/20" style="animation-delay: 0.2s;">
                <form method="POST" action="{{ route('login.post') }}" class="space-y-6">
                    @csrf

                    <!-- Email -->
                    <div class="group">
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2 transition-colors duration-300 group-focus-within:text-brand-500">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                Email
                            </span>
                        </label>
                        <input 
                            id="email" 
                            name="email" 
                            type="email" 
                            autocomplete="email" 
                            required 
                            value="{{ old('email') }}"
                            class="input-field text-base py-3 @error('email') border-red-500 ring-red-500 @enderror transform transition-all duration-300 hover:shadow-md focus:shadow-lg focus:scale-[1.01]"
                            placeholder="Masukkan email Anda"
                            autofocus
                        >
                        @error('email')
                            <p class="mt-2 text-sm text-red-600 animate-fadeInUp flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="group">
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-2 transition-colors duration-300 group-focus-within:text-brand-500">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                                Password
                            </span>
                        </label>
                        <div class="relative">
                            <input 
                                id="password" 
                                name="password" 
                                type="password" 
                                autocomplete="current-password" 
                                required
                                class="input-field text-base py-3 pr-12 @error('password') border-red-500 ring-red-500 @enderror transform transition-all duration-300 hover:shadow-md focus:shadow-lg focus:scale-[1.01]"
                                placeholder="••••••••"
                            >
                            <button 
                                type="button" 
                                class="absolute inset-y-0 right-0 flex items-center pr-3 z-10"
                                onclick="togglePassword('password')"
                                tabindex="-1"
                            >
                                <svg id="password-eye-open" class="w-5 h-5 text-gray-400 hover:text-gray-600 transition-colors duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg id="password-eye-closed" class="w-5 h-5 text-gray-400 hover:text-gray-600 transition-colors duration-200 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21" />
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-2 text-sm text-red-600 animate-fadeInUp flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center group">
                        <input 
                            id="remember" 
                            name="remember" 
                            type="checkbox"
                            class="h-4 w-4 text-brand-500 focus:ring-brand-500 border-gray-300 rounded transition-all duration-300 cursor-pointer hover:scale-110"
                        >
                        <label for="remember" class="ml-3 block text-sm text-gray-700 cursor-pointer transition-colors duration-300 group-hover:text-brand-600">
                            Ingat saya
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button 
                        type="submit"
                        class="w-full btn-primary py-4 text-base font-bold shadow-xl hover:shadow-2xl transform hover:scale-[1.02] active:scale-[0.98] transition-all duration-300 relative overflow-hidden group"
                    >
                        <span class="relative z-10 flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2 transition-transform duration-300 group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                            </svg>
                            Masuk
                        </span>
                        <div class="absolute inset-0 bg-gradient-to-r from-brand-600 to-brand-700 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300 origin-left"></div>
                    </button>
                </form>

                <!-- Help Text -->
                <div class="mt-8 text-center animate-fadeInUp" style="animation-delay: 0.4s;">
                    <div class="inline-flex items-center px-4 py-2 bg-brand-50/50 backdrop-blur-sm rounded-full border border-brand-200/30">
                        <svg class="w-4 h-4 mr-2 text-brand-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="text-xs text-gray-700">
                            Belum punya akses? Hubungi <span class="font-bold text-brand-600">Superadministrator</span> untuk pendaftaran.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="text-center text-sm text-white/80 animate-fadeInUp" style="animation-delay: 0.5s;">
                <p class="drop-shadow">&copy; {{ date('Y') }} ContractorApp. All rights reserved.</p>
            </div>
        </div>
    </div>

    <!-- Client-side validation, password toggle, and auto-refresh script -->
    <script>
        // Password toggle function
        function togglePassword(inputId) {
            const passwordInput = document.getElementById(inputId);
            const eyeOpen = document.getElementById(inputId + '-eye-open');
            const eyeClosed = document.getElementById(inputId + '-eye-closed');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeOpen.classList.add('hidden');
                eyeClosed.classList.remove('hidden');
            } else {
                passwordInput.type = 'password';
                eyeOpen.classList.remove('hidden');
                eyeClosed.classList.add('hidden');
            }
            
            // Maintain focus on input after toggle (important for mobile)
            passwordInput.focus();
        }

        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');

            // Prevent eye button from submitting form
            const eyeButton = document.querySelector('button[onclick*="togglePassword"]');
            if (eyeButton) {
                eyeButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                });
            }

            form.addEventListener('submit', function(e) {
                let isValid = true;

                // Email validation
                if (!emailInput.value.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/)) {
                    isValid = false;
                    emailInput.classList.add('border-red-500');
                } else {
                    emailInput.classList.remove('border-red-500');
                }

                // Password validation
                if (passwordInput.value.length < 6) {
                    isValid = false;
                    passwordInput.classList.add('border-red-500');
                } else {
                    passwordInput.classList.remove('border-red-500');
                }

                if (!isValid) {
                    e.preventDefault();
                }
            });

            // Auto-refresh page after 10 minutes to prevent CSRF token expiry
            // This ensures the login form always has a fresh token
            let refreshTimeout = setTimeout(function() {
                console.log('Auto-refreshing page to renew CSRF token...');
                window.location.reload();
            }, 10 * 60 * 1000); // 10 minutes

            // Clear timeout if user submits the form
            form.addEventListener('submit', function() {
                clearTimeout(refreshTimeout);
            });

            // Show a subtle warning before auto-refresh (1 minute before)
            setTimeout(function() {
                const warningDiv = document.createElement('div');
                warningDiv.className = 'fixed bottom-4 right-4 bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded-lg shadow-lg max-w-sm animate-fadeInUp z-50';
                warningDiv.innerHTML = `
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-yellow-500 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div>
                            <p class="text-sm font-semibold text-yellow-800">Halaman akan direfresh dalam 1 menit</p>
                            <p class="text-xs text-yellow-700 mt-1">Untuk menjaga keamanan sesi Anda</p>
                        </div>
                    </div>
                `;
                document.body.appendChild(warningDiv);

                // Auto-hide warning after 5 seconds
                setTimeout(function() {
                    warningDiv.style.opacity = '0';
                    warningDiv.style.transform = 'translateY(10px)';
                    setTimeout(function() {
                        warningDiv.remove();
                    }, 300);
                }, 5000);
            }, 9 * 60 * 1000); // Show warning at 9 minutes
        });
    </script>
</body>
</html>
