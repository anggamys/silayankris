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
            'guru_id' => ['required', 'exists:gurus,id'],
            'biodata_path' => ['nullable', 'file', 'mimes:pdf', 'max:5120'], // max 5 mb
            'sertifikat_pendidik_path' => ['nullable', 'file', 'mimes:pdf', 'max:5120'], // max 5 mb
            'sk_dirjen_path' => ['nullable', 'file', 'mimes:pdf', 'max:5120'], // max 5 mb
            'sk_kelulusan_path' => ['nullable', 'file', 'mimes:pdf', 'max:5120'], // max 5 mb
            'nrg_path' => ['nullable', 'file', 'mimes:pdf', 'max:5120'], // max 5 mb
            'nuptk_path' => ['nullable', 'file', 'mimes:pdf', 'max:5120'], // max 5 mb
            'npwp_path' => ['nullable', 'file', 'mimes:pdf', 'max:5120'], // max 5 mb
            'ktp_path' => ['nullable', 'file', 'mimes:pdf', 'max:5120'], // max 5 mb
            'ijazah_sd_path' => ['nullable', 'file', 'mimes:pdf', 'max:5120'], // max 5 mb
            'ijazah_smp_path' => ['nullable', 'file', 'mimes:pdf', 'max:5120'], // max 5 mb
            'ijazah_sma_path' => ['nullable', 'file', 'mimes:pdf', 'max:5120'], // max 5 mb
            'sk_pns_path' => ['nullable', 'file', 'mimes:pdf', 'max:5120'], // max 5 mb
            'sk_gty_path' => ['nullable', 'file', 'mimes:pdf', 'max:5120'], // max 5 mb
            'ijazah_s1_path' => ['nullable', 'file', 'mimes:pdf', 'max:5120'], // max 5 mb
            'transkrip_nilai_s1_path' => ['nullable', 'file', 'mimes:pdf', 'max:5120'], // max 5 mb
            'status' => ['required', 'in:menunggu,diterima,ditolak'],
            'catatan' => ['nullable', 'string', 'max:1000'],
        ];
        return $rules;
    }
}
