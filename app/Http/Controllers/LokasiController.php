<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LokasiController extends Controller
{
private $data = [
    'Surabaya' => [

        // 1. Asemrowo
        'Asemrowo' => [
            'Asemrowo',
            'Genting Kalianak',
            'Tambak Sarioso'
        ],

        // 2. Benowo
        'Benowo' => [
            'Kandangan',
            'Romokalisari',
            'Sememi',
            'Tambak Osowilangun'
        ],

        // 3. Bubutan
        'Bubutan' => [
            'Alun-Alun Contong',
            'Bubutan',
            'Gundih',
            'Jepara',
            'Tembok Dukuh'
        ],

        // 4. Bulak
        'Bulak' => [
            'Bulak',
            'Kedung Cowek',
            'Kenjeran',
            'Sukolilo Baru'
        ],

        // 5. Dukuh Pakis
        'Dukuh Pakis' => [
            'Dukuh Kupang',
            'Dukuh Pakis',
            'Gunung Sari',
            'Pradah Kalikendal'
        ],

        // 6. Gayungan
        'Gayungan' => [
            'Dukuh Menanggal',
            'Gayungan',
            'Ketintang',
            'Menanggal'
        ],

        // 7. Genteng
        'Genteng' => [
            'Embong Kaliasin',
            'Genteng',
            'Kapasari',
            'Ketabang',
            'Peneleh'
        ],

                // 8. Gubeng
        'Gubeng' => [
            'Airlangga',
            'Baratajaya',
            'Gubeng',
            'Kertajaya',
            'Mojo',
            'Pucangsewu'
        ],

        // 9. Gunung Anyar
        'Gunung Anyar' => [
            'Gunung Anyar',
            'Gunung Anyar Tambak',
            'Rungkut Menanggal'
        ],

        // 10. Jambangan
        'Jambangan' => [
            'Jambangan',
            'Karah',
            'Kebonsari',
            'Pagesangan'
        ],

        // 11. Karang Pilang
        'Karang Pilang' => [
            'Karang Pilang',
            'Kebraon',
            'Kedurus',
            'Warugunung'
        ],

        // 12. Kenjeran
        'Kenjeran' => [
            'Bulak Banteng',
            'Sidotopo Wetan',
            'Tanah Kali Kedinding'
        ],

                // 13. Krembangan
        'Krembangan' => [
            'Krembangan Selatan',
            'Krembangan Utara',
            'Morokrembangan',
            'Perak Barat',
            'Perak Timur'
        ],

        // 14. Lakarsantri
        'Lakarsantri' => [
            'Bangkingan',
            'Jeruk',
            'Lakarsantri',
            'Lidah Kulon',
            'Lidah Wetan',
            'Sumur Welut'
        ],

        // 15. Mulyorejo
        'Mulyorejo' => [
            'Kalijudan',
            'Kalisari',
            'Kedung Cowek',
            'Mulyorejo',
            'Manyar Sabrangan'
        ],

        // 16. Pabean Cantikan
        'Pabean Cantikan' => [
            'Bongkaran',
            'Krembangan Selatan',
            'Nyamplungan',
            'Perak Utara'
        ],

        // 17. Pakal
        'Pakal' => [
            'Babat Jerawat',
            'Karang Pilang (Pakal)',
            'Pakal',
            'Sumber Rejo'
        ],

                // 18. Rungkut
        'Rungkut' => [
            'Kedung Baruk',
            'Medokan Ayu',
            'Pendem',
            'Rungkut Kidul',
            'Rungkut Menanggal'
        ],

        // 19. Sambikerep
        'Sambikerep' => [
            'Bringin',
            'Made',
            'Sambikerep'
        ],

        // 20. Sawahan
        'Sawahan' => [
            'Kupang Krajan',
            'Pakis',
            'Patemon',
            'Sawahan',
            'Tanjungsari'
        ],

        // 21. Semampir
        'Semampir' => [
            'Ampel',
            'Pegirian',
            'Sidotopo',
            'Ujung',
            'Wonokusumo'
        ],

        // 22. Simokerto
        'Simokerto' => [
            'Kapasan',
            'Sidodadi',
            'Simokerto',
            'Tambakrejo'
        ],

                // 23. Sukolilo
        'Sukolilo' => [
            'Gebang Putih',
            'Keputih',
            'Klampis Ngasem',
            'Medokan Semampir',
            'Nginden Jangkungan',
            'Semolowaru'
        ],

        // 24. Sukomanunggal
        'Sukomanunggal' => [
            'Putat Jaya',
            'Sawunggaling',
            'Simomulyo',
            'Simomulyo Baru',
            'Sukomanunggal'
        ],

        // 25. Tambaksari
        'Tambaksari' => [
            'Gading',
            'Kapasmadya Baru',
            'Pacar Keling',
            'Pacar Kembang',
            'Ploso',
            'Rangkah',
            'Tambaksari'
        ],

        // 26. Tandes
        'Tandes' => [
            'Balongsari',
            'Banjar Sugihan',
            'Manukan Kulon',
            'Manukan Wetan',
            'Tandes'
        ],

        // 27. Tegalsari
        'Tegalsari' => [
            'Dr. Soetomo',
            'Kedungdoro',
            'Keputran',
            'Tegalsari',
            'Wonorejo'
        ],

                // 28. Wiyung
        'Wiyung' => [
            'Balasklumprik',
            'Jajar Tunggal',
            'Wiyung'
        ],

        // 29. Wonocolo
        'Wonocolo' => [
            'Bendul Merisi',
            'Jemur Wonosari',
            'Margorejo',
            'Sidosermo',
            'Siwalankerto'
        ],

        // 30. Wonokromo
        'Wonokromo' => [
            'Darmo',
            'Jagir',
            'Ngagel',
            'Ngagelrejo',
            'Sawunggaling',
            'Wonokromo'
        ]
    ]
];


    public function getKecamatan(Request $request)
    {
        $kota = $request->kota;

        if(isset($this->data[$kota])) {
            return response()->json(array_keys($this->data[$kota]));
        }

        return response()->json([]);
    }

    public function getKelurahan(Request $request)
    {
        $kota = $request->kota;
        $kecamatan = $request->kecamatan;

        if(isset($this->data[$kota][$kecamatan])) {
            return response()->json($this->data[$kota][$kecamatan]);
        }

        return response()->json([]);
    }
}
