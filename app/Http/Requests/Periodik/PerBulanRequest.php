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
            'guru_id' => ['required', 'exists:gurus,id'],
            'daftar_gaji_path' => ['nullable', 'file', 'mimes:pdf', 'max:5120'], // max 5 mb
            'daftar_hadir_path' => ['nullable', 'file', 'mimes:pdf', 'max:5120'], // max 5 mb
            'rekening_bank_path' => ['nullable', 'file', 'mimes:pdf', 'max:5120'], // max 5 mb
            'ceklist_berkas' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'in:menunggu,diterima,ditolak'],
            'catatan' => ['nullable', 'string', 'max:1000'],
        ];

        return $rules;
    }
}
