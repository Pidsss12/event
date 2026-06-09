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

    <!-- Lucide Icons & SweetAlert2 -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
                        class="flex items-center gap-3 group hover:opacity-90 transition-all duration-300 transform hover:scale-105">
                        <img src="{{ asset('IMG/EventHub.logo.png') }}" alt="EventHub Logo"
                            class="h-11 w-auto drop-shadow-md">
                        <span
                            class="hidden sm:block text-lg font-extrabold text-slate-800 group-hover:text-blue-600 transition-colors">EventHub</span>
                    </a>
                </div>

                <!-- Navigation Links (Desktop) -->
                <div class="hidden md:flex items-center space-x-1">
                    <a href="{{ route('home') }}"
                        style="color: {{ Route::currentRouteName() == 'home' ? 'rgb(37, 99, 235)' : 'rgb(51, 65, 85)' }}; background: {{ Route::currentRouteName() == 'home' ? 'rgba(59, 130, 246, 0.1)' : 'transparent' }}"
                        class="px-4 py-2 text-sm font-semibold rounded-xl hover:text-blue-600 hover:bg-blue-50 transition-all duration-300 relative group">
                        Home
                        <span
                            class="absolute bottom-0 left-4 right-4 h-0.5 bg-blue-500 rounded-full scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></span>
                    </a>

                    <a href="{{ route('home') }}#schedule-section" style="color: rgb(51, 65, 85);"
                        class="px-4 py-2 text-sm font-semibold rounded-xl hover:text-blue-600 hover:bg-blue-50 transition-all duration-300 relative group">
                        Jelajahi Event
                        <span
                            class="absolute bottom-0 left-4 right-4 h-0.5 bg-blue-500 rounded-full scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></span>
                    </a>

                    <a href="{{ route('home') }}#categories" style="color: rgb(51, 65, 85);"
                        class="px-4 py-2 text-sm font-semibold rounded-xl hover:text-blue-600 hover:bg-blue-50 transition-all duration-300 relative group">
                        Kategori
                        <span
                            class="absolute bottom-0 left-4 right-4 h-0.5 bg-blue-500 rounded-full scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></span>
                    </a>

                    @auth
                        @if(Auth::user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}"
                                style="color: {{ Route::currentRouteName() == 'admin.dashboard' ? 'rgb(37, 99, 235)' : 'rgb(51, 65, 85)' }}; background: {{ Route::currentRouteName() == 'admin.dashboard' ? 'rgba(59, 130, 246, 0.1)' : 'transparent' }}"
                                class="px-4 py-2 text-sm font-semibold rounded-xl hover:text-blue-600 hover:bg-blue-50 transition-all duration-300 relative group">
                                Admin
                                <span
                                    class="absolute bottom-0 left-4 right-4 h-0.5 bg-blue-500 rounded-full scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></span>
                            </a>
                            <a href="{{ route('admin.events.index') }}"
                                style="color: {{ str_contains(Route::currentRouteName(), 'admin.events') ? 'rgb(37, 99, 235)' : 'rgb(51, 65, 85)' }}; background: {{ str_contains(Route::currentRouteName(), 'admin.events') ? 'rgba(59, 130, 246, 0.1)' : 'transparent' }}"
                                class="px-4 py-2 text-sm font-semibold rounded-xl hover:text-blue-600 hover:bg-blue-50 transition-all duration-300 relative group">
                                Event
                                <span
                                    class="absolute bottom-0 left-4 right-4 h-0.5 bg-blue-500 rounded-full scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></span>
                            </a>
                        @else
                            <a href="{{ route('dashboard') }}"
                                style="color: {{ Route::currentRouteName() == 'dashboard' ? 'rgb(37, 99, 235)' : 'rgb(51, 65, 85)' }}; background: {{ Route::currentRouteName() == 'dashboard' ? 'rgba(59, 130, 246, 0.1)' : 'transparent' }}"
                                class="px-4 py-2 text-sm font-semibold rounded-xl hover:text-blue-600 hover:bg-blue-50 transition-all duration-300 relative group">
                                Dashboard
                                <span
                                    class="absolute bottom-0 left-4 right-4 h-0.5 bg-blue-500 rounded-full scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></span>
                            </a>
                        @endif
                    @endauth
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
                <a href="{{ route('home') }}"
                    class="block px-4 py-3 rounded-xl text-base font-semibold transition-all duration-200"
                    style="color: rgb(51, 65, 85);"
                    onmouseover="this.style.color='rgb(37, 99, 235)'; this.style.backgroundColor='rgba(59, 130, 246, 0.1)';"
                    onmouseout="this.style.color='rgb(51, 65, 85)'; this.style.backgroundColor='transparent';">Home</a>

                <a href="{{ route('home') }}#schedule-section"
                    class="block px-4 py-3 rounded-xl text-base font-semibold transition-all duration-200"
                    style="color: rgb(51, 65, 85);"
                    onmouseover="this.style.color='rgb(37, 99, 235)'; this.style.backgroundColor='rgba(59, 130, 246, 0.1)';"
                    onmouseout="this.style.color='rgb(51, 65, 85)'; this.style.backgroundColor='transparent';">Jelajahi
                    Event</a>

                <a href="{{ route('home') }}#categories"
                    class="block px-4 py-3 rounded-xl text-base font-semibold transition-all duration-200"
                    style="color: rgb(51, 65, 85);"
                    onmouseover="this.style.color='rgb(37, 99, 235)'; this.style.backgroundColor='rgba(59, 130, 246, 0.1)';"
                    onmouseout="this.style.color='rgb(51, 65, 85)'; this.style.backgroundColor='transparent';">Kategori</a>

                @auth
                    @if(Auth::user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}"
                            class="block px-4 py-3 rounded-xl text-base font-semibold transition-all duration-200"
                            style="color: rgb(51, 65, 85);"
                            onmouseover="this.style.color='rgb(37, 99, 235)'; this.style.backgroundColor='rgba(59, 130, 246, 0.1)';"
                            onmouseout="this.style.color='rgb(51, 65, 85)'; this.style.backgroundColor='transparent';">Admin
                            Dashboard</a>
                        <a href="{{ route('admin.events.index') }}"
                            class="block px-4 py-3 rounded-xl text-base font-semibold transition-all duration-200"
                            style="color: rgb(51, 65, 85);"
                            onmouseover="this.style.color='rgb(37, 99, 235)'; this.style.backgroundColor='rgba(59, 130, 246, 0.1)';"
                            onmouseout="this.style.color='rgb(51, 65, 85)'; this.style.backgroundColor='transparent';">Kelola
                            Event</a>
                        <a href="{{ route('admin.categories.index') }}"
                            class="block px-4 py-3 rounded-xl text-base font-semibold transition-all duration-200"
                            style="color: rgb(51, 65, 85);"
                            onmouseover="this.style.color='rgb(37, 99, 235)'; this.style.backgroundColor='rgba(59, 130, 246, 0.1)';"
                            onmouseout="this.style.color='rgb(51, 65, 85)'; this.style.backgroundColor='transparent';">Kategori</a>
                    @else
                        <a href="{{ route('dashboard') }}"
                            class="block px-4 py-3 rounded-xl text-base font-semibold transition-all duration-200"
                            style="color: rgb(51, 65, 85);"
                            onmouseover="this.style.color='rgb(37, 99, 235)'; this.style.backgroundColor='rgba(59, 130, 246, 0.1)';"
                            onmouseout="this.style.color='rgb(51, 65, 85)'; this.style.backgroundColor='transparent';">Dashboard
                            Saya</a>
                        <div class="px-4 py-3 rounded-xl text-sm font-bold flex items-center gap-2"
                            style="background: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.3); color: rgb(5, 150, 105);">
                            <i data-lucide="wallet" class="w-4 h-4"></i>
                            Saldo: Rp{{ number_format(Auth::user()->balance, 0, ',', '.') }}
                        </div>
                    @endif
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
        <!-- Toast / Alerts using SweetAlert2 -->
        @if(session('success') || session('error') || $errors->any())
            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 4000,
                        timerProgressBar: true,
                        background: '#ffffff',
                        iconColor: '#3b82f6',
                        customClass: {
                            title: 'text-sm font-semibold text-slate-800'
                        },
                        didOpen: (toast) => {
                            toast.onmouseenter = Swal.stopTimer;
                            toast.onmouseleave = Swal.resumeTimer;
                        }
                    });

                    @if(session('success'))
                        Toast.fire({
                            icon: 'success',
                            iconColor: '#10b981',
                            title: '{{ session("success") }}'
                        });
                    @endif

                    @if(session('error'))
                        Toast.fire({
                            icon: 'error',
                            iconColor: '#ef4444',
                            title: '{{ session("error") }}'
                        });
                    @endif

                    @if($errors->any())
                        let errorMsg = '<ul class="text-left text-sm text-slate-600 space-y-1">';
                        @foreach($errors->all() as $error)
                            errorMsg += '<li>- {{ $error }}</li>';
                        @endforeach
                        errorMsg += '</ul>';
                        
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan',
                            html: errorMsg,
                            confirmButtonColor: '#3b82f6',
                            customClass: {
                                popup: 'rounded-3xl',
                                confirmButton: 'px-6 py-2.5 rounded-xl font-bold'
                            }
                        });
                    @endif
                });
            </script>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gradient-royal text-slate-400 py-12 mt-20 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Branding Info -->
                <div class="md:col-span-2 space-y-4">
                    <a href="{{ route('home') }}" class="flex items-center gap-2">
                        <img src="{{ asset('IMG/EventHub.logo.png') }}" alt="EventHub Logo"
                            class="h-10 w-auto bg-white/10 p-1.5 rounded-xl">
                    </a>
                    <p class="text-sm max-w-sm text-slate-400 leading-relaxed">
                        Platform sistem informasi manajemen event terlengkap dan penjualan tiket digital secara aman,
                        cepat, dan handal. Temukan berbagai event terbaik di sekitar Anda.
                    </p>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="text-white font-bold text-base mb-4 uppercase tracking-wider">Tautan</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('home') }}" class="hover:text-blue-500 transition-colors">Semua Event</a>
                        </li>
                        @guest
                            <li><a href="{{ route('login') }}" class="hover:text-blue-500 transition-colors">Masuk</a></li>
                            <li><a href="{{ route('register') }}" class="hover:text-blue-500 transition-colors">Daftar
                                    Akun</a></li>
                        @else
                            <li><a href="{{ route('dashboard') }}" class="hover:text-blue-500 transition-colors">Dashboard
                                    Saya</a></li>
                        @endguest
                    </ul>
                </div>

                <!-- Contact & Social -->
                <div>
                    <h3 class="text-white font-bold text-base mb-4 uppercase tracking-wider">Kontak Kami</h3>
                    <ul class="space-y-3 text-sm">
                        <li class="flex items-center gap-2">
                            <i data-lucide="mail" class="w-4 h-4 text-blue-500"></i>
                            support@eventhub.com
                        </li>
                        <li class="flex items-center gap-2">
                            <i data-lucide="phone" class="w-4 h-4 text-blue-500"></i>
                            +62 812-3456-7890
                        </li>
                        <li class="flex items-center gap-2">
                            <i data-lucide="map-pin" class="w-4 h-4 text-blue-500"></i>
                            Gedung Tech Tower, Jakarta, Indonesia
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Footer copyright -->
            <div
                class="border-t border-slate-800 mt-12 pt-6 flex flex-col sm:flex-row justify-between items-center gap-4 text-xs">
                <p>&copy; {{ date('Y') }} EventHub. Hak Cipta Dilindungi.</p>
                <div class="flex gap-4">
                    <a href="#" class="hover:text-white transition-colors">Kebijakan Privasi</a>
                    <a href="#" class="hover:text-white transition-colors">Syarat & Ketentuan</a>
                </div>
            </div>
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