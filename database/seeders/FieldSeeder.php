<?php

namespace Database\Seeders;

use App\Models\Field;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $fields = [
            [
                'name' => 'Lapangan 1',
                'price_per_hour' => 150000,
                'description' => 'Lapangan futsal vinyl floor berkualitas dengan lighting yang bagus. Cocok untuk main sore dan malam.',
                'photo' => null, // nanti bisa diisi path foto
                'status' => 'available',
            ],
            [
                'name' => 'Lapangan 2',
                'price_per_hour' => 150000,
                'description' => 'Lapangan futsal vinyl floor dengan AC dan sound system. Nyaman untuk bermain kapan saja.',
                'photo' => null,
                'status' => 'available',
            ],
            [
                'name' => 'Lapangan 3',
                'price_per_hour' => 200000,
                'description' => 'Lapangan futsal premium dengan fasilitas lengkap, AC, lighting LED, dan tribun penonton.',
                'photo' => null,
                'status' => 'available',
            ],
            [
                'name' => 'Lapangan VIP',
                'price_per_hour' => 250000,
                'description' => 'Lapangan VIP dengan rumput sintetis import, full AC, ruang ganti VIP, dan shower. Pengalaman bermain seperti professional.',
                'photo' => null,
                'status' => 'available',
            ],
            [
                'name' => 'Lapangan 5',
                'price_per_hour' => 150000,
                'description' => 'Lapangan futsal standard dengan vinyl floor. Sedang dalam perbaikan.',
                'photo' => null,
                'status' => 'maintenance',
            ],
        ];

        foreach ($fields as $field) {
            Field::create($field);
        }

        echo "✅ Fields seeded successfully!\n";
        echo "   Created " . count($fields) . " fields\n";
    }
}
