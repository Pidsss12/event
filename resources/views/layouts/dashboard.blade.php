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

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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

    <style>
        /* ===== ADMIN SIDEBAR ===== */
        .sidebar-admin {
            background: linear-gradient(180deg, #080f1f 0%, #0d1832 40%, #111827 100%);
            border-right: 1px solid rgba(255,255,255,0.06);
        }

        /* Section labels */
        .sb-section-label {
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            padding: 0 12px;
            margin: 24px 0 6px;
        }
        .sidebar-admin .sb-section-label { color: rgba(148,163,184,0.6); }
        .sidebar-user .sb-section-label  { color: #94a3b8; }

        /* Nav items */
        .sb-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 14px;
            border-radius: 14px;
            font-size: 13.5px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.22s ease;
            position: relative;
            margin-bottom: 2px;
        }

        /* ADMIN nav items */
        .sidebar-admin .sb-item {
            color: rgba(203,213,225,0.75);
        }
        .sidebar-admin .sb-item:hover {
            background: rgba(99,102,241,0.12);
            color: #e2e8f0;
        }
        .sidebar-admin .sb-item.active {
            background: linear-gradient(135deg, rgba(99,102,241,0.25), rgba(139,92,246,0.18));
            color: #ffffff;
            box-shadow: 0 0 20px rgba(99,102,241,0.2), inset 0 1px 0 rgba(255,255,255,0.08);
            border: 1px solid rgba(99,102,241,0.3);
        }
        .sidebar-admin .sb-item.active .sb-icon {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            box-shadow: 0 4px 12px rgba(99,102,241,0.5);
        }
        .sidebar-admin .sb-item .sb-icon {
            width: 34px; height: 34px;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            background: rgba(255,255,255,0.06);
            flex-shrink: 0;
            transition: all 0.22s;
        }
        .sidebar-admin .sb-item:hover .sb-icon {
            background: rgba(99,102,241,0.2);
        }

        /* USER nav items */
        .sidebar-user { background: white; border-right: 1px solid #f1f5f9; }
        .sidebar-user .sb-item {
            color: #64748b;
        }
        .sidebar-user .sb-item:hover {
            background: #f8fafc;
            color: #334155;
        }
        .sidebar-user .sb-item.active {
            background: linear-gradient(135deg, #eff6ff, #eef2ff);
            color: #2563eb;
            border: 1px solid #bfdbfe;
            box-shadow: 0 2px 8px rgba(37,99,235,0.08);
        }
        .sidebar-user .sb-item.active .sb-icon {
            background: linear-gradient(135deg, #3b82f6, #6366f1);
            box-shadow: 0 4px 10px rgba(59,130,246,0.3);
        }
        .sidebar-user .sb-item.active .sb-icon svg { color: white; }
        .sidebar-user .sb-item .sb-icon {
            width: 34px; height: 34px;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            background: #f1f5f9;
            flex-shrink: 0;
            transition: all 0.22s;
        }
        .sidebar-user .sb-item:hover .sb-icon {
            background: #e2e8f0;
        }

        /* Active dot indicator (admin) */
        .sidebar-admin .sb-item.active::after {
            content: '';
            position: absolute;
            right: 12px; top: 50%; transform: translateY(-50%);
            width: 6px; height: 6px;
            background: #818cf8;
            border-radius: 50%;
            box-shadow: 0 0 8px #818cf8;
        }

        /* Logo area */
        .sb-logo-admin {
            padding: 20px 20px 18px;
            border-bottom: 1px solid rgba(255,255,255,0.07);
            display: flex; align-items: center; justify-content: space-between;
        }
        .sb-logo-user {
            padding: 20px 20px 18px;
            border-bottom: 1px solid #f1f5f9;
            display: flex; align-items: center; justify-content: space-between;
        }
        .sb-logo-badge {
            display: flex; align-items: center; gap: 10px;
        }
        .sb-logo-img {
            width: 36px; height: 36px;
            border-radius: 10px;
            object-fit: contain;
        }
        .sb-logo-title {
            font-size: 17px;
            font-weight: 800;
            font-family: 'Outfit', sans-serif;
        }

        /* Footer */
        .sb-footer-admin {
            border-top: 1px solid rgba(255,255,255,0.07);
            background: rgba(0,0,0,0.2);
            padding: 14px 16px;
        }
        .sb-footer-user {
            border-top: 1px solid #f1f5f9;
            background: #f8fafc;
            padding: 14px 16px;
        }
        .sb-user-card {
            display: flex; align-items: center; gap: 10px;
            padding: 10px 12px;
            border-radius: 14px;
            margin-bottom: 8px;
        }
        .sidebar-admin .sb-user-card { background: rgba(255,255,255,0.05); }
        .sidebar-user .sb-user-card  { background: white; border: 1px solid #e2e8f0; }

        .sb-avatar {
            width: 38px; height: 38px;
            border-radius: 12px;
            background: linear-gradient(135deg, #6366f1, #3b82f6);
            display: flex; align-items: center; justify-content: center;
            color: white; font-weight: 800; font-size: 16px;
            flex-shrink: 0;
            box-shadow: 0 4px 10px rgba(99,102,241,0.3);
        }
        .sb-avatar-user {
            background: linear-gradient(135deg, #3b82f6, #06b6d4);
            box-shadow: 0 4px 10px rgba(59,130,246,0.3);
        }

        .sb-logout {
            width: 100%;
            display: flex; align-items: center; justify-content: center; gap: 8px;
            padding: 10px;
            border-radius: 12px;
            font-size: 13px; font-weight: 700;
            cursor: pointer;
            border: none;
            transition: all 0.2s;
        }
        .sidebar-admin .sb-logout {
            background: rgba(239,68,68,0.1);
            color: #f87171;
            border: 1px solid rgba(239,68,68,0.2);
        }
        .sidebar-admin .sb-logout:hover {
            background: rgba(239,68,68,0.2);
            color: #fca5a5;
        }
        .sidebar-user .sb-logout {
            background: #fef2f2;
            color: #ef4444;
            border: 1px solid #fecaca;
        }
        .sidebar-user .sb-logout:hover {
            background: #ef4444;
            color: white;
        }

        /* Scrollbar */
        .sb-scroll::-webkit-scrollbar { width: 3px; }
        .sb-scroll::-webkit-scrollbar-track { background: transparent; }
        .sb-scroll::-webkit-scrollbar-thumb { background: rgba(148,163,184,0.2); border-radius: 4px; }
    </style>

    <!-- Mobile backdrop -->
    <div id="sidebar-backdrop" class="fixed inset-0 bg-slate-900/50 z-40 hidden md:hidden" aria-hidden="true"></div>

    @php
        $isAdmin = Auth::check() && Auth::user()->isAdmin();
        $sidebarTypeClass = $isAdmin ? 'sidebar-admin' : 'sidebar-user';
    @endphp

    <aside id="sidebar" class="fixed md:static inset-y-0 left-0 z-50 w-72 {{ $sidebarTypeClass }} transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out flex flex-col h-full shadow-2xl md:shadow-none">

        {{-- Logo --}}
        <div class="{{ $isAdmin ? 'sb-logo-admin' : 'sb-logo-user' }}">
            <a href="{{ route('home') }}" class="sb-logo-badge" style="text-decoration:none;">
                <img src="{{ asset('IMG/EventHub.logo.png') }}" alt="Logo" class="sb-logo-img {{ $isAdmin ? 'brightness-0 invert' : '' }}">
                <span class="sb-logo-title" style="color: {{ $isAdmin ? '#fff' : '#0f172a' }}">EventHub</span>
            </a>
            <button id="close-sidebar" class="md:hidden" style="color: {{ $isAdmin ? 'rgba(203,213,225,0.6)' : '#94a3b8' }}; background:none; border:none; cursor:pointer;">
                <i data-lucide="x" style="width:20px;height:20px;"></i>
            </button>
        </div>

        {{-- Navigation --}}
        <div class="flex-grow overflow-y-auto sb-scroll" style="padding: 12px 12px;">

            @if($isAdmin)
                {{-- ADMIN NAVIGATION --}}
                <div class="sb-section-label">Menu Utama</div>
                <a href="{{ route('admin.dashboard') }}" class="sb-item {{ Route::currentRouteName() == 'admin.dashboard' ? 'active' : '' }}">
                    <div class="sb-icon"><i data-lucide="layout-dashboard" style="width:17px;height:17px;"></i></div>
                    Dashboard Admin
                </a>

                <div class="sb-section-label">Manajemen Event</div>
                <a href="{{ route('admin.events.index') }}" class="sb-item {{ str_contains(Route::currentRouteName(), 'admin.events') ? 'active' : '' }}">
                    <div class="sb-icon"><i data-lucide="calendar-days" style="width:17px;height:17px;"></i></div>
                    Kelola Event
                </a>
                <a href="{{ route('admin.categories.index') }}" class="sb-item {{ str_contains(Route::currentRouteName(), 'admin.categories') ? 'active' : '' }}">
                    <div class="sb-icon"><i data-lucide="folder-open" style="width:17px;height:17px;"></i></div>
                    Kategori Event
                </a>

                <div class="sb-section-label">Manajemen Sistem</div>
                <a href="{{ route('admin.transactions.index') }}" class="sb-item {{ str_contains(Route::currentRouteName(), 'admin.transactions') ? 'active' : '' }}">
                    <div class="sb-icon"><i data-lucide="receipt" style="width:17px;height:17px;"></i></div>
                    Semua Transaksi
                </a>
                <a href="{{ route('admin.topups') }}" class="sb-item {{ Route::currentRouteName() == 'admin.topups' ? 'active' : '' }}">
                    <div class="sb-icon"><i data-lucide="wallet" style="width:17px;height:17px;"></i></div>
                    Permintaan Top‑Up
                </a>
                <a href="{{ route('admin.users.index') }}" class="sb-item {{ str_contains(Route::currentRouteName(), 'admin.users') ? 'active' : '' }}">
                    <div class="sb-icon"><i data-lucide="users" style="width:17px;height:17px;"></i></div>
                    Pengguna
                </a>

                <div class="sb-section-label">Lainnya</div>
                <a href="{{ route('home') }}" class="sb-item">
                    <div class="sb-icon"><i data-lucide="globe" style="width:17px;height:17px;"></i></div>
                    Ke Halaman Utama
                </a>

            @else
                {{-- USER NAVIGATION --}}
                <div class="sb-section-label">Menu Saya</div>
                <a href="{{ route('dashboard') }}" class="sb-item {{ Route::currentRouteName() == 'dashboard' ? 'active' : '' }}">
                    <div class="sb-icon"><i data-lucide="wallet" style="width:17px;height:17px;"></i></div>
                    Dompet & Tiket
                </a>
                <a href="{{ route('dashboard.events') }}" class="sb-item {{ Route::currentRouteName() == 'dashboard.events' ? 'active' : '' }}">
                    <div class="sb-icon"><i data-lucide="compass" style="width:17px;height:17px;"></i></div>
                    Jelajahi Event
                </a>

                <div class="sb-section-label">Lainnya</div>
                <a href="{{ route('home') }}" class="sb-item">
                    <div class="sb-icon"><i data-lucide="globe" style="width:17px;height:17px;"></i></div>
                    Ke Halaman Utama
                </a>
            @endif
        </div>

        {{-- Footer --}}
        <div class="{{ $isAdmin ? 'sb-footer-admin' : 'sb-footer-user' }}">
            <div class="sb-user-card">
                <div class="sb-avatar {{ $isAdmin ? '' : 'sb-avatar-user' }}">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div style="overflow:hidden; flex:1;">
                    <p style="font-size:13px; font-weight:700; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; color: {{ $isAdmin ? '#e2e8f0' : '#0f172a' }}">{{ Auth::user()->name }}</p>
                    <p style="font-size:11px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; color: {{ $isAdmin ? 'rgba(148,163,184,0.7)' : '#64748b' }}">{{ Auth::user()->email }}</p>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="sb-logout">
                    <i data-lucide="log-out" style="width:15px;height:15px;"></i>
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
