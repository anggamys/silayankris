<?php

namespace App\Http\Requests\Periodik;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class PerSemesterRequest extends FormRequest
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
            'guru_id' => ['required', 'exists:gurus,id'],
            'periode_per_semester' => ['sometimes', 'string', 'max:100'], // max 100 characters
            'sk_pbm_path' => ['nullable', 'file', 'mimes:pdf', 'max:5120'], // max 5 mb
            'sk_terakhir_path' => ['nullable', 'file', 'mimes:pdf', 'max:5120'], // max 5 mb
            'sk_berkala_path' => ['nullable', 'file', 'mimes:pdf', 'max:5120'], // max 5 mb
            'sp_bersedia_mengembalikan_path' => ['nullable', 'file', 'mimes:pdf', 'max:5120'], // max 5 mb
            'sp_kebenaran_berkas_path' => ['nullable', 'file', 'mimes:pdf', 'max:5120'], // max 5 mb
            'sp_perangkat_pembelajaran_path' => ['nullable', 'file', 'mimes:pdf', 'max:5120'], // max 5 mb
            'keaktifan_simpatika_path' => ['nullable', 'file', 'mimes:pdf', 'max:5120'], // max 5 mb
            'berkas_s28a_path' => ['nullable', 'file', 'mimes:pdf', 'max:5120'], // max 5 mb
            'berkas_skmt_path' => ['nullable', 'file', 'mimes:pdf', 'max:5120'], // max 5 mb
            'permohonan_skbk_path' => ['nullable', 'file', 'mimes:pdf', 'max:5120'], // max 5 mb
            'berkas_skbk_path' => ['nullable', 'file', 'mimes:pdf', 'max:5120'], // max 5 mb
            'sertifikat_pengembangan_diri_path' => ['nullable', 'file', 'mimes:pdf', 'max:5120'], // max 5 mb
            'catatan' => ['nullable', 'string', 'max:1000'], // max 1000 characters 
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
