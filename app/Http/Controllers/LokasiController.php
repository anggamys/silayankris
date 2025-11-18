<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LokasiController extends Controller
{
private $data = [
    'Surabaya' => [

        // 1. Asemrowo
        'Asem Rowo' => [
            'Asem Rowo',
            'Genting Kalianak',
            'Tambak Sarioso'
        ],

        // 2. Benowo
        'Benowo' => [
            'Kandangan',
            'Romokalisari',
            'Sememi',
            'Tambak Oso Wilangun'
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
            'Pucang sewu'
        ],

        // 9. Gunung Anyar
        'Gunung Anyar' => [
            'Gunung Anyar',
            'Gunung Anyar Tambak',
            'Rungkut Menanggal',
            'Rungkut Tengah'
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
            'Waru Gunung'
        ],

        // 12. Kenjeran
        'Kenjeran' => [
            'Bulak Banteng',
            'Sidotopo Wetan',
            'Tambak Wedi',
            'Tanah Kali Kedinding'
        ],

        // 13. Krembangan
        'Krembangan' => [
            'Dupak',
            'Kemayoran',
            'Krembangan Selatan',
            'Morokrembangan',
            'Perak Barat',
        ],

        // 14. Lakarsantri
        'Lakarsantri' => [
            'Bangkingan',
            'Jeruk',
            'Lakarsantri',
            'Lidah Kulon',
            'Lidah Wetan',
            'Sumurwelut'
        ],

        // 15. Mulyorejo
        'Mulyorejo' => [
            'Dukuh Sutorejo',
            'Kalijudan',
            'Kalisari',
            'Kejawan Putih Tambak',
            'Manyar Sabrangan',
            'Mulyorejo'
        ],

        // 16. Pabean Cantikan
        'Pabean Cantikan' => [
            'Bongkaran',
            'Krembangan Selatan',
            'Nyamplungan',
            'Tanjung Perak'
        ],

        // 17. Pakal
        'Pakal' => [
            'Babat Jerawat',
            'Benowo',
            'Pakal',
            'Sumber Rejo'
        ],

        // 18. Rungkut
        'Rungkut' => [
            'Kalirungkut',
            'Kedung Baruk',
            'Medokan Ayu',
            'Penjaringansari',
            'Rungkut Kidul',
            'Wonorejo Rungkut'
        ],

        // 19. Sambikerep
        'Sambikerep' => [
            'Bringin',
            'Lontar',
            'Made',
            'Sambikerep'
        ],

        // 20. Sawahan
        'Sawahan' => [
            'Banyu Urip',
            'Kupang Krajan',
            'Pakis',
            'Patemon',
            'Putat Jaya',
            'Sawahan',
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
            'Simolawang',
            'Tambakrejo'
        ],

        // 23. Sukolilo
        'Sukolilo' => [
            'Gebang Putih',
            'Keputih',
            'Klampis Ngasem',
            'Medokan Semampir',
            'Menur Pumpungan',
            'Nginden Jangkungan',
            'Semolowaru'
        ],

        // 24. Sukomanunggal
        'Sukomanunggal' => [
            'Putat Gede',
            'Simomulyo',
            'Simomulyo Baru',
            'Sonokwijenan',
            'Sukomanunggal',
            'Tanjungsari'
        ],

        // 25. Tambaksari
        'Tambaksari' => [
            'Dukuh Setro',
            'Gading',
            'Kapasmadya Baru',
            'PacarKeling',
            'PacarKembang',
            'Ploso',
            'Rangkah',
            'Tambaksari'
        ],

        // 26. Tandes
        'Tandes' => [
            'Balongsari',
            'Banjar Sugihan',
            'Karang Poh',
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
            'Wonorejo Tegalsari'
        ],

        // 28. Tenggilis Mejoyo
        'Tenggilis Mejoyo' => [
            'Kendangsari',
            'Kutisari',
            'Panjang Jiwa',
            'Tenggilis Mejoyo'
        ],

        // 29. Wiyung
        'Wiyung' => [
            'Babatan',
            'Balas Klumprik',
            'Jajar Tunggal',
            'Wiyung'
        ],

        // 30. Wonocolo
        'Wonocolo' => [
            'Bendul Merisi',
            'Jemur Wonosari',
            'Margorejo',
            'Sidosermo',
            'Siwalankerto'
        ],

        // 31. Wonokromo
        'Wonokromo' => [
            'Darmo',
            'Jagir',
            'Ngagel',
            'Ngagel rejo',
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
