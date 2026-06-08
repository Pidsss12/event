@extends('layouts.app')

@section('title', 'Daftar Akun Baru - EventHub')

@section('content')
<div class="py-16 flex items-center justify-center min-h-[70vh]">
    <div class="w-full max-w-md bg-white rounded-3xl border border-slate-100 shadow-xl p-8 space-y-6">
        
        <div class="text-center space-y-2">
            <div class="p-3 bg-blue-50 text-blue-600 rounded-2xl w-fit mx-auto">
                <i data-lucide="user-plus" class="w-6 h-6"></i>
            </div>
            <h2 class="text-2xl font-extrabold text-slate-900">Daftar Akun Baru</h2>
            <p class="text-xs text-slate-500">Mulai menjelajahi event favorit dan memesan tiket digital Anda.</p>
        </div>

        <form action="{{ route('register') }}" method="POST" class="space-y-4">
            @csrf

            <!-- Name -->
            <div class="space-y-1.5">
                <label for="name" class="text-xs font-bold text-slate-700 uppercase tracking-wider">Nama Lengkap</label>
                <div class="relative">
                    <i data-lucide="user" class="absolute left-4 top-3.5 w-4 h-4 text-slate-400"></i>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required autofocus
                        class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition"
                        placeholder="Nama Lengkap Anda">
                </div>
            </div>

            <!-- Email -->
            <div class="space-y-1.5">
                <label for="email" class="text-xs font-bold text-slate-700 uppercase tracking-wider">Alamat Email</label>
                <div class="relative">
                    <i data-lucide="mail" class="absolute left-4 top-3.5 w-4 h-4 text-slate-400"></i>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required
                        class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition"
                        placeholder="nama@email.com">
                </div>
            </div>

            <!-- Password -->
            <div class="space-y-1.5">
                <label for="password" class="text-xs font-bold text-slate-700 uppercase tracking-wider">Password</label>
                <div class="relative">
                    <i data-lucide="lock" class="absolute left-4 top-3.5 w-4 h-4 text-slate-400"></i>
                    <input type="password" name="password" id="password" required
                        class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition"
                        placeholder="Minimal 8 karakter">
                </div>
            </div>

            <!-- Password Confirmation -->
            <div class="space-y-1.5">
                <label for="password_confirmation" class="text-xs font-bold text-slate-700 uppercase tracking-wider">Konfirmasi Password</label>
                <div class="relative">
                    <i data-lucide="lock" class="absolute left-4 top-3.5 w-4 h-4 text-slate-400"></i>
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                        class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition"
                        placeholder="Ulangi password Anda">
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full py-3.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-bold shadow-lg shadow-blue-500/20 transition-all duration-200 hover:-translate-y-0.5">
                Daftar Sekarang
            </button>
        </form>

        <div class="border-t border-slate-100 pt-6 text-center">
            <p class="text-xs font-semibold text-slate-500">
                Sudah punya akun? 
                <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Masuk di sini</a>
            </p>
        </div>

    </div>
</div>
@endsection
