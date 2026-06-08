@extends('layouts.app')

@section('title', 'EventHub - Portal Event & Tiket Digital Terlengkap')

@section('styles')
    <style>
        .hero-wave {
            position: relative;
            background: linear-gradient(135deg, #1e3a8a 0%, #1d4ed8 50%, #2563eb 100%);
            overflow: hidden;
        }

        .hero-wave::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 120px;
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1440 320'%3E%3Cpath fill='%23f8fafc' fill-opacity='1' d='M0,224L48,218.7C96,213,192,203,288,186.7C384,171,480,149,576,144C672,139,768,149,864,165.3C960,181,1056,203,1152,208C1248,213,1344,203,1392,197.3L1440,192L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z'%3E%3C/path%3E%3C/svg%3E") no-repeat;
            background-size: cover;
            z-index: 10;
        }

        .feature-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 25px -5px rgba(59, 130, 246, 0.1), 0 10px 10px -5px rgba(59, 130, 246, 0.04);
        }
    </style>
@endsection

@section('content')

    <!-- Hero Section (Matches Mockup Image Top) -->
    <section class="hero-wave text-white pt-16 pb-32 relative">
        <div class="absolute inset-0 opacity-15 mix-blend-overlay bg-cover bg-center"
            style="background-image: url('https://images.unsplash.com/photo-1511578314322-379afb476865?q=80&w=1200&auto=format&fit=crop');">
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-20">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                <!-- Hero Left -->
                <div class="lg:col-span-7 space-y-6">
                    <div
                        class="inline-flex items-center gap-2 px-3 py-1.5 bg-blue-500/20 border border-blue-400/30 rounded-full text-blue-200 text-xs font-bold uppercase tracking-wider">
                        <i data-lucide="award" class="w-4 h-4"></i> Business Expo 2026
                    </div>
                    <h1 class="text-4xl sm:text-6xl font-extrabold tracking-tight leading-tight">
                        Big Conference<br>
                        <span class="text-blue-300">& Workshop</span>
                    </h1>
                    <p class="text-base sm:text-lg text-blue-100 max-w-xl leading-relaxed">
                        Sistem Manajemen Event Terintegrasi. Beli tiket digital dengan mudah secara langsung, kelola jadwal
                        event terbaik dan nikmati sesi interaktif.
                    </p>
                    <div class="flex flex-wrap gap-4 pt-2">
                        @if($featuredEvent)
                            <a href="{{ route('events.show', $featuredEvent->slug) }}"
                                class="px-8 py-4 bg-white text-blue-700 hover:bg-blue-50 font-bold rounded-2xl shadow-xl transition-all duration-300 hover:-translate-y-1">
                                Beli Tiket Sekarang
                            </a>
                        @endif
                        <a href="#schedule-section"
                            class="px-8 py-4 bg-transparent border-2 border-white/40 hover:border-white text-white font-bold rounded-2xl transition-all duration-300 hover:bg-white/10">
                            Lihat Jadwal
                        </a>
                    </div>
                </div>

                <!-- Hero Right (Sleek Image Layout Matches Mockup) -->
                <div class="lg:col-span-5 relative flex justify-center">
                    <div class="relative w-full max-w-sm sm:max-w-md">
                        <!-- Main Round Banner -->
                        <div
                            class="aspect-square rounded-full border-[12px] border-white/10 overflow-hidden shadow-2xl relative">
                            <img src="https://images.unsplash.com/photo-1475721027785-f74eccf877e2?q=80&w=600&auto=format&fit=crop"
                                alt="Speaker" class="w-full h-full object-cover">
                            <!-- Play indicator overlay -->
                            <div class="absolute inset-0 bg-blue-900/30 flex items-center justify-center">
                                <button
                                    class="w-20 h-20 bg-white text-blue-600 rounded-full flex items-center justify-center shadow-2xl hover:scale-110 transition-transform duration-300">
                                    <i data-lucide="play" class="w-8 h-8 fill-current ml-1"></i>
                                </button>
                            </div>
                        </div>
                        <!-- Floating stats badge -->
                        <div
                            class="absolute -bottom-6 -left-6 bg-white text-slate-900 p-5 rounded-3xl shadow-xl border border-slate-100 flex items-center gap-4">
                            <div class="p-3 bg-blue-100 text-blue-600 rounded-2xl">
                                <i data-lucide="users" class="w-6 h-6"></i>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500 font-bold">Total Pendaftar</p>
                                <p class="text-lg font-black text-slate-800">1.250+ Peserta</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Know More About Section (Middle Image Grid layout from mockup) -->
    <section class="py-20 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                <!-- Left Side Mockup Grid -->
                <div class="lg:col-span-6 grid grid-cols-12 gap-4">
                    <div class="col-span-8 rounded-3xl overflow-hidden shadow-lg h-80">
                        <img src="https://images.unsplash.com/photo-1540575467063-178a50c2df87?q=80&w=600&auto=format&fit=crop"
                            class="w-full h-full object-cover" alt="Workshop">
                    </div>
                    <div class="col-span-4 rounded-3xl overflow-hidden shadow-lg h-80 pt-12">
                        <img src="https://images.unsplash.com/photo-1515187029135-18ee286d815b?q=80&w=400&auto=format&fit=crop"
                            class="w-full h-full object-cover" alt="Discussion">
                    </div>
                </div>

                <!-- Right Side Text -->
                <div class="lg:col-span-6 space-y-6">
                    <span class="text-sm font-extrabold text-blue-600 uppercase tracking-widest block">Mengenal
                        Eventek</span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 leading-tight">
                        Menciptakan Pengalaman Event Digital yang Luar Biasa
                    </h2>
                    <p class="text-slate-600 leading-relaxed text-sm">
                        Kami hadir sebagai platform manajemen informasi event terlengkap. Anda dapat mencari agenda,
                        mendaftar sesi penting, mendapatkan tiket digital unik, hingga mengelola detail transaksi secara
                        transparan dan instan.
                    </p>

                    <div class="p-5 bg-white border border-slate-100 rounded-2xl flex items-start gap-4">
                        <div class="p-3 bg-blue-50 text-blue-600 rounded-xl mt-1">
                            <i data-lucide="map-pin" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-800 text-sm">Lokasi Strategis</h4>
                            <p class="text-xs text-slate-500 mt-1 leading-relaxed">Diselenggarakan di pusat konvensi modern
                                dengan opsi kehadiran hybrid secara virtual.</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
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

    <!-- Countdown Section (Matches Mockup Count Every Second Section) -->
    @if($featuredEvent)
        <section class="py-10 bg-slate-900 relative overflow-hidden">
            <div class="absolute inset-0 bg-blue-950 opacity-90"></div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-20">
                <div class="flex flex-col lg:flex-row items-center justify-between gap-8 py-8">
                    <div class="space-y-2 text-center lg:text-left">
                        <span class="text-blue-400 font-extrabold text-xs uppercase tracking-widest">Waktu Terbatas</span>
                        <h3 class="text-2xl sm:text-3xl font-extrabold text-white">Count Every Second Until Event</h3>
                        <p class="text-sm text-slate-400 max-w-md">{{ $featuredEvent->title }} akan segera dimulai!</p>
                    </div>

                    <!-- Countdown values -->
                    <div class="flex gap-4 sm:gap-6 justify-center" id="countdown-timer"
                        data-time="{{ $featuredEvent->date_time->toIso8601String() }}">
                        <div
                            class="flex flex-col items-center justify-center bg-blue-800/40 border border-blue-700/50 rounded-2xl w-20 h-24 sm:w-24 sm:h-28 shadow-xl">
                            <span class="text-3xl sm:text-4xl font-extrabold text-white" id="cd-days">00</span>
                            <span
                                class="text-[10px] sm:text-xs text-blue-200 font-bold uppercase tracking-wider mt-1">Hari</span>
                        </div>
                        <div
                            class="flex flex-col items-center justify-center bg-blue-800/40 border border-blue-700/50 rounded-2xl w-20 h-24 sm:w-24 sm:h-28 shadow-xl">
                            <span class="text-3xl sm:text-4xl font-extrabold text-white" id="cd-hours">00</span>
                            <span
                                class="text-[10px] sm:text-xs text-blue-200 font-bold uppercase tracking-wider mt-1">Jam</span>
                        </div>
                        <div
                            class="flex flex-col items-center justify-center bg-blue-800/40 border border-blue-700/50 rounded-2xl w-20 h-24 sm:w-24 sm:h-28 shadow-xl">
                            <span class="text-3xl sm:text-4xl font-extrabold text-white" id="cd-minutes">00</span>
                            <span
                                class="text-[10px] sm:text-xs text-blue-200 font-bold uppercase tracking-wider mt-1">Menit</span>
                        </div>
                        <div
                            class="flex flex-col items-center justify-center bg-blue-800/40 border border-blue-700/50 rounded-2xl w-20 h-24 sm:w-24 sm:h-28 shadow-xl">
                            <span class="text-3xl sm:text-4xl font-extrabold text-white animate-pulse" id="cd-seconds">00</span>
                            <span
                                class="text-[10px] sm:text-xs text-blue-200 font-bold uppercase tracking-wider mt-1">Detik</span>
                        </div>
                    </div>

                    <a href="{{ route('events.show', $featuredEvent->slug) }}"
                        class="px-8 py-4 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-2xl shadow-xl shadow-blue-500/20 transition-all duration-300">
                        Pesan Tiket
                    </a>
                </div>
            </div>
        </section>
    @endif

    <!-- Features Highlights (Matches Unifying For A Better World) -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-4">
            <span class="text-sm font-extrabold text-blue-600 uppercase tracking-widest">Fitur Event</span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900">Unifying For A Better World</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 pt-10 text-left">
                <!-- Card 1 -->
                <button
                    class="feature-card feature-modal-trigger bg-slate-50 border border-slate-100 p-8 rounded-3xl space-y-4 relative overflow-hidden group text-left cursor-pointer hover:shadow-lg transition-all duration-300"
                    data-feature="speaker" data-title="Speaker Lineup"
                    data-description="Pembicara terkemuka dunia membagikan insight dan pengalaman industri terbaru langsung untuk Anda."
                    data-image="https://images.unsplash.com/photo-1510915361894-db8b60106cb1?w=800&h=500&fit=crop">
                    <div
                        class="p-4 bg-blue-100 text-blue-600 rounded-2xl w-fit group-hover:bg-blue-600 group-hover:text-white transition-all duration-300">
                        <i data-lucide="mic" class="w-6 h-6"></i>
                    </div>
                    <h4 class="font-extrabold text-slate-900 text-lg">Speaker Lineup</h4>
                    <p class="text-slate-500 text-xs leading-relaxed">Pembicara terkemuka dunia membagikan insight terdalam
                        tentang industri.</p>
                </button>
                <!-- Card 2 -->
                <button
                    class="feature-card feature-modal-trigger bg-slate-50 border border-slate-100 p-8 rounded-3xl space-y-4 relative overflow-hidden group text-left cursor-pointer hover:shadow-lg transition-all duration-300"
                    data-feature="networking" data-title="Networking People"
                    data-description="Terhubung dengan ribuan praktisi dan founder berdedikasi tinggi untuk membangun relasi bisnis jangka panjang."
                    data-image="https://images.unsplash.com/photo-1552664730-d307ca884978?w=800&h=500&fit=crop">
                    <div
                        class="p-4 bg-blue-100 text-blue-600 rounded-2xl w-fit group-hover:bg-blue-600 group-hover:text-white transition-all duration-300">
                        <i data-lucide="users-round" class="w-6 h-6"></i>
                    </div>
                    <h4 class="font-extrabold text-slate-900 text-lg">Networking People</h4>
                    <p class="text-slate-500 text-xs leading-relaxed">Hubungkan diri Anda dengan ribuan praktisi dan founder
                        berdedikasi tinggi.</p>
                </button>
                <!-- Card 3 -->
                <button
                    class="feature-card feature-modal-trigger bg-slate-50 border border-slate-100 p-8 rounded-3xl space-y-4 relative overflow-hidden group text-left cursor-pointer hover:shadow-lg transition-all duration-300"
                    data-feature="keynote" data-title="Engaging Keynote"
                    data-description="Materi berkualitas tinggi yang dapat langsung diimplementasikan dalam strategi bisnis Anda sehari-hari."
                    data-image="https://images.unsplash.com/photo-1559027615-cd2628902d4a?w=800&h=500&fit=crop">
                    <div
                        class="p-4 bg-blue-100 text-blue-600 rounded-2xl w-fit group-hover:bg-blue-600 group-hover:text-white transition-all duration-300">
                        <i data-lucide="key" class="w-6 h-6"></i>
                    </div>
                    <h4 class="font-extrabold text-slate-900 text-lg">Engaging Keynote</h4>
                    <p class="text-slate-500 text-xs leading-relaxed">Sesi materi berdurasi padat yang dirancang untuk
                        langsung bisa diimplementasikan.</p>
                </button>
                <!-- Card 4 -->
                <button
                    class="feature-card feature-modal-trigger bg-slate-50 border border-slate-100 p-8 rounded-3xl space-y-4 relative overflow-hidden group text-left cursor-pointer hover:shadow-lg transition-all duration-300"
                    data-feature="exhibition" data-title="Exhibition Space"
                    data-description="Showcase produk inovasi terbaru dari perusahaan global terkemuka yang siap mengembangkan bisnis Anda."
                    data-image="https://images.unsplash.com/photo-1475721027785-f74eccf877e2?w=800&h=500&fit=crop">
                    <div
                        class="p-4 bg-blue-100 text-blue-600 rounded-2xl w-fit group-hover:bg-blue-600 group-hover:text-white transition-all duration-300">
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
        <div class="bg-white rounded-3xl max-w-xl w-full shadow-2xl my-8 animate-in fade-in zoom-in duration-300 relative">

            <!-- Modal Image -->
            <div class="w-full h-72 rounded-t-3xl relative">
                <img id="modalImage" src="" alt="" class="w-full h-full object-cover rounded-t-3xl">
            </div>

            <!-- Close button - Overlayed on top -->
            <button id="closeModalBtn"
                class="absolute top-5 right-5 w-9 h-9 bg-black/70 hover:bg-black rounded-full transition-all flex items-center justify-center"
                style="z-index: 50;">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>

            <!-- Modal Content -->
            <div class="p-8 space-y-6">
                <h3 id="modalTitle" class="text-3xl font-extrabold text-slate-900"></h3>
                <p id="modalDescription" class="text-slate-600 leading-relaxed text-base"></p>

                <button
                    class="w-full px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition-colors">
                    Daftar Sekarang
                </button>
            </div>
        </div>
    </div>

    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes zoomIn {
            from {
                transform: scale(0.95);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        .animate-in {
            animation: fadeIn 0.3s ease-out, zoomIn 0.3s ease-out;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('featureModal');
            const closeBtn = document.getElementById('closeModalBtn');
            const triggerBtns = document.querySelectorAll('.feature-modal-trigger');
            const modalImage = document.getElementById('modalImage');
            const modalTitle = document.getElementById('modalTitle');
            const modalDescription = document.getElementById('modalDescription');

            // Open modal
            triggerBtns.forEach(btn => {
                btn.addEventListener('click', function (e) {
                    e.preventDefault();
                    const title = this.getAttribute('data-title');
                    const description = this.getAttribute('data-description');
                    const image = this.getAttribute('data-image');

                    modalTitle.textContent = title;
                    modalDescription.textContent = description;
                    modalImage.src = image;
                    modalImage.alt = title;

                    modal.classList.remove('hidden');
                    document.body.style.overflow = 'hidden';
                });
            });

            // Close modal
            function closeModal() {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }

            closeBtn.addEventListener('click', closeModal);

            // Close when clicking outside modal
            modal.addEventListener('click', function (e) {
                if (e.target === modal) {
                    closeModal();
                }
            });

            // Close with Escape key
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
                    closeModal();
                }
            });
        });
    </script>

    <!-- Events Map Section -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center space-y-4 mb-10">
                <span class="text-sm font-extrabold text-blue-600 uppercase tracking-widest">Lokasi Strategis</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900">Diselenggarakan di pusat konvensi modern
                    dengan opsi kehadiran hybrid secara virtual.</h2>
                <button id="openMapBtn"
                    class="inline-block px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition-all duration-300 mt-6">
                    <i data-lucide="map-pin" class="w-5 h-5 inline mr-2"></i>
                    Lihat Peta Lokasi Event
                </button>
            </div>
        </div>
    </section>

    <!-- Map Modal -->
    <div id="mapModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-4xl w-full shadow-2xl relative">
            <button id="closeMapBtn"
                class="absolute top-5 right-5 w-10 h-10 bg-red-500 hover:bg-red-600 rounded-full transition-all flex items-center justify-center z-10"
                style="z-index: 50;">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>

            <div class="p-6 space-y-4">
                <h3 class="text-2xl font-extrabold text-slate-900">Persebaran Event</h3>
                <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
                <div id="eventMap" style="height: 500px; border-radius: 20px; overflow: hidden;"></div>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const mapModal = document.getElementById('mapModal');
            const openMapBtn = document.getElementById('openMapBtn');
            const closeMapBtn = document.getElementById('closeMapBtn');
            const mapContainer = document.getElementById('eventMap');
            let mapInstance = null;

            openMapBtn.addEventListener('click', function () {
                mapModal.classList.remove('hidden');

                // Initialize map if not already done
                if (!mapInstance) {
                    setTimeout(() => {
                        mapInstance = L.map('eventMap').setView([-6.2088, 106.8456], 12);

                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            maxZoom: 18,
                            attribution: '© OpenStreetMap contributors'
                        }).addTo(mapInstance);

                        // Fetch events with location data
                        fetch('/api/events-locations')
                            .then(response => response.json())
                            .then(events => {
                                events.forEach(event => {
                                    if (event.latitude && event.longitude) {
                                        const marker = L.marker([event.latitude, event.longitude]).addTo(mapInstance);
                                        const popupContent = `
                                            <div class="text-sm">
                                                <h4 class="font-bold text-blue-600">${event.title}</h4>
                                                <p class="text-slate-600">${event.location}</p>
                                                <p class="text-slate-500 text-xs">${new Date(event.date_time).toLocaleDateString('id-ID')}</p>
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

            closeMapBtn.addEventListener('click', function () {
                mapModal.classList.add('hidden');
            });

            mapModal.addEventListener('click', function (e) {
                if (e.target === mapModal) {
                    mapModal.classList.add('hidden');
                }
            });
        });
    </script>

    <!-- Search & Event Schedule Section (Matches Information of Event Schedule section) -->
    <section id="schedule-section" class="py-20 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header & Search Form -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6 mb-12">
                <div class="space-y-2">
                    <span class="text-sm font-extrabold text-blue-600 uppercase tracking-widest block">Agenda Acara</span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900">Daftar Agenda & Event Mendatang</h2>
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
                            class="w-full pl-11 pr-4 py-3 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <button type="submit"
                        class="px-5 py-3 bg-blue-600 text-white rounded-xl text-sm font-semibold hover:bg-blue-700 transition">
                        Cari
                    </button>
                    @if(request('search') || request('category'))
                        <a href="{{ route('home') }}"
                            class="px-4 py-3 bg-slate-200 text-slate-700 text-center rounded-xl text-sm font-semibold hover:bg-slate-300 transition">
                            Reset
                        </a>
                    @endif
                </form>
            </div>

            <!-- Categories Navigation Tabs -->
            <div id="categories" class="flex overflow-x-auto pb-4 gap-2 mb-10 border-b border-slate-200 scroll-mt-24">
                <a href="{{ route('home', ['search' => request('search')]) }}#categories" class="px-6 py-3 rounded-xl text-sm font-bold whitespace-nowrap transition-all duration-200 {{ !request('category') ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/20' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-100' }}">Semua Kategori</a>
                @foreach($categories as $cat)
                    <a href="{{ route('home', ['category' => $cat->slug, 'search' => request('search')]) }}#categories" class="px-6 py-3 rounded-xl text-sm font-bold whitespace-nowrap transition-all duration-200 {{ request('category') == $cat->slug ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/20' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-100' }}">{{ $cat->name }} ({{ $cat->events_count }})</a>
                @endforeach
            </div>

            <!-- Event Cards List -->
            @if($events->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($events as $event)
                        <div
                            class="bg-white rounded-3xl overflow-hidden border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col group h-full">
                            <!-- Banner image -->
                            <div class="relative aspect-[16/10] overflow-hidden">
                                <img src="{{ $event->banner_image }}" alt="{{ $event->title }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                <!-- Category Badge -->
                                <div
                                    class="absolute top-4 left-4 bg-white/90 backdrop-blur px-3 py-1.5 rounded-xl text-[10px] font-bold uppercase tracking-wider text-blue-600 shadow-sm">
                                    {{ $event->category->name }}
                                </div>
                            </div>

                            <!-- Card Content -->
                            <div class="p-6 flex-grow flex flex-col justify-between">
                                <div class="space-y-3">
                                    <!-- Date & Time -->
                                    <div class="flex items-center gap-2 text-xs text-slate-400 font-bold">
                                        <i data-lucide="calendar" class="w-4 h-4 text-blue-500"></i>
                                        {{ $event->date_time->translatedFormat('d F Y | H:i') }} WIB
                                    </div>
                                    <h3
                                        class="font-extrabold text-slate-900 text-lg leading-snug group-hover:text-blue-600 transition-colors">
                                        <a href="{{ route('events.show', $event->slug) }}">{{ $event->title }}</a>
                                    </h3>
                                    <p class="text-slate-500 text-xs line-clamp-2 leading-relaxed">
                                        {{ $event->description }}
                                    </p>
                                </div>

                                <div class="border-t border-slate-100 pt-5 mt-5 flex justify-between items-center">
                                    <div>
                                        <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block">Harga
                                            Mulai</span>
                                        <span class="text-sm font-black text-blue-600">
                                            Rp{{ number_format($event->ticketTypes->min('price'), 0, ',', '.') }}
                                        </span>
                                    </div>
                                    <a href="{{ route('events.show', $event->slug) }}"
                                        class="px-4 py-2.5 bg-blue-50 hover:bg-blue-600 text-blue-600 hover:text-white rounded-xl text-xs font-bold transition-all duration-300">
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

    <!-- Pricing Tickets Section (Choose Your Tickets) -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-4">
            <span class="text-sm font-extrabold text-blue-600 uppercase tracking-widest">Pilihan Tiket</span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900">Choose Your Tickets</h2>
            <p class="text-slate-500 text-sm max-w-md mx-auto leading-relaxed">Pilih kategori tiket terbaik untuk kenyamanan
                menghadiri event spektakuler ini.</p>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 pt-10 text-left">
                <!-- Silver Ticket -->
                <div
                    class="bg-slate-50 border border-slate-200 rounded-3xl p-8 space-y-6 flex flex-col justify-between hover:border-blue-500 transition duration-300">
                    <div class="space-y-4">
                        <div class="flex justify-between items-start">
                            <div>
                                <h4 class="font-extrabold text-slate-900 text-xl">Silver Ticket</h4>
                                <p class="text-xs text-slate-500 mt-1">Akses standar event</p>
                            </div>
                            <span
                                class="px-3 py-1 bg-slate-200 text-slate-700 text-[10px] font-bold rounded-lg uppercase">Standard</span>
                        </div>
                        <div class="border-t border-slate-200 pt-4">
                            <span class="text-3xl font-black text-slate-800">Rp150.000</span>
                            <span class="text-xs text-slate-400">/orang</span>
                        </div>
                        <ul class="space-y-2 text-xs font-semibold text-slate-600 pt-4">
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
                        class="w-full text-center py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-bold shadow-lg shadow-blue-500/20 block transition mt-6">
                        Pilih Event
                    </a>
                </div>

                <!-- Gold Ticket (Recommended) -->
                <div
                    class="bg-blue-900 text-white rounded-3xl p-8 space-y-6 flex flex-col justify-between relative shadow-2xl border-2 border-blue-500 scale-105 z-10">
                    <div
                        class="absolute -top-4 left-1/2 -translate-x-1/2 bg-blue-500 text-white px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-wider">
                        Terpopuler
                    </div>
                    <div class="space-y-4">
                        <div class="flex justify-between items-start">
                            <div>
                                <h4 class="font-extrabold text-white text-xl">Gold Ticket</h4>
                                <p class="text-xs text-blue-200 mt-1">Kenyamanan ekstra & eksklusif</p>
                            </div>
                            <span
                                class="px-3 py-1 bg-blue-500 text-white text-[10px] font-bold rounded-lg uppercase">VIP</span>
                        </div>
                        <div class="border-t border-blue-800 pt-4">
                            <span class="text-3xl font-black text-white">Rp350.000</span>
                            <span class="text-xs text-blue-300">/orang</span>
                        </div>
                        <ul class="space-y-2 text-xs font-semibold text-blue-100 pt-4">
                            <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-400"></i>
                                Akses Kursi Depan/Tengah</li>
                            <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-400"></i>
                                E-Ticket Resmi + Barcode</li>
                            <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-400"></i>
                                Konsumsi Makan Siang</li>
                            <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-400"></i>
                                E-Certificate Peserta</li>
                        </ul>
                    </div>
                    <a href="#schedule-section"
                        class="w-full text-center py-3 bg-white hover:bg-blue-50 text-blue-900 rounded-xl text-sm font-bold shadow-xl block transition mt-6">
                        Pilih Event
                    </a>
                </div>

                <!-- Platinum VIP -->
                <div
                    class="bg-slate-50 border border-slate-200 rounded-3xl p-8 space-y-6 flex flex-col justify-between hover:border-blue-500 transition duration-300">
                    <div class="space-y-4">
                        <div class="flex justify-between items-start">
                            <div>
                                <h4 class="font-extrabold text-slate-900 text-xl">Platinum VIP</h4>
                                <p class="text-xs text-slate-500 mt-1">Fasilitas terbaik tanpa batas</p>
                            </div>
                            <span
                                class="px-3 py-1 bg-slate-200 text-slate-700 text-[10px] font-bold rounded-lg uppercase">VVIP</span>
                        </div>
                        <div class="border-t border-slate-200 pt-4">
                            <span class="text-3xl font-black text-slate-800">Rp750.000</span>
                            <span class="text-xs text-slate-400">/orang</span>
                        </div>
                        <ul class="space-y-2 text-xs font-semibold text-slate-600 pt-4">
                            <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-500"></i>
                                Akses VIP Lounge & Baris Depan</li>
                            <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-500"></i>
                                E-Ticket + ID Card Fisik Eksklusif</li>
                            <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-500"></i>
                                Sesi Foto & Meet & Greet Pembicara</li>
                            <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-500"></i>
                                Exclusive Merch Kit (T-shirt, Notebook)</li>
                        </ul>
                    </div>
                    <a href="#schedule-section"
                        class="w-full text-center py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-bold shadow-lg shadow-blue-500/20 block transition mt-6">
                        Pilih Event
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Meet Our Speakers & Gallery (Matches Bottom Grid layouts from mockup) -->
    <section class="py-20 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-16">

            <!-- Speakers grid -->
            <div class="space-y-10">
                <div class="text-center space-y-2">
                    <span class="text-sm font-extrabold text-blue-600 uppercase tracking-widest block">Narasumber
                        Utama</span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900">Meet Our Speakers</h2>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    <!-- Speaker 1 -->
                    <div
                        class="text-center bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition">
                        <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=300&auto=format&fit=crop"
                            class="w-24 h-24 rounded-full object-cover mx-auto shadow-md mb-4" alt="Speaker">
                        <h4 class="font-extrabold text-slate-800 text-sm">Sarah Jenkins</h4>
                        <p class="text-xs text-blue-600 font-bold mt-1">Chief Creative Director</p>
                    </div>
                    <!-- Speaker 2 -->
                    <div
                        class="text-center bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition">
                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?q=80&w=300&auto=format&fit=crop"
                            class="w-24 h-24 rounded-full object-cover mx-auto shadow-md mb-4" alt="Speaker">
                        <h4 class="font-extrabold text-slate-800 text-sm">Marcus Brody</h4>
                        <p class="text-xs text-blue-600 font-bold mt-1">VP Innovation Tech</p>
                    </div>
                    <!-- Speaker 3 -->
                    <div
                        class="text-center bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition">
                        <img src="https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?q=80&w=300&auto=format&fit=crop"
                            class="w-24 h-24 rounded-full object-cover mx-auto shadow-md mb-4" alt="Speaker">
                        <h4 class="font-extrabold text-slate-800 text-sm">David Lee</h4>
                        <p class="text-xs text-blue-600 font-bold mt-1">Founder & CEO Startup</p>
                    </div>
                    <!-- Speaker 4 -->
                    <div
                        class="text-center bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition">
                        <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?q=80&w=300&auto=format&fit=crop"
                            class="w-24 h-24 rounded-full object-cover mx-auto shadow-md mb-4" alt="Speaker">
                        <h4 class="font-extrabold text-slate-800 text-sm">Jessica Tan</h4>
                        <p class="text-xs text-blue-600 font-bold mt-1">AI Research Lead</p>
                    </div>
                </div>
            </div>

            <!-- Gallery grid -->
            <div class="space-y-10">
                <div class="text-center space-y-2">
                    <span class="text-sm font-extrabold text-blue-600 uppercase tracking-widest block">Dokumentasi
                        Acara</span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900">Our Events Gallery</h2>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div
                        class="aspect-square rounded-3xl overflow-hidden shadow-sm hover:scale-105 transition-transform duration-300">
                        <img src="https://images.unsplash.com/photo-1505373877841-8d25f7d46678?q=80&w=400&auto=format&fit=crop"
                            class="w-full h-full object-cover" alt="Gallery">
                    </div>
                    <div
                        class="aspect-square rounded-3xl overflow-hidden shadow-sm hover:scale-105 transition-transform duration-300">
                        <img src="https://images.unsplash.com/photo-1475721027785-f74eccf877e2?q=80&w=400&auto=format&fit=crop"
                            class="w-full h-full object-cover" alt="Gallery">
                    </div>
                    <div
                        class="aspect-square rounded-3xl overflow-hidden shadow-sm hover:scale-105 transition-transform duration-300">
                        <img src="https://images.unsplash.com/photo-1540575467063-178a50c2df87?q=80&w=400&auto=format&fit=crop"
                            class="w-full h-full object-cover" alt="Gallery">
                    </div>
                    <div
                        class="aspect-square rounded-3xl overflow-hidden shadow-sm hover:scale-105 transition-transform duration-300">
                        <img src="https://images.unsplash.com/photo-1511578314322-379afb476865?q=80&w=400&auto=format&fit=crop"
                            class="w-full h-full object-cover" alt="Gallery">
                    </div>
                </div>
            </div>

        </div>
    </section>

@endsection

@section('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Javascript Countdown Timer logic
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
        });
    </script>
@endsection