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
            'biodata_path' => ['nullable', 'file', 'mimes:pdf', 'max:2048'],
            'sertifikat_pendidik_path' => ['nullable', 'file', 'mimes:pdf', 'max:2048'],
            'sk_dirjen_path' => ['nullable', 'file', 'mimes:pdf', 'max:2048'],
            'sk_kelulusan_path' => ['nullable', 'file', 'mimes:pdf', 'max:2048'],
            'nrg_path' => ['nullable', 'file', 'mimes:pdf', 'max:2048'],
            'nuptk_path' => ['nullable', 'file', 'mimes:pdf', 'max:2048'],
            'npwp_path' => ['nullable', 'file', 'mimes:pdf', 'max:2048'],
            'ktp_path' => ['nullable', 'file', 'mimes:pdf', 'max:2048'],
            'ijazah_sd_path' => ['nullable', 'file', 'mimes:pdf', 'max:2048'],
            'ijazah_smp_path' => ['nullable', 'file', 'mimes:pdf', 'max:2048'],
            'ijazah_sma_path' => ['nullable', 'file', 'mimes:pdf', 'max:2048'],
            'sk_pns_path' => ['nullable', 'file', 'mimes:pdf', 'max:2048'],
            'sk_gty_path' => ['nullable', 'file', 'mimes:pdf', 'max:2048'],
            'ijazah_s1_path' => ['nullable', 'file', 'mimes:pdf', 'max:2048'],
            'transkrip_nilai_s1_path' => ['nullable', 'file', 'mimes:pdf', 'max:2048'],
            'status' => ['nullable', 'in:menunggu,diterima,ditolak'],
            'catatan' => ['nullable', 'string', 'max:1000'],
        ];
        return $rules;
    }
}
