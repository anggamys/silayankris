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
            'sk_pbm_path' => ['nullable', 'file', 'mimes:pdf', 'max:2048'],
            'sk_terakhir_path' => ['nullable', 'file', 'mimes:pdf', 'max:2048'],
            'sk_berkala_path' => ['nullable', 'file', 'mimes:pdf', 'max:2048'],
            'sp_bersedia_mengembalikan_path' => ['nullable', 'file', 'mimes:pdf', 'max:2048'],
            'sp_perangkat_pembelajaran_path' => ['nullable', 'file', 'mimes:pdf', 'max:2048'],
            'keaktifan_simpatika_path' => ['nullable', 'file', 'mimes:pdf', 'max:2048'],
            'berkas_s28a_path' => ['nullable', 'file', 'mimes:pdf', 'max:2048'],
            'berkas_skmt_path' => ['nullable', 'file', 'mimes:pdf', 'max:2048'],
            'permohonan_skbk_path' => ['nullable', 'file', 'mimes:pdf', 'max:2048'],
            'berkas_skbk_path' => ['nullable', 'file', 'mimes:pdf', 'max:2048'],
            'sertifikat_pengembangan_diri_path' => ['nullable', 'file', 'mimes:pdf', 'max:2048'],
            'status' => ['nullable', 'in:menunggu,diterima,ditolak'],
            'catatan' => ['nullable', 'string', 'max:1000'],
        ];

        return $rules;
    }
}
