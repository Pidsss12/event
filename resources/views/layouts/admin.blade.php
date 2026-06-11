<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'EventHub - Manajemen Event & Tiket Digital')</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Vite CSS/JS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        .font-heading {
            font-family: 'Outfit', sans-serif;
        }

        /* Navbar styling */
        nav {
            background: linear-gradient(to right, #ffffff, #f0f9ff) !important;
            box-shadow: 0 4px 20px rgba(30, 58, 138, 0.1) !important;
            border-bottom: 2px solid rgba(59, 130, 246, 0.3) !important;
        }

        nav a {
            transition: all 0.3s ease;
        }

        .text-gradient {
            background: linear-gradient(135deg, #2563eb 0%, #3b82f6 50%, #1d4ed8 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .bg-gradient-premium {
            background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 50%, #3b82f6 100%);
        }

        .bg-gradient-royal {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        }
    </style>
    @yield('styles')
</head>

<body class="flex flex-col min-h-screen text-slate-800">

    <!-- Header / Navbar -->
    <nav class="sticky top-0 z-50 transition-all duration-300"
        style="background: linear-gradient(to right, #ffffff, #f0f9ff); box-shadow: 0 4px 20px rgba(30, 58, 138, 0.1); border-bottom: 2px solid rgba(59, 130, 246, 0.3);">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <div class="flex items-center">
                    <!-- Logo -->
                    <a href="{{ route('home') }}"
                        class="flex items-center group hover:opacity-90 transition-all duration-300 transform hover:scale-105">
                        <img src="{{ asset('IMG/EventHub.logo.png') }}" alt="EventHub Logo"
                            class="h-16 w-auto drop-shadow-md">
                    </a>
                </div>

                <!-- Navigation Links (Desktop) -->
                <div class="hidden md:flex items-center space-x-1">
                    <a href="{{ route('admin.dashboard') }}"
                        style="color: {{ Route::currentRouteName() == 'admin.dashboard' ? 'rgb(37, 99, 235)' : 'rgb(51, 65, 85)' }}; background: {{ Route::currentRouteName() == 'admin.dashboard' ? 'rgba(59, 130, 246, 0.1)' : 'transparent' }}"
                        class="px-4 py-2 text-sm font-semibold rounded-xl hover:text-blue-600 hover:bg-blue-50 transition-all duration-300 relative group">
                        Dashboard Admin
                        <span class="absolute bottom-0 left-4 right-4 h-0.5 bg-blue-500 rounded-full scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></span>
                    </a>
                    
                    <a href="{{ route('admin.events.index') }}"
                        style="color: {{ str_contains(Route::currentRouteName(), 'admin.events') ? 'rgb(37, 99, 235)' : 'rgb(51, 65, 85)' }}; background: {{ str_contains(Route::currentRouteName(), 'admin.events') ? 'rgba(59, 130, 246, 0.1)' : 'transparent' }}"
                        class="px-4 py-2 text-sm font-semibold rounded-xl hover:text-blue-600 hover:bg-blue-50 transition-all duration-300 relative group">
                        Kelola Event
                        <span class="absolute bottom-0 left-4 right-4 h-0.5 bg-blue-500 rounded-full scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></span>
                    </a>
                    
                    <a href="{{ route('admin.categories.index') }}"
                        style="color: {{ str_contains(Route::currentRouteName(), 'admin.categories') ? 'rgb(37, 99, 235)' : 'rgb(51, 65, 85)' }}; background: {{ str_contains(Route::currentRouteName(), 'admin.categories') ? 'rgba(59, 130, 246, 0.1)' : 'transparent' }}"
                        class="px-4 py-2 text-sm font-semibold rounded-xl hover:text-blue-600 hover:bg-blue-50 transition-all duration-300 relative group">
                        Kategori Event
                        <span class="absolute bottom-0 left-4 right-4 h-0.5 bg-blue-500 rounded-full scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></span>
                    </a>
                    <a href="{{ route('home') }}" style="color: rgb(51, 65, 85);"
                        class="px-4 py-2 text-sm font-semibold rounded-xl hover:text-blue-600 hover:bg-blue-50 transition-all duration-300 relative group">
                        <i data-lucide="external-link" class="w-4 h-4 inline-block mr-1"></i> Ke Website
                        <span class="absolute bottom-0 left-4 right-4 h-0.5 bg-blue-500 rounded-full scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></span>
                    </a>
                </div>

                <!-- Right Action Side -->
                <div class="hidden md:flex items-center space-x-4">
                    @auth
                        <!-- User Balance Indicator (Only for regular users) -->
                        @if(!Auth::user()->isAdmin())
                            <div class="flex items-center gap-2 px-4 py-2 rounded-xl transition-all duration-300"
                                style="background: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.3); color: rgb(5, 150, 105);">
                                <i data-lucide="wallet" class="w-4 h-4"></i>
                                <span class="text-xs font-bold uppercase tracking-wider">Saldo:</span>
                                <span class="text-sm font-bold">Rp{{ number_format(Auth::user()->balance, 0, ',', '.') }}</span>
                            </div>
                        @endif

                        <!-- Profile Dropdown & Logout -->
                        <div class="flex items-center gap-3">
                            <span class="text-sm font-semibold text-slate-700">{{ Auth::user()->name }}</span>
                            <form action="{{ route('logout') }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="p-2.5 rounded-xl transition-all duration-200 border"
                                    style="color: rgb(107, 114, 128); border-color: transparent; background: transparent;"
                                    onmouseover="this.style.color='rgb(220, 38, 38)'; this.style.backgroundColor='rgba(239, 68, 68, 0.1)'; this.style.borderColor='rgba(239, 68, 68, 0.3)';"
                                    onmouseout="this.style.color='rgb(107, 114, 128)'; this.style.backgroundColor='transparent'; this.style.borderColor='transparent';"
                                    title="Keluar">
                                    <i data-lucide="log-out" class="w-5 h-5"></i>
                                </button>
                            </form>
                        </div>
                    @else
                        <!-- Guest Auth buttons -->
                        <a href="{{ route('login') }}"
                            class="px-4 py-2 text-sm font-semibold rounded-xl transition-all duration-200 relative group"
                            style="color: rgb(51, 65, 85);">
                            Masuk
                            <span
                                class="absolute bottom-1 left-0 right-0 h-0.5 bg-blue-500 rounded-full scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></span>
                        </a>
                        <a href="{{ route('register') }}"
                            class="px-6 py-2.5 text-sm font-bold rounded-xl transition-all duration-300 inline-flex items-center gap-2"
                            style="background: linear-gradient(to right, rgb(37, 99, 235), rgb(59, 130, 246)); color: white; box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);"
                            onmouseover="this.style.boxShadow='0 8px 25px rgba(59, 130, 246, 0.6)'; this.style.transform='scale(1.05)';"
                            onmouseout="this.style.boxShadow='0 4px 15px rgba(59, 130, 246, 0.4)'; this.style.transform='scale(1)';">
                            <i data-lucide="user-plus" class="w-4 h-4"></i>
                            Daftar Sekarang
                        </a>
                    @endauth
                </div>

                <!-- Mobile Menu Button -->
                <div class="-mr-2 flex items-center md:hidden">
                    <button type="button" id="mobile-menu-btn" class="p-2.5 rounded-xl transition-all duration-200"
                        style="color: rgb(51, 65, 85);"
                        onmouseover="this.style.color='rgb(37, 99, 235)'; this.style.backgroundColor='rgba(59, 130, 246, 0.1)';"
                        onmouseout="this.style.color='rgb(51, 65, 85)'; this.style.backgroundColor='transparent';">
                        <i data-lucide="menu" class="w-6 h-6" id="menu-icon"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div class="hidden md:hidden border-t transition-all duration-300" id="mobile-menu"
            style="border-color: rgba(59, 130, 246, 0.3); background: linear-gradient(to bottom, #f0f9ff, #ffffff);">
            <div class="px-4 pt-2 pb-4 space-y-2">
                <a href="{{ route('admin.dashboard') }}"
                    class="block px-4 py-3 rounded-xl text-base font-semibold transition-all duration-200"
                    style="color: rgb(51, 65, 85);"
                    onmouseover="this.style.color='rgb(37, 99, 235)'; this.style.backgroundColor='rgba(59, 130, 246, 0.1)';"
                    onmouseout="this.style.color='rgb(51, 65, 85)'; this.style.backgroundColor='transparent';">Dashboard Admin</a>

                <a href="{{ route('admin.events.index') }}"
                    class="block px-4 py-3 rounded-xl text-base font-semibold transition-all duration-200"
                    style="color: rgb(51, 65, 85);"
                    onmouseover="this.style.color='rgb(37, 99, 235)'; this.style.backgroundColor='rgba(59, 130, 246, 0.1)';"
                    onmouseout="this.style.color='rgb(51, 65, 85)'; this.style.backgroundColor='transparent';">Kelola Event</a>

                <a href="{{ route('admin.categories.index') }}"
                    class="block px-4 py-3 rounded-xl text-base font-semibold transition-all duration-200"
                    style="color: rgb(51, 65, 85);"
                    onmouseover="this.style.color='rgb(37, 99, 235)'; this.style.backgroundColor='rgba(59, 130, 246, 0.1)';"
                    onmouseout="this.style.color='rgb(51, 65, 85)'; this.style.backgroundColor='transparent';">Kategori Event</a>

                <a href="{{ route('home') }}"
                    class="block px-4 py-3 rounded-xl text-base font-semibold transition-all duration-200"
                    style="color: rgb(51, 65, 85);"
                    onmouseover="this.style.color='rgb(37, 99, 235)'; this.style.backgroundColor='rgba(59, 130, 246, 0.1)';"
                    onmouseout="this.style.color='rgb(51, 65, 85)'; this.style.backgroundColor='transparent';">Ke Website</a>
                @auth
                    <div class="border-t my-3 pt-3" style="border-color: rgba(59, 130, 246, 0.3);">
                        <span class="block px-4 py-2 text-xs font-bold uppercase tracking-wider"
                            style="color: rgb(37, 99, 235);">Akun: {{ Auth::user()->name }}</span>
                        <form action="{{ route('logout') }}" method="POST" class="w-full">
                            @csrf
                            <button type="submit"
                                class="w-full text-left px-4 py-3 rounded-xl text-base font-semibold flex items-center gap-2 transition-all duration-200"
                                style="color: rgb(220, 38, 38); border: 1px solid transparent;"
                                onmouseover="this.style.backgroundColor='rgba(239, 68, 68, 0.1)'; this.style.borderColor='rgba(239, 68, 68, 0.3)';"
                                onmouseout="this.style.backgroundColor='transparent'; this.style.borderColor='transparent';">
                                <i data-lucide="log-out" class="w-5 h-5"></i>
                                Keluar
                            </button>
                        </form>
                    </div>
                @else
                    <div class="border-t my-3 pt-3 flex flex-col gap-2" style="border-color: rgba(59, 130, 246, 0.3);">
                        <a href="{{ route('login') }}"
                            class="block text-center px-4 py-3 font-semibold rounded-xl transition-all duration-200"
                            style="border: 1px solid rgba(59, 130, 246, 0.4); color: rgb(37, 99, 235);"
                            onmouseover="this.style.backgroundColor='rgba(59, 130, 246, 0.1)';"
                            onmouseout="this.style.backgroundColor='transparent';">Masuk</a>
                        <a href="{{ route('register') }}"
                            class="block text-center px-4 py-3 font-bold rounded-xl flex items-center justify-center gap-2 transition-all duration-200"
                            style="background: linear-gradient(to right, rgb(37, 99, 235), rgb(59, 130, 246)); color: white; box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);">
                            <i data-lucide="user-plus" class="w-4 h-4"></i>
                            Daftar Sekarang
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main Content Area -->
    <main class="flex-grow">
        <!-- Toast / Alerts -->
        @if(session('success') || session('error') || $errors->any())
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
                @if(session('success'))
                    <div
                        class="flex items-center gap-3 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl shadow-sm">
                        <div class="p-1.5 bg-emerald-500 text-white rounded-lg">
                            <i data-lucide="check-circle" class="w-5 h-5"></i>
                        </div>
                        <p class="text-sm font-semibold">{{ session('success') }}</p>
                    </div>
                @endif

                @if(session('error'))
                    <div
                        class="flex items-center gap-3 p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-2xl shadow-sm">
                        <div class="p-1.5 bg-rose-500 text-white rounded-lg">
                            <i data-lucide="alert-circle" class="w-5 h-5"></i>
                        </div>
                        <p class="text-sm font-semibold">{{ session('error') }}</p>
                    </div>
                @endif

                @if($errors->any())
                    <div class="p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-2xl shadow-sm">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="p-1.5 bg-rose-500 text-white rounded-lg">
                                <i data-lucide="alert-circle" class="w-5 h-5"></i>
                            </div>
                            <p class="text-sm font-bold">Terjadi Kesalahan Input:</p>
                        </div>
                        <ul class="list-disc pl-10 text-xs font-semibold space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Admin Footer Minimal -->
    <footer class="bg-white border-t border-slate-200 py-6 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row justify-between items-center gap-4 text-xs text-slate-500">
            <p>&copy; {{ date('Y') }} EventHub Admin. All rights reserved.</p>
        </div>
    </footer>

    <!-- Lucide Initialization & Mobile Nav Toggle script -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Init Lucide Icons
            lucide.createIcons();

            // Mobile menu toggler
            const btn = document.getElementById("mobile-menu-btn");
            const menu = document.getElementById("mobile-menu");
            const icon = document.getElementById("menu-icon");

            if (btn && menu) {
                btn.addEventListener("click", () => {
                    const isHidden = menu.classList.contains("hidden");
                    if (isHidden) {
                        menu.classList.remove("hidden");
                        icon.setAttribute("data-lucide", "x");
                    } else {
                        menu.classList.add("hidden");
                        icon.setAttribute("data-lucide", "menu");
                    }
                    lucide.createIcons();
                });
            }
        });
    </script>
    @yield('scripts')
</body>

</html>