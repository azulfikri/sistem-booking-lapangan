<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // Create Admin User
        User::create([
            'name' => 'Admin Futsal',
            'email' => 'admin@futsal.com',
            'password' => Hash::make('password'), // password: "password"
            'phone' => '081234567890',
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Create Customer User (untuk testing registered user booking)
        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'password' => Hash::make('password'),
            'phone' => '081234567891',
            'role' => 'customer',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Andi Wijaya',
            'email' => 'andi@example.com',
            'password' => Hash::make('password'),
            'phone' => '081234567892',
            'role' => 'customer',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Siti Nurhaliza',
            'email' => 'siti@example.com',
            'password' => Hash::make('password'),
            'phone' => '081234567893',
            'role' => 'customer',
            'email_verified_at' => now(),
        ]);

        echo "✅ Users seeded successfully!\n";
        echo "   Admin: admin@futsal.com / password\n";
        echo "   Customers: budi@example.com, andi@example.com, siti@example.com / password\n";
    }
}
