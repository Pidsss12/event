@extends('layouts.app')

@section('title', 'Masuk ke EventHub')

@section('content')
<div class="py-16 flex items-center justify-center min-h-[70vh]">
    <div class="w-full max-w-md bg-white rounded-3xl border border-slate-100 shadow-xl p-8 space-y-6">
        
        <div class="text-center space-y-2">
            <div class="p-3 bg-blue-50 text-blue-600 rounded-2xl w-fit mx-auto">
                <i data-lucide="key-round" class="w-6 h-6"></i>
            </div>
            <h2 class="text-2xl font-extrabold text-slate-900">Selamat Datang Kembali</h2>
            <p class="text-xs text-slate-500">Silakan masuk untuk melanjutkan pembelian tiket dan akses dashboard.</p>
        </div>

        <form action="{{ route('login') }}" method="POST" class="space-y-4">
            @csrf

            <!-- Email -->
            <div class="space-y-1.5">
                <label for="email" class="text-xs font-bold text-slate-700 uppercase tracking-wider">Alamat Email</label>
                <div class="relative">
                    <i data-lucide="mail" class="absolute left-4 top-3.5 w-4 h-4 text-slate-400"></i>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                        class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition"
                        placeholder="nama@email.com">
                </div>
            </div>

            <!-- Password -->
            <div class="space-y-1.5">
                <div class="flex justify-between items-center">
                    <label for="password" class="text-xs font-bold text-slate-700 uppercase tracking-wider">Password</label>
                </div>
                <div class="relative">
                    <i data-lucide="lock" class="absolute left-4 top-3.5 w-4 h-4 text-slate-400"></i>
                    <input type="password" name="password" id="password" required
                        class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition"
                        placeholder="Masukkan password Anda">
                </div>
            </div>

            <!-- Remember Me -->
            <div class="flex items-center justify-between pt-1">
                <label class="flex items-center gap-2 text-xs font-semibold text-slate-600 cursor-pointer">
                    <input type="checkbox" name="remember" class="w-4 h-4 rounded text-blue-600 border-slate-300 focus:ring-blue-500">
                    Ingat saya di perangkat ini
                </label>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full py-3.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-bold shadow-lg shadow-blue-500/20 transition-all duration-200 hover:-translate-y-0.5">
                Masuk Sekarang
            </button>
        </form>

        <div class="border-t border-slate-100 pt-6 text-center">
            <p class="text-xs font-semibold text-slate-500">
                Belum punya akun? 
                <a href="{{ route('register') }}" class="text-blue-600 hover:underline">Daftar Akun Baru</a>
            </p>
        </div>

        <!-- Seeder Quick Login Hint -->
        <div class="bg-blue-50/70 border border-blue-100 p-4 rounded-2xl space-y-2">
            <p class="text-[10px] font-extrabold text-blue-800 uppercase tracking-widest flex items-center gap-1.5">
                <i data-lucide="info" class="w-3.5 h-3.5"></i> Informasi Akun Uji Coba:
            </p>
            <div class="grid grid-cols-2 gap-2 text-[10px] font-semibold text-slate-600">
                <div>
                    <span class="block font-bold text-slate-700">Akun Admin:</span>
                    admin@eventhub.com / password
                </div>
                <div>
                    <span class="block font-bold text-slate-700">Akun User/Customer:</span>
                    user@eventhub.com / password
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
