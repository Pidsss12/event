<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard - EventHub')</title>

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

        .bg-gradient-premium {
            background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 50%, #3b82f6 100%);
        }

        .sidebar-item {
            transition: all 0.3s ease;
        }
        
        .sidebar-item:hover, .sidebar-item.active {
            background: rgba(59, 130, 246, 0.1);
            color: rgb(37, 99, 235);
        }
        
        .sidebar-item.active {
            border-right: 4px solid rgb(37, 99, 235);
        }

        /* Hide scrollbar for sidebar */
        .sidebar-scroll::-webkit-scrollbar {
            width: 4px;
        }
        .sidebar-scroll::-webkit-scrollbar-track {
            background: transparent;
        }
        .sidebar-scroll::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }

        /* Admin Dark Sidebar Styles */
        .sidebar-admin {
            background: linear-gradient(180deg, #0f172a 0%, #1e293b 100%);
            border-right: none;
            color: #f8fafc;
        }
        
        .sidebar-admin .sidebar-item {
            color: #cbd5e1;
        }
        
        .sidebar-admin .sidebar-item:hover, .sidebar-admin .sidebar-item.active {
            background: rgba(59, 130, 246, 0.2);
            color: #ffffff;
        }
        
        .sidebar-admin .sidebar-item.active {
            border-right: 4px solid #3b82f6;
        }
        
        .sidebar-admin .sidebar-header, .sidebar-admin .sidebar-footer {
            border-color: rgba(255,255,255,0.1);
        }
        
        .sidebar-admin .sidebar-footer {
            background: rgba(0,0,0,0.2);
        }
    </style>
    @yield('styles')
</head>

<body class="text-slate-800 bg-slate-50 flex h-screen overflow-hidden">

    <!-- Mobile sidebar backdrop -->
    <div id="sidebar-backdrop" class="fixed inset-0 bg-slate-900/50 z-40 hidden md:hidden transition-opacity" aria-hidden="true"></div>

    <!-- Sidebar -->
    @php
        $isAdmin = Auth::check() && Auth::user()->isAdmin();
        $sidebarClass = $isAdmin ? 'sidebar-admin' : 'bg-white border-r border-slate-200';
    @endphp
    <aside id="sidebar" class="fixed md:static inset-y-0 left-0 z-50 w-72 {{ $sidebarClass }} transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out flex flex-col h-full shadow-2xl md:shadow-none">
        
        <!-- Sidebar Header (Logo) -->
        <div class="h-20 flex items-center px-6 border-b sidebar-header shrink-0 {{ $isAdmin ? '' : 'border-slate-100' }}">
            <a href="{{ route('home') }}" class="flex items-center gap-3 group hover:opacity-90 transition-all duration-300">
                <img src="{{ asset('IMG/EventHub.logo.png') }}" alt="EventHub Logo" class="h-10 w-auto {{ $isAdmin ? 'brightness-0 invert drop-shadow-[0_0_8px_rgba(255,255,255,0.8)]' : 'drop-shadow-sm' }}">
                <span class="text-xl font-extrabold group-hover:text-blue-500 transition-colors {{ $isAdmin ? 'text-white' : 'text-slate-800' }}">EventHub</span>
            </a>
            <!-- Mobile Close Button -->
            <button id="close-sidebar" class="ml-auto md:hidden {{ $isAdmin ? 'text-slate-400 hover:text-white' : 'text-slate-400 hover:text-slate-600' }}">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>
        </div>

        <!-- Sidebar Navigation -->
        <div class="flex-grow overflow-y-auto sidebar-scroll py-6 px-4 space-y-1">
            <div class="mb-4 px-2 text-xs font-bold uppercase tracking-wider {{ $isAdmin ? 'text-slate-500' : 'text-slate-400' }}">Menu Utama</div>

            @if($isAdmin)
                <!-- Admin Links -->
                <a href="{{ route('admin.dashboard') }}" class="sidebar-item flex items-center gap-3 px-4 py-3 rounded-xl font-semibold {{ Route::currentRouteName() == 'admin.dashboard' ? 'active' : '' }}">
                    <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                    Dashboard Admin
                </a>
                
                <div class="mt-6 mb-2 px-2 text-xs font-bold uppercase tracking-wider text-slate-500">Manajemen Event</div>
                <a href="{{ route('admin.events.index') }}" class="sidebar-item flex items-center gap-3 px-4 py-3 rounded-xl font-semibold {{ str_contains(Route::currentRouteName(), 'admin.events') ? 'active' : '' }}">
                    <i data-lucide="calendar" class="w-5 h-5"></i>
                    Kelola Event
                </a>
                <a href="{{ route('admin.categories.index') }}" class="sidebar-item flex items-center gap-3 px-4 py-3 rounded-xl font-semibold {{ str_contains(Route::currentRouteName(), 'admin.categories') ? 'active' : '' }}">
                    <i data-lucide="tags" class="w-5 h-5"></i>
                    Kategori Event
                </a>
                
                <div class="mt-6 mb-2 px-2 text-xs font-bold uppercase tracking-wider text-slate-500">Manajemen Sistem</div>
                <a href="{{ route('admin.transactions.index') }}" class="sidebar-item flex items-center gap-3 px-4 py-3 rounded-xl font-semibold {{ str_contains(Route::currentRouteName(), 'admin.transactions') ? 'active' : '' }}">
                    <i data-lucide="credit-card" class="w-5 h-5"></i>
                    Semua Transaksi
                </a>
                <a href="{{ route('admin.users.index') }}" class="sidebar-item flex items-center gap-3 px-4 py-3 rounded-xl font-semibold {{ str_contains(Route::currentRouteName(), 'admin.users') ? 'active' : '' }}">
                    <i data-lucide="users" class="w-5 h-5"></i>
                    Pengguna
                </a>
            @else
                <!-- User Links -->
                <a href="{{ route('dashboard') }}" class="sidebar-item flex items-center gap-3 px-4 py-3 rounded-xl font-semibold text-slate-600 {{ Route::currentRouteName() == 'dashboard' ? 'active' : '' }}">
                    <i data-lucide="wallet" class="w-5 h-5"></i>
                    Dompet & Tiket
                </a>
                <a href="{{ route('dashboard.events') }}" class="sidebar-item flex items-center gap-3 px-4 py-3 rounded-xl font-semibold text-slate-600 {{ Route::currentRouteName() == 'dashboard.events' ? 'active' : '' }}">
                    <i data-lucide="compass" class="w-5 h-5"></i>
                    Jelajahi Event
                </a>
            @endif

            <div class="mt-8 mb-4 px-2 text-xs font-bold uppercase tracking-wider {{ $isAdmin ? 'text-slate-500' : 'text-slate-400' }}">Lainnya</div>
            <a href="{{ route('home') }}" class="sidebar-item flex items-center gap-3 px-4 py-3 rounded-xl font-semibold {{ $isAdmin ? '' : 'text-slate-600' }}">
                <i data-lucide="external-link" class="w-5 h-5"></i>
                Ke Halaman Utama
            </a>
        </div>

        <!-- Sidebar Footer (User Info) -->
        <div class="p-4 border-t sidebar-footer shrink-0 {{ $isAdmin ? '' : 'border-slate-100 bg-slate-50' }}">
            <div class="flex items-center gap-3 mb-4 px-2">
                <div class="w-10 h-10 rounded-full bg-gradient-premium flex items-center justify-center text-white font-bold shadow-md shrink-0 border-2 {{ $isAdmin ? 'border-slate-700' : 'border-white' }}">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div class="overflow-hidden">
                    <p class="text-sm font-bold truncate {{ $isAdmin ? 'text-white' : 'text-slate-800' }}">{{ Auth::user()->name }}</p>
                    <p class="text-xs truncate {{ $isAdmin ? 'text-slate-400' : 'text-slate-500' }}">{{ Auth::user()->email }}</p>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl font-bold transition-colors {{ $isAdmin ? 'text-rose-400 bg-rose-500/10 hover:bg-rose-500/20' : 'text-rose-600 bg-rose-50 hover:bg-rose-100' }}">
                    <i data-lucide="log-out" class="w-4 h-4"></i>
                    Keluar
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Wrapper -->
    <div class="flex-grow flex flex-col h-full overflow-hidden bg-slate-50/50">
        
        <!-- Topbar for Mobile Menu & Notifications -->
        <header class="h-20 bg-white border-b border-slate-200 flex items-center justify-between px-4 sm:px-6 lg:px-8 shrink-0 relative z-30 shadow-sm">
            <div class="flex items-center">
                <button id="open-sidebar" class="md:hidden p-2 rounded-lg text-slate-500 hover:bg-slate-100 transition-colors mr-3">
                    <i data-lucide="menu" class="w-6 h-6"></i>
                </button>
                <h1 class="text-xl font-extrabold text-slate-800 hidden sm:block font-heading">
                    @yield('header_title', 'Dashboard')
                </h1>
            </div>

            <div class="flex items-center gap-4">
                @if(Auth::user() && !Auth::user()->isAdmin())
                    <!-- Quick Balance -->
                    <div class="hidden sm:flex items-center gap-2 px-4 py-2 rounded-xl bg-emerald-50 text-emerald-700 border border-emerald-100">
                        <i data-lucide="wallet" class="w-4 h-4"></i>
                        <span class="text-sm font-bold">Rp{{ number_format(Auth::user()->balance, 0, ',', '.') }}</span>
                    </div>
                @endif
            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-grow overflow-y-auto p-4 sm:p-6 lg:p-8">
            <!-- Toast / Alerts using SweetAlert2 -->
            @if(session('success'))
                <script>
                    document.addEventListener("DOMContentLoaded", function () {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: '{{ session("success") }}',
                            confirmButtonColor: '#3b82f6',
                        });
                    });
                </script>
            @endif

            @if(session('error'))
                <script>
                    document.addEventListener("DOMContentLoaded", function () {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: '{{ session("error") }}',
                            confirmButtonColor: '#3b82f6',
                        });
                    });
                </script>
            @endif

            @if($errors->any())
                <script>
                    document.addEventListener("DOMContentLoaded", function () {
                        let errorMsg = '<ul class="text-left text-sm">';
                        @foreach($errors->all() as $error)
                            errorMsg += '<li>- {{ $error }}</li>';
                        @endforeach
                        errorMsg += '</ul>';
                        
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan Input',
                            html: errorMsg,
                            confirmButtonColor: '#3b82f6',
                        });
                    });
                </script>
            @endif

            @yield('content')
        </main>
    </div>

    <!-- Scripts -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Init Lucide Icons
            lucide.createIcons();

            // Sidebar Toggle Logic
            const sidebar = document.getElementById('sidebar');
            const openBtn = document.getElementById('open-sidebar');
            const closeBtn = document.getElementById('close-sidebar');
            const backdrop = document.getElementById('sidebar-backdrop');

            function openSidebar() {
                sidebar.classList.remove('-translate-x-full');
                backdrop.classList.remove('hidden');
            }

            function closeSidebar() {
                sidebar.classList.add('-translate-x-full');
                backdrop.classList.add('hidden');
            }

            if (openBtn) openBtn.addEventListener('click', openSidebar);
            if (closeBtn) closeBtn.addEventListener('click', closeSidebar);
            if (backdrop) backdrop.addEventListener('click', closeSidebar);

            // SweetAlert Delete Confirmation
            document.querySelectorAll('form.delete-confirm').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Tindakan ini tidak dapat dibatalkan!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#ef4444',
                        cancelButtonColor: '#64748b',
                        confirmButtonText: 'Ya, Lanjutkan!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
    @yield('scripts')
</body>

</html>
