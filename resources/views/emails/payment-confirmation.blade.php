<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Berhasil</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .email-container {
            background-color: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #8b5cf6 0%, #ec4899 100%);
            color: white;
            padding: 30px 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .success-icon {
            font-size: 60px;
            margin-bottom: 10px;
        }
        .booking-code {
            background-color: rgba(255,255,255,0.2);
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 28px;
            font-weight: bold;
            letter-spacing: 2px;
            margin-top: 15px;
        }
        .content {
            padding: 30px 20px;
        }
        .status-badge {
            display: inline-block;
            padding: 8px 20px;
            background-color: #10b981;
            color: white;
            border-radius: 20px;
            font-weight: 600;
            margin: 10px 0;
        }
        .detail-section {
            background-color: #f9fafb;
            border-left: 4px solid #8b5cf6;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #e5e7eb;
        }
        .detail-row:last-child {
            border-bottom: none;
        }
        .label {
            color: #6b7280;
            font-weight: 500;
        }
        .value {
            font-weight: 600;
            color: #111827;
        }
        .invoice-section {
            background: linear-gradient(135deg, #faf5ff 0%, #fdf4ff 100%);
            border: 2px solid #d8b4fe;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .invoice-title {
            color: #7c3aed;
            text-align: center;
            margin-top: 0;
        }
        .invoice-total {
            text-align: center;
            margin: 15px 0;
        }
        .invoice-amount {
            font-size: 36px;
            font-weight: bold;
            color: #6d28d9;
        }
        .paid-stamp {
            text-align: center;
            margin: 15px 0;
        }
        .paid-stamp span {
            display: inline-block;
            padding: 5px 30px;
            background-color: #10b981;
            color: white;
            font-size: 20px;
            font-weight: bold;
            border-radius: 5px;
            transform: rotate(-5deg);
        }
        .reminder-box {
            background-color: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .reminder-box h4 {
            margin-top: 0;
            color: #92400e;
        }
        .footer {
            background-color: #f9fafb;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #6b7280;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <div class="success-icon">🎉</div>
            <h1>Pembayaran Berhasil!</h1>
            <div class="booking-code">{{ $booking->booking_code }}</div>
            <div class="status-badge">✓ LUNAS</div>
        </div>

        <!-- Content -->
        <div class="content">
            <p>Halo <strong>{{ $booking->guest_name }}</strong>,</p>
            <p>Pembayaran Anda telah <strong>berhasil dikonfirmasi</strong>! Booking Anda sekarang sudah dikonfirmasi dan siap untuk digunakan.</p>

            <!-- Invoice Section -->
            <div class="invoice-section">
                <h3 class="invoice-title">📄 INVOICE</h3>
                
                <div class="detail-section" style="background-color: white; border-color: #d8b4fe;">
                    <div class="detail-row">
                        <span class="label">Lapangan</span>
                        <span class="value">{{ $booking->field->name }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="label">Tanggal</span>
                        <span class="value">{{ \Carbon\Carbon::parse($booking->booking_date)->isoFormat('dddd, D MMMM YYYY') }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="label">Waktu</span>
                        <span class="value">{{ substr($booking->start_time, 0, 5) }} - {{ substr($booking->end_time, 0, 5) }} WIB</span>
                    </div>
                    <div class="detail-row">
                        <span class="label">Durasi</span>
                        <span class="value">{{ $booking->duration }} Jam</span>
                    </div>
                    @if($booking->midtrans_payment_type)
                    <div class="detail-row">
                        <span class="label">Metode Pembayaran</span>
                        <span class="value">{{ ucwords(str_replace('_', ' ', $booking->midtrans_payment_type)) }}</span>
                    </div>
                    @endif
                </div>

                <div class="invoice-total">
                    <div style="color: #6b7280; font-size: 14px; margin-bottom: 5px;">Total Dibayar</div>
                    <div class="invoice-amount">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</div>
                </div>

                <div class="paid-stamp">
                    <span>PAID</span>
                </div>
            </div>

            <!-- Reminder -->
            <div class="reminder-box">
                <h4>📌 Pengingat Penting:</h4>
                <ul style="margin: 5px 0; padding-left: 20px;">
                    <li>Harap datang <strong>15 menit sebelum</strong> waktu booking Anda</li>
                    <li>Bawa bukti booking ini (kode booking: <strong>{{ $booking->booking_code }}</strong>)</li>
                    <li>Jangan lupa membawa perlengkapan olahraga Anda</li>
                </ul>
            </div>

            <p style="margin-top: 30px;">Terima kasih atas kepercayaan Anda. Kami menantikan kedatangan Anda!</p>
            <p>Selamat bermain! ⚽<br><strong>Tim Lapangan Futsal</strong></p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Email ini dikirim secara otomatis, mohon tidak membalas email ini.</p>
            <p>Jika ada pertanyaan, hubungi kami di support@lapanganfutsal.com</p>
            <p>&copy; {{ date('Y') }} Sistem Booking Lapangan Futsal. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
