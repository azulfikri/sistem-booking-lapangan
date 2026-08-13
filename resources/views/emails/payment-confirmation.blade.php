<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; margin: 0; padding: 0; background: #f1f5f9; color: #1e293b; }
        .wrapper { max-width: 600px; margin: 0 auto; padding: 24px; }
        .card { background: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.06); }
        .header { background: linear-gradient(135deg, #059669, #10b981); padding: 32px; text-align: center; }
        .header h1 { color: #ffffff; font-size: 22px; margin: 0 0 8px; }
        .header p { color: rgba(255,255,255,0.8); font-size: 14px; margin: 0; }
        .body { padding: 32px; }
        .info-row { display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #f1f5f9; }
        .info-label { color: #64748b; font-size: 14px; }
        .info-value { font-weight: 600; font-size: 14px; color: #1e293b; }
        .footer { padding: 24px 32px; text-align: center; border-top: 1px solid #f1f5f9; }
        .footer p { color: #94a3b8; font-size: 12px; margin: 4px 0; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="card">
            {{-- Header --}}
            <div class="header">
                <h1>✅ Pembayaran Berhasil!</h1>
                <p>Booking Anda sudah dikonfirmasi</p>
            </div>

            {{-- Body --}}
            <div class="body">
                <p style="margin: 0 0 8px; font-size: 16px;">Halo, <strong>{{ $booking->customer_name }}</strong>!</p>
                <p style="margin: 0 0 24px; font-size: 14px; color: #64748b;">Pembayaran untuk booking Anda telah kami terima. Berikut detailnya:</p>

                <div style="text-align: center; margin-bottom: 24px;">
                    <p style="color: #64748b; font-size: 13px; margin: 0 0 4px;">Kode Booking</p>
                    <p style="font-size: 28px; font-weight: 800; color: #059669; margin: 0; letter-spacing: 3px;">{{ $booking->booking_code }}</p>
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
                        <span class="info-label">Status</span>
                        <span style="display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; background: #ecfdf5; color: #059669;">Confirmed</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; padding: 16px 0; border-bottom: none; margin-top: 8px;">
                        <span class="info-label" style="font-weight: 600;">Total Dibayar</span>
                        <span style="font-size: 20px; font-weight: 700; color: #059669;">{{ $booking->formatted_price }}</span>
                    </div>
                </div>

                <div style="background: #ecfdf5; border: 1px solid #a7f3d0; border-radius: 12px; padding: 20px; text-align: center;">
                    <p style="font-weight: 600; color: #065f46; margin: 0 0 4px; font-size: 15px;">🎉 Selamat Bermain!</p>
                    <p style="color: #047857; font-size: 13px; margin: 0;">Silakan datang tepat waktu sesuai jadwal booking Anda.</p>
                </div>
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
