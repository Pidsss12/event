@extends('layouts.dashboard')

@section('title', 'Top‑Up Saldo - EventHub')
@section('header_title', 'Top‑Up Saldo')

@section('styles')
<style>
    .topup-wrap {
        max-width: 620px;
        margin: 0 auto;
    }

    .topup-header {
        background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 60%, #a78bfa 100%);
        border-radius: 24px;
        padding: 28px 32px;
        color: white;
        position: relative;
        overflow: hidden;
        margin-bottom: 24px;
        text-align: center;
    }
    .topup-header::before {
        content: '';
        position: absolute;
        top: -40px; right: -40px;
        width: 160px; height: 160px;
        background: rgba(255,255,255,0.08);
        border-radius: 50%;
    }
    .topup-header::after {
        content: '';
        position: absolute;
        bottom: -50px; left: -20px;
        width: 140px; height: 140px;
        background: rgba(255,255,255,0.06);
        border-radius: 50%;
    }
    .amount-display {
        font-size: 42px;
        font-weight: 900;
        letter-spacing: -1px;
        font-family: 'Outfit', sans-serif;
    }

    .form-card {
        background: white;
        border-radius: 24px;
        border: 1px solid #f1f5f9;
        box-shadow: 0 8px 32px rgba(0,0,0,0.06);
        padding: 28px;
    }

    .section-title {
        font-size: 13px;
        font-weight: 700;
        color: #475569;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* Payment method grid */
    .payment-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 10px;
        margin-bottom: 24px;
    }
    .pm-option {
        display: none;
    }
    .pm-label {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 12px 8px;
        border-radius: 14px;
        border: 2px solid #e2e8f0;
        cursor: pointer;
        transition: all 0.18s;
        background: #f8fafc;
        text-align: center;
    }
    .pm-label:hover {
        border-color: #818cf8;
        background: #f5f3ff;
    }
    .pm-option:checked + .pm-label {
        border-color: #6366f1;
        background: #eef2ff;
        box-shadow: 0 0 0 3px rgba(99,102,241,0.15);
    }
    .pm-icon {
        font-size: 20px;
    }
    .pm-name {
        font-size: 11px;
        font-weight: 700;
        color: #475569;
        line-height: 1.2;
    }
    .pm-option:checked + .pm-label .pm-name {
        color: #6366f1;
    }

    /* File upload */
    .upload-area {
        border: 2px dashed #e2e8f0;
        border-radius: 16px;
        padding: 24px;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s;
        background: #f8fafc;
        position: relative;
    }
    .upload-area:hover { border-color: #818cf8; background: #f5f3ff; }
    .upload-area input[type="file"] {
        position: absolute; inset: 0;
        opacity: 0; cursor: pointer; width: 100%; height: 100%;
    }

    .btn-submit {
        width: 100%;
        padding: 16px;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        color: white;
        border: none;
        border-radius: 16px;
        font-size: 15px;
        font-weight: 800;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        box-shadow: 0 8px 20px rgba(99,102,241,0.35);
        transition: all 0.2s;
        margin-top: 20px;
    }
    .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 12px 28px rgba(99,102,241,0.45); }

    .btn-cancel {
        width: 100%;
        padding: 13px;
        background: white;
        color: #64748b;
        border: 1.5px solid #e2e8f0;
        border-radius: 14px;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        margin-top: 10px;
        transition: all 0.18s;
        text-decoration: none;
    }
    .btn-cancel:hover { background: #f8fafc; border-color: #cbd5e1; }

    .info-note {
        display: flex;
        align-items: flex-start;
        gap: 8px;
        padding: 12px 14px;
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        border-radius: 12px;
        font-size: 12px;
        color: #1d4ed8;
        margin-top: 16px;
    }
    .divider {
        border: none;
        border-top: 1px solid #f1f5f9;
        margin: 20px 0;
    }
</style>
@endsection

@section('content')
<div class="topup-wrap">

    {{-- Header --}}
    <div class="topup-header">
        <div style="position:relative; z-index:1;">
            <div style="width:56px; height:56px; background:rgba(255,255,255,0.2); border-radius:18px; display:flex; align-items:center; justify-content:center; margin:0 auto 16px;">
                <i data-lucide="wallet" style="width:28px;height:28px;color:white;"></i>
            </div>
            <p style="font-size:12px; font-weight:700; text-transform:uppercase; letter-spacing:0.1em; opacity:0.75; margin-bottom:8px;">Top‑Up Saldo</p>
            <div class="amount-display">Rp{{ number_format($amount, 0, ',', '.') }}</div>
            <p style="font-size:13px; opacity:0.8; margin-top:8px;">Pilih metode pembayaran dan unggah bukti transfer</p>
        </div>
    </div>

    {{-- Form --}}
    <div class="form-card">
        <form action="{{ route('dashboard.topup.process') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="amount" value="{{ $amount }}">

            {{-- Payment Method --}}
            <p class="section-title">
                <i data-lucide="credit-card" style="width:16px;height:16px;color:#6366f1;"></i>
                Pilih Metode Pembayaran
            </p>
            <div class="payment-grid">
                @php
                $methods = [
                    ['value'=>'bank', 'icon'=>'🏦', 'label'=>'Bank Transfer'],
                    ['value'=>'gopay', 'icon'=>'💚', 'label'=>'GoPay'],
                    ['value'=>'ovo', 'icon'=>'💜', 'label'=>'OVO'],
                    ['value'=>'dana', 'icon'=>'💙', 'label'=>'DANA'],
                    ['value'=>'shopeepay', 'icon'=>'🧡', 'label'=>'ShopeePay'],
                    ['value'=>'linkaja', 'icon'=>'❤️', 'label'=>'LinkAja'],
                    ['value'=>'qris', 'icon'=>'📱', 'label'=>'QRIS'],
                    ['value'=>'indomaret', 'icon'=>'🏪', 'label'=>'Indomaret'],
                    ['value'=>'alfamart', 'icon'=>'🏬', 'label'=>'Alfamart'],
                    ['value'=>'credit_card', 'icon'=>'💳', 'label'=>'Kartu Kredit'],
                    ['value'=>'debit_card', 'icon'=>'🏧', 'label'=>'Kartu Debit'],
                    ['value'=>'bri', 'icon'=>'🔵', 'label'=>'BRI Virtual'],
                ];
                @endphp
                @foreach($methods as $m)
                <div>
                    <input type="radio" name="payment_method" id="pm_{{ $m['value'] }}" value="{{ $m['value'] }}" class="pm-option" {{ $loop->first ? 'checked' : '' }}>
                    <label for="pm_{{ $m['value'] }}" class="pm-label">
                        <span class="pm-icon">{{ $m['icon'] }}</span>
                        <span class="pm-name">{{ $m['label'] }}</span>
                    </label>
                </div>
                @endforeach
            </div>

            <hr class="divider">

            {{-- Proof Upload --}}
            <p class="section-title">
                <i data-lucide="image" style="width:16px;height:16px;color:#6366f1;"></i>
                Bukti Pembayaran (PNG / JPG)
            </p>
            <div class="upload-area" id="uploadArea">
                <input type="file" name="proof_image" id="proof_image" accept="image/png, image/jpeg" required onchange="previewFile(this)">
                <div id="uploadPlaceholder">
                    <i data-lucide="upload-cloud" style="width:36px;height:36px;color:#94a3b8;margin:0 auto 10px;display:block;"></i>
                    <p style="font-size:13px; font-weight:700; color:#475569; margin-bottom:4px;">Klik untuk upload foto bukti</p>
                    <p style="font-size:11px; color:#94a3b8;">PNG atau JPG, maksimal 2MB</p>
                </div>
                <img id="previewImg" src="" alt="Preview" style="display:none; max-height:160px; border-radius:10px; margin:0 auto;">
            </div>

            <div class="info-note">
                <i data-lucide="info" style="width:14px;height:14px;flex-shrink:0;margin-top:1px;"></i>
                <span>Setelah mengirim, admin akan meninjau bukti dan menyetujui penambahan saldo Anda. Proses biasanya 1×24 jam.</span>
            </div>

            <button type="submit" class="btn-submit">
                <i data-lucide="send" style="width:18px;height:18px;"></i>
                Kirim Permintaan Top‑Up
            </button>
        </form>

        <a href="{{ route('dashboard') }}" class="btn-cancel">
            <i data-lucide="arrow-left" style="width:16px;height:16px;"></i>
            Kembali ke Dashboard
        </a>
    </div>

</div>
@endsection

@section('scripts')
<script>
function previewFile(input) {
    const file = input.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('uploadPlaceholder').style.display = 'none';
            const img = document.getElementById('previewImg');
            img.src = e.target.result;
            img.style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
}
</script>
@endsection
