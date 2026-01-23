<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Field;
use App\Models\Booking;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    // use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        // Jalankan seeder secara berurutan
        $this->call([
            UserSeeder::class,
            FieldSeeder::class,
            BookingSeeder::class,
        ]);

        echo "\n";
        echo "🎉 Database seeded successfully!\n";
        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
        echo "📊 Summary:\n";
        echo "   Users: " . User::query()->count() . "\n";
        echo "   Fields: " . Field::query()->count() . "\n";
        echo "   Bookings: " . Booking::query()->count() . "\n";
        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
        echo "🔐 Login Credentials:\n";
        echo "   Admin: admin@futsal.com / password\n";
        echo "   Customer: budi@example.com / password\n";
        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    }
}
