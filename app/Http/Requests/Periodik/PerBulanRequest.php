<?php

namespace App\Http\Requests\Periodik;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class PerBulanRequest extends FormRequest
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
            // Accept year-month format from the HTML month input (e.g. 2025-12)
            'periode_per_bulan' => ['required', 'date_format:Y-m'],
            'daftar_gaji_path' => ['nullable', 'file', 'mimes:pdf', 'max:5120'], // max 5 mb
            'daftar_hadir_path' => ['nullable', 'file', 'mimes:pdf', 'max:5120'], // max 5 mb
            'rekening_bank_path' => ['nullable', 'file', 'mimes:pdf', 'max:5120'], // max 5 mb
            'ceklist_berkas' => ['nullable', 'file', 'mimes:pdf', 'max:5120'], // max 5 mb
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
