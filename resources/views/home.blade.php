@extends('layouts.app')

@section('title', 'EventHub - Portal Event & Tiket Digital Terlengkap')

@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        /* ===== LANDING PAGE PREMIUM DESIGN SYSTEM ===== */

        /* Section Spacers */
        .section-premium-spacing {
            padding: 100px 0;
            position: relative;
        }

        .container-premium {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
        }

        /* Custom Grids */
        .grid-premium-3 {
            display: grid;
            grid-template-columns: 1fr;
            gap: 32px;
        }

        @media (min-width: 768px) {
            .grid-premium-3 {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        .grid-premium-4 {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 24px;
        }

        @media (min-width: 1024px) {
            .grid-premium-4 {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        .grid-gallery {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
        }

        @media (min-width: 768px) {
            .grid-gallery {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        /* Premium Hero Section */
        .hero-premium {
            position: relative;
            background: linear-gradient(135deg, #0b0f19 0%, #111827 50%, #0d1e3d 100%);
            overflow: hidden;
            padding: 110px 0 160px;
            color: white;
        }

        /* Floating glowing blobs */
        .hero-premium::before {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(37, 99, 235, 0.18) 0%, transparent 70%);
            top: -150px;
            right: -50px;
            z-index: 1;
            pointer-events: none;
        }

        .hero-premium::after {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(139, 92, 246, 0.14) 0%, transparent 70%);
            bottom: -80px;
            left: -100px;
            z-index: 1;
            pointer-events: none;
        }

        /* Float Animation */
        @keyframes float {

            0%,
            100% {
                transform: translateY(0) rotate(0deg);
            }

            50% {
                transform: translateY(-12px) rotate(1deg);
            }
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        /* Wave pattern decoration at the bottom of hero */
        .hero-wave-divider {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 90px;
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1440 320'%3E%3Cpath fill='%23f8fafc' fill-opacity='1' d='M0,224L60,213.3C120,203,240,181,360,176C480,171,600,181,720,192C840,203,960,213,1080,208C1200,203,1320,181,1380,170.7L1440,160L1440,320L1380,320C1320,320,1200,320,1080,320C960,320,840,320,720,320C600,320,480,320,360,320C240,320,120,320,60,320L0,320Z'%3E%3C/path%3E%3C/svg%3E") no-repeat;
            background-size: cover;
            z-index: 10;
        }

        /* Glass Cards & Glow effect */
        .glass-card {
            background: rgba(255, 255, 255, 0.04);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 28px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        }

        .premium-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 50px;
            font-size: 11px;
            font-weight: 800;
            color: #93c5fd;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            backdrop-filter: blur(8px);
        }

        /* Interactive Grid Cards */
        .feature-box {
            background: white;
            border-radius: 28px;
            border: 1px solid #f1f5f9;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.02);
            padding: 32px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-align: left;
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            gap: 16px;
            cursor: pointer;
        }

        .feature-box:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(37, 99, 235, 0.08);
            border-color: rgba(37, 99, 235, 0.2);
        }

        .feature-icon-wrapper {
            width: 54px;
            height: 54px;
            border-radius: 16px;
            background: #eff6ff;
            color: #2563eb;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }

        .feature-box:hover .feature-icon-wrapper {
            background: linear-gradient(135deg, #2563eb, #6366f1);
            color: white;
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.3);
        }

        /* Search Filter bar */
        .search-pill-wrapper {
            background: white;
            border-radius: 24px;
            padding: 8px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 10px 35px rgba(0, 0, 0, 0.03);
            display: flex;
            align-items: center;
            gap: 12px;
            width: 100%;
        }

        .filter-btn-pill {
            padding: 10px 22px;
            border-radius: 16px;
            font-size: 13.5px;
            font-weight: 700;
            white-space: nowrap;
            text-decoration: none;
            transition: all 0.2s;
            border: 1px solid transparent;
        }

        .filter-btn-pill.active {
            background: linear-gradient(135deg, #2563eb, #6366f1);
            color: white;
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.25);
        }

        .filter-btn-pill.inactive {
            background: #f8fafc;
            color: #64748b;
            border-color: #e2e8f0;
        }

        .filter-btn-pill.inactive:hover {
            background: #f1f5f9;
            color: #334155;
            border-color: #cbd5e1;
        }

        /* Event Cards */
        .event-card-premium {
            background: white;
            border-radius: 28px;
            border: 1px solid #f1f5f9;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.02);
            transition: all 0.3s;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .event-card-premium:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 45px rgba(0, 0, 0, 0.06);
            border-color: rgba(37, 99, 235, 0.15);
        }

        /* Pricing Passes styling */
        .pass-card {
            border-radius: 32px;
            padding: 36px;
            transition: all 0.3s;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            border: 2px solid;
            height: 100%;
        }

        .pass-card.silver {
            border-color: #e2e8f0;
            background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
        }

        .pass-card.gold {
            border-color: #fcd34d;
            background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 60%, #311068 100%);
            color: white;
        }

        .pass-card.platinum {
            border-color: #ddd6fe;
            background: linear-gradient(180deg, #ffffff 0%, #faf5ff 100%);
        }

        .pass-card:hover {
            transform: translateY(-8px);
        }

        .pass-card.silver:hover {
            border-color: #94a3b8;
            box-shadow: 0 12px 30px rgba(148, 163, 184, 0.15);
        }

        .pass-card.gold:hover {
            border-color: #fbbf24;
            box-shadow: 0 12px 35px rgba(245, 158, 11, 0.3);
        }

        .pass-card.platinum:hover {
            border-color: #8b5cf6;
            box-shadow: 0 12px 30px rgba(139, 92, 246, 0.15);
        }

        /* General styles */
        .btn-schedule {
            background: linear-gradient(135deg, #2563eb, #6366f1);
            color: white;
            box-shadow: 0 4px 14px rgba(37, 99, 235, 0.25);
        }

        .btn-schedule:hover {
            box-shadow: 0 6px 20px rgba(37, 99, 235, 0.35);
        }

        /* Speaker card */
        .speaker-card-premium {
            background: white;
            border-radius: 24px;
            border: 1px solid #f1f5f9;
            padding: 24px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.02);
            transition: all 0.3s;
            text-align: center;
        }

        .speaker-card-premium:hover {
            transform: translateY(-6px);
            box-shadow: 0 15px 35px rgba(37, 99, 235, 0.05);
            border-color: rgba(37, 99, 235, 0.12);
        }

        #modalImage[src*="data:image"] {
            opacity: 0;
        }
    </style>
@endsection

@section('content')

    <!-- Hero Section (Spectacular UI Overhaul) -->
    <section x-data="{ shown: false }" x-intersect.once="shown = true"
        :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'"
        class="hero-premium relative transition-all duration-1000 ease-out">
        <div class="absolute inset-0 opacity-10 mix-blend-overlay bg-cover bg-center"
            style="background-image: url('https://images.unsplash.com/photo-1511578314322-379afb476865?q=80&w=1200&auto=format&fit=crop');">
        </div>

        <div class="container-premium relative z-20">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                <!-- Hero Left -->
                <div class="lg:col-span-7 space-y-7">
                    <div class="premium-badge">
                        <i data-lucide="award" style="width:14px; height:14px;"></i> EventHub
                    </div>
                    <h1 class="text-4xl sm:text-6xl font-black tracking-tight leading-tight"
                        style="font-family: 'Outfit', sans-serif;">
                        Big Conference<br>
                        <span
                            style="background: linear-gradient(135deg, #60a5fa 0%, #a78bfa 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">&
                            Workshop</span>
                    </h1>
                    <p class="text-base sm:text-lg text-blue-100/80 max-w-xl leading-relaxed">
                        Manajemen Event & Tiket Digital Terlengkap. Temukan agenda terbaik, beli tiket langsung dengan saldo
                        e-wallet terintegrasi, dan hadiri sesi interaktif secara hybrid.
                    </p>
                    <div class="flex flex-wrap gap-4 pt-2">
                        @if($featuredEvent)
                            <a href="{{ route('events.show', $featuredEvent->slug) }}"
                                class="px-8 py-4 bg-white text-blue-700 hover:bg-blue-50 font-extrabold rounded-2xl shadow-xl transition-all duration-300 hover:-translate-y-0.5 inline-flex items-center gap-2">
                                <i data-lucide="ticket" class="w-5 h-5"></i>
                                Beli Tiket Sekarang
                            </a>
                        @endif
                        <a href="#schedule-section"
                            class="px-8 py-4 bg-white/5 border-2 border-white/20 hover:border-white text-white font-extrabold rounded-2xl transition-all duration-300 hover:bg-white/10 inline-flex items-center gap-2">
                            <i data-lucide="calendar" class="w-5 h-5"></i>
                            Lihat Jadwal
                        </a>
                    </div>
                </div>

                <!-- Hero Right (Visual Speaker Frame with Play Button Overlay) -->
                <div class="lg:col-span-5 relative flex justify-center">
                    <div class="relative w-full max-w-sm sm:max-w-md animate-float">
                        <!-- Main Round Banner -->
                        <div
                            class="aspect-square rounded-full border-[12px] border-white/5 overflow-hidden shadow-2xl relative">
                            <img src="https://images.unsplash.com/photo-1475721027785-f74eccf877e2?q=80&w=600&auto=format&fit=crop"
                                alt="Speaker" class="w-full h-full object-cover">
                            <!-- Play indicator overlay -->
                            <div class="absolute inset-0 bg-blue-950/40 flex items-center justify-center">
                                <button
                                    class="w-20 h-20 bg-white text-blue-600 rounded-full flex items-center justify-center shadow-2xl hover:scale-110 transition-transform duration-300">
                                    <i data-lucide="play" class="w-8 h-8 fill-current ml-1"></i>
                                </button>
                            </div>
                        </div>
                        <!-- Floating stats badge -->
                        <div
                            class="absolute -bottom-6 -left-6 bg-white text-slate-900 p-5 rounded-3xl shadow-xl border border-slate-100 flex items-center gap-4">
                            <div class="p-3 bg-blue-50 text-blue-600 rounded-2xl">
                                <i data-lucide="users" class="w-6 h-6"></i>
                            </div>
                            <div>
                                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Total Pendaftar</p>
                                <p class="text-base font-black text-slate-800">1.250+ Peserta</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="hero-wave-divider"></div>
    </section>

    <!-- Know More About Section -->
    <section x-data="{ shown: false }" x-intersect.once="shown = true"
        :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-12'"
        class="section-premium-spacing bg-slate-50 transition-all duration-1000 ease-out">
        <div class="container-premium">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                <!-- Left Side Mockup Grid -->
                <div class="lg:col-span-6 grid grid-cols-12 gap-4">
                    <div class="col-span-8 rounded-3xl overflow-hidden shadow-md h-80">
                        <img src="https://images.unsplash.com/photo-1540575467063-178a50c2df87?q=80&w=600&auto=format&fit=crop"
                            class="w-full h-full object-cover hover:scale-105 transition-transform duration-500"
                            alt="Workshop">
                    </div>
                    <div class="col-span-4 rounded-3xl overflow-hidden shadow-md h-80 pt-12">
                        <img src="https://images.unsplash.com/photo-1515187029135-18ee286d815b?q=80&w=400&auto=format&fit=crop"
                            class="w-full h-full object-cover hover:scale-105 transition-transform duration-500"
                            alt="Discussion">
                    </div>
                </div>

                <!-- Right Side Text -->
                <div class="lg:col-span-6 space-y-6">
                    <span class="text-xs font-extrabold text-blue-600 uppercase tracking-widest block">Mengenal
                        EventHub</span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 leading-tight"
                        style="font-family: 'Outfit', sans-serif;">
                        Menciptakan Pengalaman Event Digital yang Luar Biasa
                    </h2>
                    <p class="text-slate-500 leading-relaxed text-sm">
                        Kami hadir sebagai platform manajemen informasi event terlengkap. Anda dapat mencari agenda,
                        mendaftar sesi penting, mendapatkan tiket digital unik, hingga mengelola detail transaksi secara
                        transparan dan instan.
                    </p>

                    <div
                        class="p-5 bg-white border border-slate-100 rounded-3xl flex items-start gap-4 shadow-sm hover:shadow-md transition">
                        <div class="p-3 bg-blue-50 text-blue-600 rounded-2xl mt-1">
                            <i data-lucide="map-pin" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <h4 class="font-extrabold text-slate-800 text-sm">Lokasi Strategis & Peta Interaktif</h4>
                            <p class="text-xs text-slate-500 mt-1 leading-relaxed">Diselenggarakan di pusat konvensi modern
                                dengan navigasi koordinat peta OpenStreetMap interaktif secara hybrid.</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 pt-2">
                        <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=100&auto=format&fit=crop"
                            class="w-10 h-10 rounded-full object-cover border-2 border-white shadow-md">
                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?q=80&w=100&auto=format&fit=crop"
                            class="w-10 h-10 rounded-full object-cover border-2 border-white shadow-md -ml-4">
                        <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?q=80&w=100&auto=format&fit=crop"
                            class="w-10 h-10 rounded-full object-cover border-2 border-white shadow-md -ml-4">
                        <span class="text-xs font-bold text-slate-700 ml-2">15+ Pembicara Internasional Berpengalaman</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Countdown Section -->
    @if($featuredEvent)
        <section x-data="{ shown: false }" x-intersect.once="shown = true"
            :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-12'"
            class="bg-slate-900 relative overflow-hidden transition-all duration-1000 ease-out" style="padding: 48px 0;">
            <div class="absolute inset-0 bg-blue-950 opacity-90"></div>
            <div class="container-premium relative z-20">
                <div class="flex flex-col lg:flex-row items-center justify-between gap-8">
                    <div class="space-y-2 text-center lg:text-left">
                        <span class="text-blue-400 font-extrabold text-xs uppercase tracking-widest">Waktu Terbatas</span>
                        <h3 class="text-2xl sm:text-3xl font-extrabold text-white" style="font-family: 'Outfit', sans-serif;">
                            Hitung Mundur Acara Terdekat</h3>
                        <p class="text-sm text-slate-400 max-w-md">{{ $featuredEvent->title }}</p>
                    </div>

                    <!-- Countdown values -->
                    <div class="flex gap-4 sm:gap-6 justify-center" id="countdown-timer"
                        data-time="{{ $featuredEvent->date_time->toIso8601String() }}">
                        <div
                            class="flex flex-col items-center justify-center bg-white/5 border border-white/10 rounded-2xl w-20 h-24 sm:w-24 sm:h-28 shadow-xl backdrop-blur-md">
                            <span class="text-3xl sm:text-4xl font-black text-white" id="cd-days">00</span>
                            <span class="text-[10px] text-blue-200 font-bold uppercase tracking-wider mt-1">Hari</span>
                        </div>
                        <div
                            class="flex flex-col items-center justify-center bg-white/5 border border-white/10 rounded-2xl w-20 h-24 sm:w-24 sm:h-28 shadow-xl backdrop-blur-md">
                            <span class="text-3xl sm:text-4xl font-black text-white" id="cd-hours">00</span>
                            <span class="text-[10px] text-blue-200 font-bold uppercase tracking-wider mt-1">Jam</span>
                        </div>
                        <div
                            class="flex flex-col items-center justify-center bg-white/5 border border-white/10 rounded-2xl w-20 h-24 sm:w-24 sm:h-28 shadow-xl backdrop-blur-md">
                            <span class="text-3xl sm:text-4xl font-black text-white" id="cd-minutes">00</span>
                            <span class="text-[10px] text-blue-200 font-bold uppercase tracking-wider mt-1">Menit</span>
                        </div>
                        <div
                            class="flex flex-col items-center justify-center bg-white/5 border border-white/10 rounded-2xl w-20 h-24 sm:w-24 sm:h-28 shadow-xl backdrop-blur-md">
                            <span class="text-3xl sm:text-4xl font-black text-white animate-pulse" id="cd-seconds">00</span>
                            <span class="text-[10px] text-blue-200 font-bold uppercase tracking-wider mt-1">Detik</span>
                        </div>
                    </div>

                    <a href="{{ route('events.show', $featuredEvent->slug) }}"
                        class="px-8 py-4 bg-blue-600 hover:bg-blue-700 text-white font-extrabold rounded-2xl shadow-xl shadow-blue-500/20 transition-all duration-300">
                        Pesan Tiket
                    </a>
                </div>
            </div>
        </section>
    @endif

    <!-- Features Highlights (Unifying For A Better World) -->
    <section x-data="{ shown: false }" x-intersect.once="shown = true"
        :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-12'"
        class="section-premium-spacing bg-white transition-all duration-1000 ease-out">
        <div class="container-premium text-center space-y-4">
            <span class="text-xs font-extrabold text-blue-600 uppercase tracking-widest">Fitur Event</span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900" style="font-family: 'Outfit', sans-serif;">
                Unifying For A Better World</h2>

            <div class="grid-premium-4" style="margin-top: 48px;">
                <!-- Card 1 -->
                <button class="feature-box feature-modal-trigger" data-feature="speaker" data-title="Speaker Lineup"
                    data-description="Pembicara terkemuka dunia membagikan insight dan pengalaman industri terbaru langsung untuk Anda."
                    data-image="https://images.unsplash.com/photo-1510915361894-db8b60106cb1?q=80&w=800&auto=format&fit=crop">
                    <div class="feature-icon-wrapper">
                        <i data-lucide="mic" class="w-6 h-6"></i>
                    </div>
                    <h4 class="font-extrabold text-slate-900 text-lg">Speaker Lineup</h4>
                    <p class="text-slate-500 text-xs leading-relaxed">Pembicara terkemuka dunia membagikan insight terdalam
                        tentang industri.</p>
                </button>
                <!-- Card 2 -->
                <button class="feature-box feature-modal-trigger" data-feature="networking" data-title="Networking People"
                    data-description="Terhubung dengan ribuan praktisi dan founder berdedikasi tinggi untuk membangun relasi bisnis jangka panjang."
                    data-image="https://images.unsplash.com/photo-1552664730-d307ca884978?q=80&w=800&auto=format&fit=crop">
                    <div class="feature-icon-wrapper">
                        <i data-lucide="users-round" class="w-6 h-6"></i>
                    </div>
                    <h4 class="font-extrabold text-slate-900 text-lg">Networking People</h4>
                    <p class="text-slate-500 text-xs leading-relaxed">Hubungkan diri Anda dengan ribuan praktisi dan founder
                        berdedikasi tinggi.</p>
                </button>
                <!-- Card 3 -->
                <button class="feature-box feature-modal-trigger" data-feature="keynote" data-title="Engaging Keynote"
                    data-description="Materi berkualitas tinggi yang dapat langsung diimplementasikan dalam strategi bisnis Anda sehari-hari."
                    data-image="https://images.unsplash.com/photo-1505373877841-8d25f7d46678?q=80&w=800&auto=format&fit=crop">
                    <div class="feature-icon-wrapper">
                        <i data-lucide="key" class="w-6 h-6"></i>
                    </div>
                    <h4 class="font-extrabold text-slate-900 text-lg">Engaging Keynote</h4>
                    <p class="text-slate-500 text-xs leading-relaxed">Sesi materi berdurasi padat yang dirancang untuk
                        langsung bisa diimplementasikan.</p>
                </button>
                <!-- Card 4 -->
                <button class="feature-box feature-modal-trigger" data-feature="exhibition" data-title="Exhibition Space"
                    data-description="Showcase produk inovasi terbaru dari perusahaan global terkemuka yang siap mengembangkan bisnis Anda."
                    data-image="https://images.unsplash.com/photo-1540575467063-178a50c2df87?q=80&w=800&auto=format&fit=crop">
                    <div class="feature-icon-wrapper">
                        <i data-lucide="layout-grid" class="w-6 h-6"></i>
                    </div>
                    <h4 class="font-extrabold text-slate-900 text-lg">Exhibition Space</h4>
                    <p class="text-slate-500 text-xs leading-relaxed">Tempat showcase produk inovasi terbaru dari berbagai
                        perusahaan global.</p>
                </button>
            </div>
        </div>
    </section>

    <!-- Modal untuk Feature Details -->
    <div id="featureModal"
        class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden z-50 flex items-center justify-center p-4 overflow-y-auto">
        <div
            class="bg-white rounded-3xl max-w-xl w-full shadow-2xl my-8 animate-in fade-in zoom-in duration-300 relative border border-slate-100">
            <!-- Modal Image -->
            <div class="w-full h-72 rounded-t-3xl relative">
                <img id="modalImage" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7"
                    alt="" class="w-full h-full object-cover rounded-t-3xl">
            </div>
            <!-- Close button -->
            <button id="closeModalBtn"
                class="absolute top-5 right-5 w-9 h-9 bg-black/70 hover:bg-black rounded-full transition-all flex items-center justify-center"
                style="z-index: 50;">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            <!-- Modal Content -->
            <div class="p-8 space-y-6">
                <h3 id="modalTitle" class="text-2xl font-black text-slate-900" style="font-family: 'Outfit', sans-serif;">
                </h3>
                <p id="modalDescription" class="text-slate-500 leading-relaxed text-sm"></p>
                <button
                    onclick="document.getElementById('featureModal').classList.add('hidden'); document.body.style.overflow='auto';"
                    class="w-full px-6 py-3.5 bg-blue-600 hover:bg-blue-700 text-white font-extrabold rounded-xl transition-all shadow-lg shadow-blue-500/20">
                    Selesai & Tutup
                </button>
            </div>
        </div>
    </div>

    <!-- Events Map Section -->
    <section x-data="{ shown: false }" x-intersect.once="shown = true"
        :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-12'"
        class="section-premium-spacing bg-slate-50 transition-all duration-1000 ease-out border-t border-slate-100">
        <div class="container-premium text-center space-y-4">
            <span class="text-xs font-extrabold text-blue-600 uppercase tracking-widest">Peta Interaktif</span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900" style="font-family: 'Outfit', sans-serif;">Peta
                Persebaran Event</h2>
            <p class="text-slate-500 text-sm max-w-md mx-auto leading-relaxed">Lihat koordinat lokasi strategis event-event
                kami secara visual untuk memudahkan Anda menuju tempat acara.</p>
            <button id="openMapBtn"
                class="inline-flex items-center gap-2 px-8 py-4 bg-blue-600 hover:bg-blue-700 text-white font-extrabold rounded-2xl shadow-xl shadow-blue-500/20 transition-all transform hover:-translate-y-0.5 mt-6 border-none cursor-pointer">
                <i data-lucide="map-pin" class="w-5 h-5"></i>
                Buka Peta Interaktif
            </button>
        </div>
    </section>

    <!-- Map Modal -->
    <div id="mapModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm hidden z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-4xl w-full shadow-2xl relative border border-slate-100 overflow-hidden">
            <div
                style="display:flex; justify-content:space-between; align-items:center; padding:20px 24px; background:linear-gradient(135deg, #0f172a, #1e293b); color:white;">
                <h3 style="font-size:16px; font-weight:800; font-family:'Outfit',sans-serif; margin:0;">Persebaran Event
                    Interaktif</h3>
                <button id="closeMapBtn"
                    style="background:none; border:none; color:white; font-size:24px; cursor:pointer; opacity:0.8; transition:opacity 0.2s;">&times;</button>
            </div>
            <div class="p-6">
                <div id="eventMap" style="height: 440px; border-radius: 20px; overflow: hidden; border:1px solid #e2e8f0;">
                </div>
            </div>
        </div>
    </div>

    <!-- Search & Event Schedule Section -->
    <section id="schedule-section" x-data="{ shown: false }" x-intersect.once="shown = true"
        :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-12'"
        class="section-premium-spacing bg-white transition-all duration-1000 ease-out">
        <div class="container-premium">

            <!-- Header & Search Form -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6 mb-12">
                <div class="space-y-2">
                    <span class="text-xs font-extrabold text-blue-600 uppercase tracking-widest block">Agenda Acara</span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900"
                        style="font-family: 'Outfit', sans-serif;">Daftar Agenda & Event Mendatang</h2>
                </div>

                <!-- Search bar -->
                <form action="{{ route('home') }}" method="GET" class="w-full md:w-auto flex flex-col sm:flex-row gap-3">
                    @if(request('category'))
                        <input type="hidden" name="category" value="{{ request('category') }}">
                    @endif
                    <div class="relative w-full sm:w-72">
                        <i data-lucide="search" class="absolute left-4 top-3.5 w-5 h-5 text-slate-400"></i>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari event, judul, lokasi..."
                            class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition">
                    </div>
                    <button type="submit"
                        class="px-6 py-3 bg-blue-600 text-white rounded-xl text-sm font-extrabold hover:bg-blue-700 shadow-md shadow-blue-500/10 transition">
                        Cari
                    </button>
                    @if(request('search') || request('category'))
                        <a href="{{ route('home') }}"
                            class="px-5 py-3 bg-slate-100 text-slate-700 text-center rounded-xl text-sm font-extrabold hover:bg-slate-200 transition">
                            Reset
                        </a>
                    @endif
                </form>
            </div>

            <!-- Categories Navigation Tabs -->
            <div id="categories"
                class="flex overflow-x-auto pb-4 gap-3 mb-10 border-b border-slate-100 scroll-mt-24 scrollbar-thin">
                <a href="{{ route('home', ['search' => request('search')]) }}#categories"
                    class="filter-btn-pill {{ !request('category') ? 'active' : 'inactive' }}">Semua Kategori</a>
                @foreach($categories as $cat)
                    <a href="{{ route('home', ['category' => $cat->slug, 'search' => request('search')]) }}#categories"
                        class="filter-btn-pill {{ request('category') == $cat->slug ? 'active' : 'inactive' }}">{{ $cat->name }}
                        ({{ $cat->events_count }})</a>
                @endforeach
            </div>

            <!-- Event Cards List -->
            @if($events->count() > 0)
                <div class="grid-premium-3">
                    @foreach($events as $event)
                        <div class="event-card-premium group">
                            <!-- Banner image -->
                            <div class="relative aspect-[16/10] overflow-hidden">
                                <img src="{{ $event->banner_image }}" alt="{{ $event->title }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                <!-- Category Badge -->
                                <div
                                    class="absolute top-4 left-4 bg-white/90 backdrop-blur px-3 py-1.5 rounded-xl text-[10px] font-extrabold uppercase tracking-wider text-blue-600 shadow-sm">
                                    {{ $event->category->name }}
                                </div>
                            </div>

                            <!-- Card Content -->
                            <div class="p-6 flex-grow flex flex-col justify-between space-y-5">
                                <div class="space-y-3">
                                    <!-- Date & Time -->
                                    <div class="flex items-center gap-2 text-xs text-slate-400 font-bold">
                                        <i data-lucide="calendar" class="w-4 h-4 text-blue-500"></i>
                                        {{ $event->date_time->translatedFormat('d F Y | H:i') }} WIB
                                    </div>
                                    <h3 class="font-extrabold text-slate-900 text-lg leading-snug group-hover:text-blue-600 transition-colors"
                                        style="font-family: 'Outfit', sans-serif;">
                                        <a href="{{ route('events.show', $event->slug) }}"
                                            style="text-decoration:none; color:inherit;">{{ $event->title }}</a>
                                    </h3>
                                    <p class="text-slate-500 text-xs line-clamp-2 leading-relaxed">
                                        {{ $event->description }}
                                    </p>
                                </div>

                                <div class="border-t border-slate-100 pt-4 flex justify-between items-center">
                                    <div>
                                        <span class="text-[9px] text-slate-400 font-bold uppercase tracking-wider block">Harga
                                            Mulai</span>
                                        <span class="text-base font-black text-blue-600" style="font-family: 'Outfit', sans-serif;">
                                            Rp{{ number_format($event->ticketTypes->min('price'), 0, ',', '.') }}
                                        </span>
                                    </div>
                                    <a href="{{ route('events.show', $event->slug) }}"
                                        class="px-5 py-2.5 bg-blue-50 hover:bg-blue-600 text-blue-600 hover:text-white rounded-xl text-xs font-extrabold transition-all duration-300">
                                        Lihat Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-16 bg-white rounded-3xl border border-slate-100 shadow-sm space-y-4">
                    <div class="p-4 bg-blue-50 text-blue-600 rounded-full w-fit mx-auto">
                        <i data-lucide="calendar-x" class="w-10 h-10"></i>
                    </div>
                    <h3 class="font-extrabold text-slate-800 text-lg">Tidak Ada Event Ditemukan</h3>
                    <p class="text-slate-500 text-sm max-w-sm mx-auto leading-relaxed">Coba ubah filter pencarian Anda atau cari
                        kategori event lainnya.</p>
                </div>
            @endif
        </div>
    </section>

    <!-- Pricing Tickets Section -->
    <section x-data="{ shown: false }" x-intersect.once="shown = true"
        :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-12'"
        class="section-premium-spacing bg-slate-50 transition-all duration-1000 ease-out border-t border-slate-100"
        style="padding-bottom: 120px;">
        <div class="container-premium text-center space-y-4">
            <span class="text-xs font-extrabold text-blue-600 uppercase tracking-widest">Pilihan Tiket</span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900" style="font-family: 'Outfit', sans-serif;">Choose
                Your Tickets</h2>
            <p class="text-slate-500 text-sm max-w-md mx-auto leading-relaxed">Pilih kategori tiket terbaik untuk kenyamanan
                menghadiri event spektakuler ini.</p>

            <div class="grid-premium-3" style="margin-top: 72px; padding-top: 8px;">

                <!-- Silver Ticket -->
                <div class="pass-card silver">
                    <div class="space-y-6">
                        <div class="flex justify-between items-start">
                            <div>
                                <h4 class="font-extrabold text-slate-900 text-xl"
                                    style="font-family: 'Outfit', sans-serif;">Silver Ticket</h4>
                                <p class="text-xs text-slate-500 mt-1">Akses standar event</p>
                            </div>
                            <span
                                class="px-3 py-1 bg-slate-200 text-slate-700 text-[10px] font-bold rounded-lg uppercase tracking-wider">Standard</span>
                        </div>
                        <div class="border-t border-slate-200 pt-4">
                            <span class="text-3xl font-black text-slate-800"
                                style="font-family: 'Outfit', sans-serif;">Rp150.000</span>
                            <span class="text-xs text-slate-400">/orang</span>
                        </div>
                        <ul class="space-y-2.5 text-xs font-bold text-slate-600 pt-2">
                            <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-500"></i>
                                Akses Area Kursi Belakang</li>
                            <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-500"></i>
                                E-Ticket Resmi</li>
                            <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-500"></i>
                                Snack Ringan</li>
                            <li class="flex items-center gap-2 text-slate-300"><i data-lucide="x" class="w-4 h-4"></i> Sesi
                                Networking Privat</li>
                        </ul>
                    </div>
                    <a href="#schedule-section"
                        class="w-full text-center py-3.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-extrabold shadow-lg shadow-blue-500/10 block transition mt-8 text-decoration-none">
                        Pilih Event
                    </a>
                </div>

                <!-- Gold Ticket (Recommended) - wrapper div for badge so it's not clipped by card border-radius -->
                <div style="position: relative; padding-top: 20px;">
                    <!-- Badge OUTSIDE pass-card so border-radius won't clip it -->
                    <div
                        style="position: absolute; top: 2px; left: 50%; transform: translateX(-50%); z-index: 30; white-space: nowrap; background: #ffd21eff; color: #2c2724ff; padding: 6px 20px; border-radius: 999px; font-size: 10px; font-weight: 900; text-transform: uppercase; letter-spacing: 0.08em; box-shadow: 0 4px 12px rgba(250,204,21,0.4);">
                        Terpopuler
                    </div>
                    <div class="pass-card gold" style="transform: scale(1.03); z-index: 10;">
                        <div class="space-y-6">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h4 class="font-extrabold text-white text-xl"
                                        style="font-family: 'Outfit', sans-serif;">Gold Ticket</h4>
                                    <p class="text-xs text-blue-200 mt-1">Kenyamanan ekstra & eksklusif</p>
                                </div>
                                <span
                                    class="px-3 py-1 bg-yellow-400 text-slate-950 text-[10px] font-extrabold rounded-lg uppercase tracking-wider">VIP</span>
                            </div>
                            <div class="border-t border-blue-900 pt-4">
                                <span class="text-3xl font-black text-yellow-300"
                                    style="font-family: 'Outfit', sans-serif;">Rp350.000</span>
                                <span class="text-xs text-blue-300">/orang</span>
                            </div>
                            <ul class="space-y-2.5 text-xs font-bold text-blue-100 pt-2">
                                <li class="flex items-center gap-2"><i data-lucide="check"
                                        class="w-4 h-4 text-emerald-400"></i> Akses Kursi Depan/Tengah</li>
                                <li class="flex items-center gap-2"><i data-lucide="check"
                                        class="w-4 h-4 text-emerald-400"></i> E-Ticket Resmi + Barcode</li>
                                <li class="flex items-center gap-2"><i data-lucide="check"
                                        class="w-4 h-4 text-emerald-400"></i> Konsumsi Makan Siang</li>
                                <li class="flex items-center gap-2"><i data-lucide="check"
                                        class="w-4 h-4 text-emerald-400"></i> E-Certificate Peserta</li>
                            </ul>
                        </div>
                        <a href="#schedule-section"
                            class="w-full text-center py-3.5 bg-yellow-400 hover:bg-yellow-300 text-slate-950 rounded-xl text-sm font-extrabold shadow-xl block transition mt-8 text-decoration-none">
                            Pilih Event
                        </a>
                    </div>
                </div>

                <!-- Platinum VIP -->
                <div class="pass-card platinum">
                    <div class="space-y-6">
                        <div class="flex justify-between items-start">
                            <div>
                                <h4 class="font-extrabold text-slate-900 text-xl"
                                    style="font-family: 'Outfit', sans-serif;">Platinum VIP</h4>
                                <p class="text-xs text-slate-500 mt-1">Fasilitas terbaik tanpa batas</p>
                            </div>
                            <span
                                class="px-3 py-1 bg-slate-200 text-slate-700 text-[10px] font-bold rounded-lg uppercase tracking-wider">VVIP</span>
                        </div>
                        <div class="border-t border-slate-200 pt-4">
                            <span class="text-3xl font-black text-slate-800"
                                style="font-family: 'Outfit', sans-serif;">Rp750.000</span>
                            <span class="text-xs text-slate-400">/orang</span>
                        </div>
                        <ul class="space-y-2.5 text-xs font-bold text-slate-600 pt-2">
                            <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-500"></i>
                                Akses VIP Lounge & Baris Depan</li>
                            <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-500"></i>
                                E-Ticket + ID Card Fisik</li>
                            <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-500"></i>
                                Sesi Foto & Meet & Greet</li>
                            <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-500"></i>
                                Exclusive Merch Kit</li>
                        </ul>
                    </div>
                    <a href="#schedule-section"
                        class="w-full text-center py-3.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-extrabold shadow-lg shadow-blue-500/10 block transition mt-8 text-decoration-none">
                        Pilih Event
                    </a>
                </div>

            </div>
        </div>
    </section>

    <!-- Meet Our Speakers & Gallery -->
    <section x-data="{ shown: false }" x-intersect.once="shown = true"
        :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-12'"
        class="section-premium-spacing bg-white transition-all duration-1000 ease-out border-t border-slate-100"
        style="padding-top: 120px;">
        <div class="container-premium space-y-16">

            <!-- Speakers grid -->
            <div class="space-y-10" style="margin-bottom: 60px;">
                <div class="text-center space-y-2" style="margin-bottom: 40px;">
                    <span class="text-xs font-extrabold text-blue-600 uppercase tracking-widest block">Narasumber
                        Utama</span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900"
                        style="font-family: 'Outfit', sans-serif;">Meet Our Speakers</h2>
                </div>
                <div class="grid-premium-4">
                    <!-- Speaker 1 -->
                    <div class="speaker-card-premium">
                        <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=300&auto=format&fit=crop"
                            class="w-24 h-24 rounded-full object-cover mx-auto shadow-md mb-4" alt="Speaker">
                        <h4 class="font-extrabold text-slate-800 text-sm" style="font-family: 'Outfit', sans-serif;">Sarah
                            Jenkins</h4>
                        <p class="text-xs text-blue-600 font-bold mt-1">Chief Creative Director</p>
                    </div>
                    <!-- Speaker 2 -->
                    <div class="speaker-card-premium">
                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?q=80&w=300&auto=format&fit=crop"
                            class="w-24 h-24 rounded-full object-cover mx-auto shadow-md mb-4" alt="Speaker">
                        <h4 class="font-extrabold text-slate-800 text-sm" style="font-family: 'Outfit', sans-serif;">Marcus
                            Brody</h4>
                        <p class="text-xs text-blue-600 font-bold mt-1">VP Innovation Tech</p>
                    </div>
                    <!-- Speaker 3 -->
                    <div class="speaker-card-premium">
                        <img src="https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?q=80&w=300&auto=format&fit=crop"
                            class="w-24 h-24 rounded-full object-cover mx-auto shadow-md mb-4" alt="Speaker">
                        <h4 class="font-extrabold text-slate-800 text-sm" style="font-family: 'Outfit', sans-serif;">David
                            Lee</h4>
                        <p class="text-xs text-blue-600 font-bold mt-1">Founder & CEO Startup</p>
                    </div>
                    <!-- Speaker 4 -->
                    <div class="speaker-card-premium">
                        <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?q=80&w=300&auto=format&fit=crop"
                            class="w-24 h-24 rounded-full object-cover mx-auto shadow-md mb-4" alt="Speaker">
                        <h4 class="font-extrabold text-slate-800 text-sm" style="font-family: 'Outfit', sans-serif;">Jessica
                            Tan</h4>
                        <p class="text-xs text-blue-600 font-bold mt-1">AI Research Lead</p>
                    </div>
                </div>
            </div>

            <!-- Gallery grid -->
            <div class="space-y-10">
                <div class="text-center space-y-2" style="margin-bottom: 40px;">
                    <span class="text-xs font-extrabold text-blue-600 uppercase tracking-widest block">Dokumentasi
                        Acara</span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900"
                        style="font-family: 'Outfit', sans-serif;">Our Events Gallery</h2>
                </div>
                <div class="grid-gallery">
                    <div
                        class="aspect-square rounded-3xl overflow-hidden shadow-sm hover:scale-[1.03] transition-all duration-300">
                        <img src="https://images.unsplash.com/photo-1505373877841-8d25f7d46678?q=80&w=400&auto=format&fit=crop"
                            class="w-full h-full object-cover" alt="Gallery">
                    </div>
                    <div
                        class="aspect-square rounded-3xl overflow-hidden shadow-sm hover:scale-[1.03] transition-all duration-300">
                        <img src="https://images.unsplash.com/photo-1475721027785-f74eccf877e2?q=80&w=400&auto=format&fit=crop"
                            class="w-full h-full object-cover" alt="Gallery">
                    </div>
                    <div
                        class="aspect-square rounded-3xl overflow-hidden shadow-sm hover:scale-[1.03] transition-all duration-300">
                        <img src="https://images.unsplash.com/photo-1540575467063-178a50c2df87?q=80&w=400&auto=format&fit=crop"
                            class="w-full h-full object-cover" alt="Gallery">
                    </div>
                    <div
                        class="aspect-square rounded-3xl overflow-hidden shadow-sm hover:scale-[1.03] transition-all duration-300">
                        <img src="https://images.unsplash.com/photo-1511578314322-379afb476865?q=80&w=400&auto=format&fit=crop"
                            class="w-full h-full object-cover" alt="Gallery">
                    </div>
                </div>
            </div>

        </div>
    </section>

@endsection

@section('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // 1. Javascript Countdown Timer logic
            const countdownEl = document.getElementById('countdown-timer');
            if (countdownEl) {
                const dateStr = countdownEl.getAttribute('data-time');
                const targetDate = new Date(dateStr).getTime();

                const timer = setInterval(function () {
                    const now = new Date().getTime();
                    const distance = targetDate - now;

                    if (distance < 0) {
                        clearInterval(timer);
                        document.getElementById('cd-days').innerText = "00";
                        document.getElementById('cd-hours').innerText = "00";
                        document.getElementById('cd-minutes').innerText = "00";
                        document.getElementById('cd-seconds').innerText = "00";
                        return;
                    }

                    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    document.getElementById('cd-days').innerText = String(days).padStart(2, '0');
                    document.getElementById('cd-hours').innerText = String(hours).padStart(2, '0');
                    document.getElementById('cd-minutes').innerText = String(minutes).padStart(2, '0');
                    document.getElementById('cd-seconds').innerText = String(seconds).padStart(2, '0');
                }, 1000);
            }

            // 2. Feature Modal logic with Event Delegation
            const modal = document.getElementById('featureModal');
            const closeBtn = document.getElementById('closeModalBtn');
            const modalImage = document.getElementById('modalImage');
            const modalTitle = document.getElementById('modalTitle');
            const modalDescription = document.getElementById('modalDescription');

            document.addEventListener('click', function (e) {
                const trigger = e.target.closest('.feature-modal-trigger');
                if (trigger && modal) {
                    e.preventDefault();
                    const title = trigger.getAttribute('data-title');
                    const description = trigger.getAttribute('data-description');
                    const image = trigger.getAttribute('data-image');

                    if (modalTitle) modalTitle.textContent = title;
                    if (modalDescription) modalDescription.textContent = description;
                    if (modalImage) {
                        modalImage.src = image;
                        modalImage.alt = title;
                    }

                    modal.classList.remove('hidden');
                    document.body.style.overflow = 'hidden';
                }
            });

            function closeModal() {
                if (modal) {
                    modal.classList.add('hidden');
                    document.body.style.overflow = 'auto';
                    if (modalImage) {
                        modalImage.src = "data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7";
                    }
                }
            }

            if (closeBtn) closeBtn.addEventListener('click', closeModal);

            if (modal) {
                modal.addEventListener('click', function (e) {
                    if (e.target === modal) {
                        closeModal();
                    }
                });
            }

            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape' && modal && !modal.classList.contains('hidden')) {
                    closeModal();
                }
            });

            // 3. Map Modal logic with safety check for Leaflet (L)
            const mapModal = document.getElementById('mapModal');
            const openMapBtn = document.getElementById('openMapBtn');
            const closeMapBtn = document.getElementById('closeMapBtn');
            let mapInstance = null;

            if (openMapBtn && mapModal) {
                openMapBtn.addEventListener('click', function () {
                    mapModal.classList.remove('hidden');

                    if (!mapInstance) {
                        setTimeout(() => {
                            if (typeof L === 'undefined') {
                                document.getElementById('eventMap').innerHTML = `
                                        <div style="display:flex; flex-direction:column; align-items:center; justify-content:center; height:100%; text-align:center; padding:24px; color:#64748b;">
                                            <div style="padding:16px; background:#f1f5f9; border-radius:50%; margin-bottom:16px; color:#475569; display:inline-flex; align-items:center; justify-content:center;">
                                                <svg style="width:32px; height:32px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-wifi-off"><line x1="1" y1="1" x2="23" y2="23"></line><path d="M16.72 11.06A10.94 10.94 0 0 1 19 12.5"></path><path d="M5 12.5a10.94 10.94 0 0 1 5.17-2.39"></path><path d="M10.71 5.05A16 16 0 0 1 22.5 8"></path><path d="M1.5 8a15.83 15.83 0 0 1 9-2.7"></path><path d="M12 20h.01"></path></svg>
                                            </div>
                                            <h4 style="font-size:16px; font-weight:800; color:#0f172a; margin:0 0 8px 0; font-family:'Outfit',sans-serif;">Peta Gagal Dimuat</h4>
                                            <p style="font-size:12px; color:#64748b; margin:0; max-width:320px; line-height:1.5;">Pastikan koneksi internet Anda aktif untuk memuat peta interaktif OpenStreetMap.</p>
                                        </div>
                                    `;
                                return;
                            }

                            mapInstance = L.map('eventMap').setView([-6.2088, 106.8456], 12);

                            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                maxZoom: 18,
                                attribution: '© OpenStreetMap contributors'
                            }).addTo(mapInstance);

                            fetch('/api/events-locations')
                                .then(response => response.json())
                                .then(events => {
                                    events.forEach(event => {
                                        if (event.latitude && event.longitude) {
                                            const marker = L.marker([event.latitude, event.longitude]).addTo(mapInstance);
                                            const popupContent = `
                                                    <div class="text-sm" style="font-family: sans-serif; padding: 4px;">
                                                        <h4 class="font-bold text-blue-600" style="margin: 0 0 4px 0; font-size: 14px;">${event.title}</h4>
                                                        <p class="text-slate-600" style="margin: 0 0 4px 0; font-size: 12px;">${event.location}</p>
                                                        <p class="text-slate-500 text-xs" style="margin: 0; font-size: 11px;">${new Date(event.date_time).toLocaleDateString('id-ID')}</p>
                                                    </div>
                                                `;
                                            marker.bindPopup(popupContent);
                                        }
                                    });
                                })
                                .catch(err => console.error('Error fetching events:', err));
                        }, 100);
                    }
                });
            }

            if (closeMapBtn) {
                closeMapBtn.addEventListener('click', function () {
                    mapModal.classList.add('hidden');
                });
            }

            if (mapModal) {
                mapModal.addEventListener('click', function (e) {
                    if (e.target === mapModal) {
                        mapModal.classList.add('hidden');
                    }
                });
            }
        });
    </script>
@endsection