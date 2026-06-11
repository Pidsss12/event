@extends('layouts.app')

@section('title', 'Daftar Akun Baru - EventHub')

@section('styles')
<style>
    .auth-container {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 80vh;
        padding: 40px 20px;
    }

    .auth-card {
        background: white;
        border-radius: 32px;
        box-shadow: 0 20px 50px rgba(30, 58, 138, 0.08);
        border: 1px solid rgba(226, 232, 240, 0.8);
        overflow: hidden;
        width: 100%;
        max-width: 900px;
        display: grid;
        grid-template-columns: 1fr;
    }

    @media (min-width: 768px) {
        .auth-card {
            grid-template-columns: 1.1fr 1fr;
        }
    }

    /* Left Side: Visual Branding */
    .auth-sidebar {
        background-image: linear-gradient(135deg, rgba(15, 23, 42, 0.9) 0%, rgba(30, 58, 138, 0.8) 50%, rgba(99, 102, 241, 0.75) 100%), 
                          url('https://images.unsplash.com/photo-1511578314322-379afb476865?q=80&w=800&auto=format&fit=crop');
        background-size: cover;
        background-position: center;
        color: white;
        padding: 48px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        position: relative;
    }

    .sidebar-logo {
        display: flex;
        align-items: center;
        gap: 12px;
        font-family: 'Outfit', sans-serif;
        font-size: 20px;
        font-weight: 800;
        letter-spacing: 0.5px;
    }

    .sidebar-logo img {
        width: 36px;
        height: auto;
        filter: brightness(0) invert(1);
    }

    .sidebar-footer {
        margin-top: 80px;
    }

    /* Right Side: Form */
    .auth-form-side {
        padding: 48px 40px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .form-label {
        font-size: 11px;
        font-weight: 800;
        color: #475569;
        text-transform: uppercase;
        letter-spacing: 0.08em;
    }

    .input-wrapper {
        position: relative;
    }

    .input-icon {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        width: 18px;
        height: 18px;
        color: #94a3b8;
        transition: color 0.2s;
    }

    .form-input {
        width: 100%;
        padding: 12px 16px 12px 46px;
        background: #f8fafc;
        border: 1.5px solid #e2e8f0;
        border-radius: 14px;
        font-size: 14px;
        font-weight: 600;
        color: #0f172a;
        transition: all 0.2s;
    }

    .form-input:focus {
        background: white;
        border-color: #2563eb;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
        outline: none;
    }

    .form-input:focus + .input-icon {
        color: #2563eb;
    }

    .btn-submit {
        width: 100%;
        padding: 14px;
        background: linear-gradient(135deg, #2563eb, #6366f1);
        color: white;
        border: none;
        border-radius: 14px;
        font-size: 14px;
        font-weight: 800;
        cursor: pointer;
        box-shadow: 0 4px 14px rgba(37, 99, 235, 0.25);
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-submit:hover {
        box-shadow: 0 6px 20px rgba(37, 99, 235, 0.35);
        transform: translateY(-1px);
    }
</style>
@endsection

@section('content')
<div class="auth-container">
    <div class="auth-card">
        
        <!-- Left Side: Visual Side (Hidden on Mobile) -->
        <div class="auth-sidebar hidden md:flex">
            <div class="sidebar-logo">
                <img src="{{ asset('IMG/EventHub.logo.png') }}" alt="EventHub Logo">
                <span>EventHub</span>
            </div>
            
            <div class="sidebar-footer">
                <h3 style="font-family:'Outfit',sans-serif; font-size:24px; font-weight:800; line-height:1.3; margin-bottom:12px;">Mulai Petualangan Event Anda</h3>
                <p style="font-size:13px; opacity:0.85; line-height:1.6; font-weight:500;">Daftarkan akun baru Anda sekarang untuk mempermudah pembelian tiket digital, isi saldo instan, dan jelajahi ribuan aktivitas seru.</p>
            </div>
        </div>

        <!-- Right Side: Form Side -->
        <div class="auth-form-side">
            <div style="margin-bottom:28px;">
                <div style="width:44px; height:44px; background:#eff6ff; border-radius:12px; display:flex; align-items:center; justify-content:center; margin-bottom:16px;">
                    <i data-lucide="user-plus" style="width:20px;height:20px;color:#2563eb;"></i>
                </div>
                <h2 style="font-size:22px; font-weight:900; color:#0f172a; font-family:'Outfit',sans-serif;">Daftar Akun Baru</h2>
                <p style="font-size:12.5px; color:#64748b; margin-top:4px;">Silakan lengkapi formulir pendaftaran.</p>
            </div>

            <form action="{{ route('register') }}" method="POST" class="space-y-4">
                @csrf

                <!-- Nama Lengkap -->
                <div class="form-group">
                    <label for="name" class="form-label">Nama Lengkap</label>
                    <div class="input-wrapper">
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required autofocus class="form-input" placeholder="Nama Lengkap Anda">
                        <i data-lucide="user" class="input-icon"></i>
                    </div>
                </div>

                <!-- Email -->
                <div class="form-group">
                    <label for="email" class="form-label">Alamat Email</label>
                    <div class="input-wrapper">
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required class="form-input" placeholder="nama@email.com">
                        <i data-lucide="mail" class="input-icon"></i>
                    </div>
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-wrapper">
                        <input type="password" name="password" id="password" required class="form-input" placeholder="Minimal 8 karakter">
                        <i data-lucide="lock" class="input-icon"></i>
                    </div>
                </div>

                <!-- Konfirmasi Password -->
                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                    <div class="input-wrapper">
                        <input type="password" name="password_confirmation" id="password_confirmation" required class="form-input" placeholder="Ulangi password Anda">
                        <i data-lucide="lock" class="input-icon"></i>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn-submit" style="margin-top:20px;">
                    Daftar Sekarang
                    <i data-lucide="arrow-right" style="width:16px;height:16px;"></i>
                </button>
            </form>

            <div style="margin-top:28px; text-align:center; border-top:1px solid #f1f5f9; padding-top:20px;">
                <p style="font-size:12.5px; font-weight:700; color:#64748b;">
                    Sudah punya akun? 
                    <a href="{{ route('login') }}" style="color:#2563eb; text-decoration:none;">Masuk di sini</a>
                </p>
            </div>

        </div>
    </div>
</div>
@endsection
