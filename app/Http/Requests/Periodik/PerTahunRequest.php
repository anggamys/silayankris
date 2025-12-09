<?php

namespace App\Http\Requests\Periodik;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class PerTahunRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        $rules = [
            // Accept year format from the HTML year input (e.g. 2025)
            'periode_per_tahun' => ['sometimes', 'date_format:Y'],
            'biodata_path' => ['nullable', 'file', 'mimes:pdf', 'max:5120'], // max 5 mb
            'sertifikat_pendidik_path' => ['nullable', 'file', 'mimes:pdf', 'max:5120'], // max 5 mb
            'sk_dirjen_kelulusan_path' => ['nullable', 'file', 'mimes:pdf', 'max:5120'], // max 5 mb
            'nrg_path' => ['nullable', 'file', 'mimes:pdf', 'max:5120'], // max 5 mb
            'nuptk_path' => ['nullable', 'file', 'mimes:pdf', 'max:5120'], // max 5 mb
            'npwp_path' => ['nullable', 'file', 'mimes:pdf', 'max:5120'], // max 5 mb
            'ktp_path' => ['nullable', 'file', 'mimes:pdf', 'max:5120'], // max 5 mb
            'ijazah_sd_path' => ['nullable', 'file', 'mimes:pdf', 'max:5120'], // max 5 mb
            'ijazah_smp_path' => ['nullable', 'file', 'mimes:pdf', 'max:5120'], // max 5 mb
            'ijazah_sma_pga_path' => ['nullable', 'file', 'mimes:pdf', 'max:5120'], // max 5 mb
            'sk_pns_gty_path' => ['nullable', 'file', 'mimes:pdf', 'max:5120'], // max 5 mb
            'ijazah_s1_path' => ['nullable', 'file', 'mimes:pdf', 'max:5120'], // max 5 mb
            'transkrip_nilai_s1_path' => ['nullable', 'file', 'mimes:pdf', 'max:5120'], // max 5 mb
            'catatan' => ['nullable', 'string', 'max:1000'],
        ];

        // Jika pengguna yang diautentikasi merupakan guru terkait, mereka tidak perlu
        // memasukkan `guru_id` atau `status` — controller akan mengaturnya di sisi server.
        $user = Auth::user();
        if ($user && $user->guru) {
            // Izinkan controller untuk mengatur nilai-nilai ini; tidak perlu diminta dari form.
            $rules['guru_id'] = ['nullable', 'exists:gurus,id'];
            $rules['status'] = ['nullable', 'in:menunggu,diterima,ditolak,belum lengkap'];
        } else {
            // Untuk admin atau pemanggil lain, harus menyertakan guru_id dan status secara eksplisit.
            $rules['guru_id'] = ['required', 'exists:gurus,id'];
            $rules['status'] = ['nullable', 'in:menunggu,diterima,ditolak,belum lengkap'];
        }

        return $rules;
    }
}
