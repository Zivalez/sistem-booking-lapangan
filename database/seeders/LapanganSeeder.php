<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Lapangan;

class LapanganSeeder extends Seeder
{
    public function run(): void
    {
        $lapangans = [
            [
                'nama_lapangan' => 'Lapangan Futsal A',
                'jenis' => 'Futsal',
                'harga_per_jam' => 150000,
                'foto' => null,
            ],
            [
                'nama_lapangan' => 'Lapangan Badminton 1',
                'jenis' => 'Badminton',
                'harga_per_jam' => 80000,
                'foto' => null,
            ],
            [
                'nama_lapangan' => 'Lapangan Basket A',
                'jenis' => 'Basket',
                'harga_per_jam' => 120000,
                'foto' => null,
            ],
        ];

        foreach ($lapangans as $lapangan) {
            Lapangan::create($lapangan);
        }
    }
}