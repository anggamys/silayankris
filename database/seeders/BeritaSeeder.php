<?php

namespace Database\Seeders;

use App\Models\Berita;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BeritaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'judul' => 'Kegiatan Pelayanan Minggu Sekolah',
                'isi' => 'Ini adalah informasi mengenai kegiatan pelayanan minggu sekolah.',
            ],
            [
                'judul' => 'Ibadah Pemuda Remaja',
                'isi' => 'Informasi lengkap tentang agenda ibadah pemuda remaja.',
            ],
            [
                'judul' => 'Bakti Sosial Gereja di Daerah Pelosok',
                'isi' => 'Kegiatan bakti sosial dilakukan di daerah pelosok untuk membantu masyarakat.',
            ],
            [
                'judul' => 'Persiapan Natal Bersama',
                'isi' => 'Rapat koordinasi untuk persiapan acara perayaan Natal bersama seluruh jemaat.',
            ],
            [
                'judul' => 'Retreat Remaja dan Pemuda',
                'isi' => 'Retreat tahunan untuk pembinaan rohani remaja dan pemuda telah dibuka.',
            ],
            [
                'judul' => 'Pelatihan Musik Gereja',
                'isi' => 'Pelatihan musik untuk pemusik gereja akan dilaksanakan minggu depan.',
            ],
            [
                'judul' => 'Penggalangan Dana Renovasi Gereja',
                'isi' => 'Gereja sedang menggalang dana untuk renovasi bangunan utama.',
            ],
            [
                'judul' => 'Kunjungan Pelayanan ke Panti Asuhan',
                'isi' => 'Jemaat akan melakukan kunjungan pelayanan ke panti asuhan Gloria.',
            ],
            [
                'judul' => 'Ibadah Padang Bersama',
                'isi' => 'Ibadah padang bersama akan diadakan di lapangan kota pada hari Minggu.',
            ],
            [
                'judul' => 'Pembinaan Guru Sekolah Minggu',
                'isi' => 'Program pembinaan untuk guru sekolah minggu telah dimulai.',
            ],
            [
                'judul' => 'Perayaan Hari Paskah',
                'isi' => 'Rangkaian acara untuk perayaan Paskah akan dimulai bulan depan.',
            ],
            [
                'judul' => 'Doa Malam Bersama Jemaat',
                'isi' => 'Doa malam rutin akan diadakan setiap Jumat di ruang ibadah kecil.',
            ],
            [
                'judul' => 'Pelayanan Kunjungan Rumah',
                'isi' => 'Tim pelayanan akan melakukan kunjungan rumah bagi jemaat yang sakit.',
            ],
            [
                'judul' => 'Kelas Katekisasi Jemaat Baru',
                'isi' => 'Kelas katekisasi untuk jemaat baru akan dimulai minggu ini.',
            ],
            [
                'judul' => 'Pelatihan Multimedia Gereja',
                'isi' => 'Divisi multimedia membuka kelas pelatihan untuk operator presentasi.',
            ],
        ];

        foreach ($data as $item) {
            Berita::create([
                'user_id' => User::first()->id,
                'judul' => $item['judul'],
                'slug' => Str::slug($item['judul']) . '-' . strtolower(Str::random(5)),
                'isi' => $item['isi'],
                'status' => 'aktif',
                'gambar_path' => null,
            ]);
        }
    }
}
