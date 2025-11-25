<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Gereja;

class GerejaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $gerejas = [
            [
                'nama' => 'Gereja Santo Paulus',
                'alamat' => 'Jl. Melati No. 10, Surabaya',
                'tanggal_berdiri' => '2000-05-15',
                'email' => 'santopaulus@example.com',
                'nomor_telepon' => '031-1234567',
                'nama_pendeta' => 'Pdt. John Doe',
                'tanggal_bergabung_sinode' => '2010-08-20',
                'kel_desa' => 'Melati',
                'kecamatan' => 'Genteng',
                'kab_kota' => 'Surabaya',
                'jarak_gereja_lain' => '5 km dari Gereja Kristus Raja',
                'status_gereja' => 'permanen',
            ],
            [
                'nama' => 'Gereja Kristus Raja',
                'alamat' => 'Jl. Kenanga No. 5, Surabaya',
                'tanggal_berdiri' => '1995-11-30',
                'email' => 'kristusraja@example.com',  
                'nomor_telepon' => '031-7654321',
                'nama_pendeta' => 'Pdt. Jane Smith', 
                'tanggal_bergabung_sinode' => '2005-03-15',
                'kel_desa' => 'Kenanga',
                'kecamatan' => 'Tegalsari', 
                'kab_kota' => 'Surabaya',
                'jarak_gereja_lain' => '3 km dari Gereja Santo Paulus',
                'status_gereja' => 'semi-permanen', 
            ],
            [
                'nama' => 'Gereja Anugerah',
                'alamat' => 'Jl. Anggrek No. 20, Surabaya',
                'tanggal_berdiri' => '2010-02-10',
                'email' => 'anugerah@example.com',
                'nomor_telepon' => '031-2468135',
                'nama_pendeta' => 'Pdt. Michael Johnson',
                'tanggal_bergabung_sinode' => '2015-07-25',
                'kel_desa' => 'Anggrek',
                'kecamatan' => 'Sukolilo',
                'kab_kota' => 'Surabaya',
                'jarak_gereja_lain' => '2 km dari Gereja Santo Paulus',
                'status_gereja' => 'permanen',
            ]
        ];

        foreach ($gerejas as $gereja) {
            Gereja::create($gereja);
        }
    }
}