<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tiket EventHub - {{ $booking->booking_code }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .ticket-container {
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            overflow: hidden;
            width: 100%;
        }
        .header {
            background-color: #1e3a8a;
            color: #fff;
            padding: 15px 20px;
            text-align: left;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            letter-spacing: 1px;
        }
        .header span {
            font-size: 12px;
            color: #bfdbfe;
        }
        .content {
            padding: 20px;
        }
        .row {
            width: 100%;
            margin-bottom: 20px;
        }
        .col-left {
            width: 35%;
            float: left;
        }
        .col-right {
            width: 60%;
            float: right;
        }
        .clear {
            clear: both;
        }
        .banner {
            width: 100%;
            border-radius: 8px;
            max-height: 150px;
            object-fit: cover;
        }
        .event-title {
            font-size: 22px;
            font-weight: bold;
            margin: 0 0 10px 0;
            color: #0f172a;
        }
        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #f8fafc;
        }
        .details-table th, .details-table td {
            padding: 12px;
            border: 1px solid #e2e8f0;
            text-align: left;
        }
        .details-table th {
            font-size: 11px;
            text-transform: uppercase;
            color: #64748b;
            width: 25%;
        }
        .details-table td {
            font-size: 14px;
            font-weight: bold;
            color: #1e293b;
        }
        .user-info {
            margin-top: 20px;
            border-top: 2px dashed #cbd5e1;
            padding-top: 20px;
        }
        .user-info table {
            width: 100%;
        }
        .barcode-section {
            margin-top: 30px;
            text-align: center;
            border-top: 2px solid #e2e8f0;
            padding-top: 20px;
        }
        .booking-code {
            font-size: 28px;
            font-weight: bold;
            letter-spacing: 5px;
            color: #0f172a;
            margin-bottom: 5px;
        }
        .footer-note {
            font-size: 10px;
            color: #94a3b8;
            text-transform: uppercase;
        }
    </style>
</head>
<body>

<div class="ticket-container">
    <div class="header">
        <h1>EventHub</h1>
        <span>E-TICKET RESMI</span>
    </div>
    
    <div class="content">
        <div class="row">
            <div class="col-left">
                @if($bannerSrc)
                    <img src="{{ $bannerSrc }}" class="banner" alt="Event Banner">
                @endif
            </div>
            <div class="col-right">
                <p style="margin: 0; color: #2563eb; font-weight: bold; font-size: 12px; text-transform: uppercase;">
                    {{ $booking->event->category->name }}
                </p>
                <h2 class="event-title">{{ $booking->event->title }}</h2>
                <p style="margin: 0; color: #475569; font-size: 14px;">
                    📍 {{ $booking->event->location }}
                </p>
            </div>
            <div class="clear"></div>
        </div>

        <table class="details-table">
            <tr>
                <th>Tanggal</th>
                <td>{{ $booking->event->date_time->translatedFormat('d F Y') }}</td>
                <th>Waktu</th>
                <td>{{ $booking->event->date_time->format('H:i') }} WIB</td>
            </tr>
            <tr>
                <th>Kelas Tiket</th>
                <td style="color: #2563eb;">{{ $booking->ticketType->name }}</td>
                <th>Jumlah</th>
                <td>{{ $booking->quantity }} Orang</td>
            </tr>
        </table>

        <div class="user-info">
            <table>
                <tr>
                    <td style="width: 50%;">
                        <span style="font-size: 11px; color: #64748b; text-transform: uppercase;">Nama Pemegang Tiket</span><br>
                        <strong style="font-size: 14px; color: #1e293b;">{{ $booking->user->name }}</strong><br>
                        <span style="font-size: 12px; color: #64748b;">{{ $booking->user->email }}</span>
                    </td>
                    <td style="width: 50%;">
                        <span style="font-size: 11px; color: #64748b; text-transform: uppercase;">Metode & Waktu Bayar</span><br>
                        <strong style="font-size: 14px; color: #1e293b;">{{ $booking->payment_method ?: 'Wallet EventHub' }}</strong><br>
                        <span style="font-size: 12px; color: #64748b;">{{ $booking->booked_at->translatedFormat('d F Y | H:i') }} WIB</span>
                    </td>
                </tr>
            </table>
        </div>

        <div class="barcode-section">
            <div class="booking-code">{{ $booking->booking_code }}</div>
            <div style="font-family: monospace; font-size: 30px; letter-spacing: -2px; margin-top: 5px;">
                || ||| | ||| || ||| | | || ||| ||
            </div>
            <p class="footer-note">Pindai tiket ini saat memasuki gerbang acara.</p>
        </div>
    </div>
</div>

</body>
</html>
