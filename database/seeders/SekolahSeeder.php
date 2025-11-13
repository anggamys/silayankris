<?php

namespace Database\Seeders;

use App\Models\Sekolah;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SekolahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sekolahs = [
            [
                'nama' => 'SILAYANKRIS SD',
                'alamat' => 'Jl. Pendidikan No. 1',
            ],
            [
                'nama' => 'SILAYANKRIS SMP',
                'alamat' => 'Jl. Pendidikan No. 2',
            ],
            [
                'nama' => 'SILAYANKRIS SMA',
                'alamat' => 'Jl. Pendidikan No. 3',
            ],
        ];

        foreach ($sekolahs as $sekolah) {
            Sekolah::create($sekolah);
        }
    }
}
