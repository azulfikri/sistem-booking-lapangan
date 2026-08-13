<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; margin: 0; padding: 0; background: #f1f5f9; color: #1e293b; }
        .wrapper { max-width: 600px; margin: 0 auto; padding: 24px; }
        .card { background: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.06); }
        .header { background: linear-gradient(135deg, #1449e1, #3380ff); padding: 32px; text-align: center; }
        .header h1 { color: #ffffff; font-size: 22px; margin: 0 0 8px; }
        .header p { color: rgba(255,255,255,0.8); font-size: 14px; margin: 0; }
        .body { padding: 32px; }
        .badge { display: inline-block; padding: 6px 16px; border-radius: 20px; font-size: 13px; font-weight: 600; background: #ecfdf5; color: #059669; }
        .info-row { display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #f1f5f9; }
        .info-label { color: #64748b; font-size: 14px; }
        .info-value { font-weight: 600; font-size: 14px; color: #1e293b; }
        .total-row { display: flex; justify-content: space-between; padding: 16px 0; margin-top: 8px; }
        .total-value { font-size: 20px; font-weight: 700; color: #1449e1; }
        .footer { padding: 24px 32px; text-align: center; border-top: 1px solid #f1f5f9; }
        .footer p { color: #94a3b8; font-size: 12px; margin: 4px 0; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="card">
            {{-- Header --}}
            <div class="header">
                <h1>📋 Konfirmasi Booking</h1>
                <p>Booking Anda telah berhasil dibuat</p>
            </div>

            {{-- Body --}}
            <div class="body">
                <p style="margin: 0 0 8px; font-size: 16px;">Halo, <strong>{{ $booking->customer_name }}</strong>!</p>
                <p style="margin: 0 0 24px; font-size: 14px; color: #64748b;">Berikut detail booking Anda:</p>

                <div style="text-align: center; margin-bottom: 24px;">
                    <p style="color: #64748b; font-size: 13px; margin: 0 0 4px;">Kode Booking</p>
                    <p style="font-size: 28px; font-weight: 800; color: #1449e1; margin: 0; letter-spacing: 3px;">{{ $booking->booking_code }}</p>
                </div>

                <div style="background: #f8fafc; border-radius: 12px; padding: 20px; margin-bottom: 24px;">
                    <div class="info-row">
                        <span class="info-label">Lapangan</span>
                        <span class="info-value">{{ $booking->field->name ?? '-' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Tanggal</span>
                        <span class="info-value">{{ $booking->formatted_date }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Waktu</span>
                        <span class="info-value">{{ $booking->time_range }} ({{ $booking->duration }} jam)</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Metode Bayar</span>
                        <span class="info-value" style="text-transform: capitalize;">{{ $booking->payment_method }}</span>
                    </div>
                    <div class="total-row" style="border-bottom: none;">
                        <span class="info-label" style="font-weight: 600;">Total</span>
                        <span class="total-value">{{ $booking->formatted_price }}</span>
                    </div>
                </div>

                @if($booking->payment_method === 'transfer')
                    <div style="background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 12px; padding: 20px; margin-bottom: 24px;">
                        <p style="font-weight: 600; color: #1e40af; margin: 0 0 8px; font-size: 14px;">💳 Instruksi Transfer:</p>
                        <p style="color: #1e40af; font-size: 13px; margin: 0;">Bank BCA: <strong>1234567890</strong><br>a.n. Sports Center</p>
                    </div>
                @endif

                <p style="font-size: 13px; color: #94a3b8; text-align: center;">Silakan selesaikan pembayaran agar booking Anda dikonfirmasi.</p>
            </div>

            {{-- Footer --}}
            <div class="footer">
                <p><strong>Sports Center</strong></p>
                <p>Jam Operasional: 07:00 — 23:00</p>
            </div>
        </div>
    </div>
</body>
</html>
