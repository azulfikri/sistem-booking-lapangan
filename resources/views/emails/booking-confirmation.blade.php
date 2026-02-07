<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Booking</title>
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
            background: linear-gradient(135deg, #10b981 0%, #06b6d4 100%);
            color: white;
            padding: 30px 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
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
        .detail-section {
            background-color: #f9fafb;
            border-left: 4px solid #10b981;
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
        .total-section {
            background-color: #ecfdf5;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            text-align: center;
        }
        .total-label {
            color: #059669;
            font-size: 14px;
            margin-bottom: 5px;
        }
        .total-amount {
            color: #065f46;
            font-size: 32px;
            font-weight: bold;
        }
        .payment-instructions {
            background-color: #eff6ff;
            border: 2px solid #3b82f6;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .payment-instructions h3 {
            color: #1e40af;
            margin-top: 0;
        }
        .bank-details {
            background-color: white;
            padding: 15px;
            border-radius: 5px;
            margin-top: 10px;
        }
        .button {
            display: inline-block;
            padding: 12px 30px;
            background-color: #10b981;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: 600;
            margin: 20px 0;
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
            <h1>✅ Booking Berhasil Dibuat!</h1>
            <div class="booking-code">{{ $booking->booking_code }}</div>
        </div>

        <!-- Content -->
        <div class="content">
            <p>Halo <strong>{{ $booking->guest_name }}</strong>,</p>
            <p>Terima kasih telah melakukan booking lapangan futsal. Berikut adalah detail booking Anda:</p>

            <!-- Booking Details -->
            <div class="detail-section">
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
            </div>

            <!-- Total Price -->
            <div class="total-section">
                <div class="total-label">Total Pembayaran</div>
                <div class="total-amount">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</div>
            </div>

            <!-- Payment Instructions -->
            @if($booking->payment_method === 'transfer')
                <div class="payment-instructions">
                    <h3>📋 Instruksi Transfer Bank</h3>
                    <p>Silakan transfer ke rekening berikut:</p>
                    <div class="bank-details">
                        <div class="detail-row">
                            <span class="label">Bank</span>
                            <span class="value">BCA</span>
                        </div>
                        <div class="detail-row">
                            <span class="label">No. Rekening</span>
                            <span class="value">1234567890</span>
                        </div>
                        <div class="detail-row">
                            <span class="label">Atas Nama</span>
                            <span class="value">Lapangan Futsal XYZ</span>
                        </div>
                        <div class="detail-row">
                            <span class="label">Jumlah</span>
                            <span class="value">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    <p style="margin-top: 15px; font-size: 14px;">Setelah transfer, mohon kirim bukti transfer ke WhatsApp atau email kami.</p>
                </div>
            @elseif($booking->payment_method === 'cash')
                <div class="payment-instructions">
                    <h3>💵 Bayar di Tempat</h3>
                    <p>Anda dapat membayar langsung di tempat saat datang.</p>
                    <p><strong>Harap datang 15 menit sebelum waktu booking Anda.</strong></p>
                </div>
            @elseif($booking->payment_method === 'midtrans')
                <div class="payment-instructions">
                    <h3>💳 Pembayaran Online</h3>
                    <p>Klik tombol di bawah untuk melanjutkan pembayaran:</p>
                    <a href="{{ route('payment.process', $booking->booking_code) }}" class="button">Bayar Sekarang</a>
                    <p style="font-size: 14px; margin-top: 10px;">Anda akan diarahkan ke halaman pembayaran Midtrans yang aman.</p>
                </div>
            @endif

            <p style="margin-top: 30px;">Jika ada pertanyaan, jangan ragu untuk menghubungi kami.</p>
            <p>Terima kasih,<br><strong>Tim Lapangan Futsal</strong></p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Email ini dikirim secara otomatis, mohon tidak membalas email ini.</p>
            <p>&copy; {{ date('Y') }} Sistem Booking Lapangan Futsal. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
