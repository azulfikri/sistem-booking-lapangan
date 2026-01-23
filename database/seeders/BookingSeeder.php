<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Field;
use App\Models\Booking;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // Get fields & users
        $field1 = Field::query()->where('name', 'Lapangan 1')->firstOrFail();
        $field2 = Field::query()->where('name', 'Lapangan 2')->firstOrFail();
        $field3 = Field::query()->where('name', 'Lapangan 3')->firstOrFail();

        $customer1 = User::query()->where('email', 'budi@example.com')->firstOrFail();
        $customer2 = User::query()->where('email', 'andi@example.com')->firstOrFail();

        $bookings = [
            // BOOKING 1: Guest booking - Confirmed & Paid
            [
                'field_id' => $field1->id,
                'user_id' => null, // GUEST
                'booking_date' => today(),
                'start_time' => '16:00:00',
                'end_time' => '18:00:00',
                'duration' => 2,
                'guest_name' => 'Rahmat Hidayat',
                'guest_phone' => '081298765432',
                'guest_email' => 'rahmat@example.com',
                'total_price' => 300000,
                'payment_method' => 'transfer',
                'payment_status' => 'paid',
                'booking_status' => 'confirmed',
                'notes' => 'Booking untuk turnamen internal perusahaan',
                'payment_proof' => null,
            ],

            // BOOKING 2: Registered user booking - Confirmed & Paid
            [
                'field_id' => $field2->id,
                'user_id' => $customer1->id, // REGISTERED USER
                'booking_date' => today(),
                'start_time' => '19:00:00',
                'end_time' => '21:00:00',
                'duration' => 2,
                'guest_name' => $customer1->name,
                'guest_phone' => $customer1->phone,
                'guest_email' => $customer1->email,
                'total_price' => 300000,
                'payment_method' => 'transfer',
                'payment_status' => 'paid',
                'booking_status' => 'confirmed',
                'notes' => null,
                'payment_proof' => null,
            ],

            // BOOKING 3: Guest booking - Pending payment verification
            [
                'field_id' => $field3->id,
                'user_id' => null, // GUEST
                'booking_date' => today()->addDay(),
                'start_time' => '08:00:00',
                'end_time' => '10:00:00',
                'duration' => 2,
                'guest_name' => 'Dedi Supardi',
                'guest_phone' => '081299887766',
                'guest_email' => 'dedi@example.com',
                'total_price' => 400000,
                'payment_method' => 'transfer',
                'payment_status' => 'pending',
                'booking_status' => 'pending',
                'notes' => 'Mohon konfirmasi cepat ya',
                'payment_proof' => null,
            ],

            // BOOKING 4: Registered user - Unpaid (baru booking, belum bayar)
            [
                'field_id' => $field1->id,
                'user_id' => $customer2->id, // REGISTERED USER
                'booking_date' => today()->addDays(2),
                'start_time' => '16:00:00',
                'end_time' => '17:00:00',
                'duration' => 1,
                'guest_name' => $customer2->name,
                'guest_phone' => $customer2->phone,
                'guest_email' => $customer2->email,
                'total_price' => 150000,
                'payment_method' => 'transfer',
                'payment_status' => 'unpaid',
                'booking_status' => 'pending',
                'notes' => null,
                'payment_proof' => null,
            ],

            // BOOKING 5: Guest booking - Cancelled
            [
                'field_id' => $field2->id,
                'user_id' => null, // GUEST
                'booking_date' => today()->subDay(),
                'start_time' => '14:00:00',
                'end_time' => '16:00:00',
                'duration' => 2,
                'guest_name' => 'Agus Salim',
                'guest_phone' => '081277665544',
                'guest_email' => 'agus@example.com',
                'total_price' => 300000,
                'payment_method' => 'transfer',
                'payment_status' => 'failed',
                'booking_status' => 'cancelled',
                'notes' => 'Dibatalkan karena hujan',
                'payment_proof' => null,
            ],

            // BOOKING 6: Guest booking - Completed (sudah selesai main)
            [
                'field_id' => $field1->id,
                'user_id' => null, // GUEST
                'booking_date' => today()->subDays(3),
                'start_time' => '19:00:00',
                'end_time' => '21:00:00',
                'duration' => 2,
                'guest_name' => 'Farhan Ahmad',
                'guest_phone' => '081266554433',
                'guest_email' => 'farhan@example.com',
                'total_price' => 300000,
                'payment_method' => 'cash',
                'payment_status' => 'paid',
                'booking_status' => 'completed',
                'notes' => 'Pembayaran cash di tempat',
                'payment_proof' => null,
            ],

            // BOOKING 7: Guest booking - Expired (lewat deadline bayar)
            [
                'field_id' => $field3->id,
                'user_id' => null, // GUEST
                'booking_date' => today()->addDay(),
                'start_time' => '10:00:00',
                'end_time' => '12:00:00',
                'duration' => 2,
                'guest_name' => 'Rudi Tabuti',
                'guest_phone' => '081255443322',
                'guest_email' => 'rudi@example.com',
                'total_price' => 400000,
                'payment_method' => 'transfer',
                'payment_status' => 'expired',
                'booking_status' => 'cancelled',
                'notes' => 'Auto cancelled - tidak upload bukti bayar',
                'payment_proof' => null,
            ],

            // BOOKING 8: Future booking - Confirmed
            [
                'field_id' => $field2->id,
                'user_id' => $customer1->id,
                'booking_date' => today()->addDays(5),
                'start_time' => '18:00:00',
                'end_time' => '20:00:00',
                'duration' => 2,
                'guest_name' => $customer1->name,
                'guest_phone' => $customer1->phone,
                'guest_email' => $customer1->email,
                'total_price' => 300000,
                'payment_method' => 'transfer',
                'payment_status' => 'paid',
                'booking_status' => 'confirmed',
                'notes' => 'Booking untuk minggu depan',
                'payment_proof' => null,
            ],
        ];

        foreach ($bookings as $booking) {
            Booking::create($booking);
        }

        echo "✅ Bookings seeded successfully!\n";
        echo "   Created " . count($bookings) . " bookings\n";
        echo "   - Guest bookings: 6\n";
        echo "   - Registered user bookings: 2\n";
        echo "   - Status variations: confirmed, pending, cancelled, completed, expired\n";
    }
}
