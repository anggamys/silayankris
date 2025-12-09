<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class GerejaRequest extends FormRequest
{
    /**
     * Tentukan apakah user berhak melakukan request ini.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Prepare data before validation.
     */
    protected function prepareForValidation(): void
    {
        // Remove file path field if it's not an actual file upload (prevent string values from passing through)
        if (!$this->hasFile('sertifikat_sekolah_minggu_path') && $this->has('sertifikat_sekolah_minggu_path')) {
            $this->request->remove('sertifikat_sekolah_minggu_path');
        }
    }

    /**
     * Aturan validasi untuk input gereja.
     */
    public function rules(): array
    {
        return [
            'nama' => ['required', 'string', 'max:255'],
            'tanggal_berdiri' => ['nullable', 'date'],
            'tanggal_bergabung_sinode' => ['nullable', 'date'],
            'alamat' => ['nullable', 'string', 'max:255'],
            'kel_desa' => ['nullable', 'string', 'max:255'],
            'kecamatan' => ['nullable', 'string', 'max:255'],
            'kab_kota' => ['nullable', 'string', 'max:255'],
            'jarak_gereja_lain' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'nomor_telepon' => ['nullable', 'string', 'max:20'],
            'nama_pendeta' => ['nullable', 'string', 'max:255'],
            'status_gereja' => ['nullable', 'in:permanen,semi-permanen,tidak-permanen'],
            'sertifikat_sekolah_minggu_path' => ['nullable', 'file', 'mimes:pdf', 'max:5120'],

            // Field JSON
            'jumlah_umat' => ['nullable', 'array'],
            'jumlah_umat.laki_laki' => ['nullable', 'integer', 'min:0'],
            'jumlah_umat.perempuan' => ['nullable', 'integer', 'min:0'],

            'jumlah_majelis' => ['nullable', 'array'],
            'jumlah_majelis.laki_laki' => ['nullable', 'integer', 'min:0'],
            'jumlah_majelis.perempuan' => ['nullable', 'integer', 'min:0'],

            'jumlah_pemuda' => ['nullable', 'array'],
            'jumlah_pemuda.laki_laki' => ['nullable', 'integer', 'min:0'],
            'jumlah_pemuda.perempuan' => ['nullable', 'integer', 'min:0'],

            'jumlah_guru_sekolah_minggu' => ['nullable', 'array'],
            'jumlah_guru_sekolah_minggu.laki_laki' => ['nullable', 'integer', 'min:0'],
            'jumlah_guru_sekolah_minggu.perempuan' => ['nullable', 'integer', 'min:0'],

            'jumlah_murid_sekolah_minggu' => ['nullable', 'array'],
            'jumlah_murid_sekolah_minggu.laki_laki' => ['nullable', 'integer', 'min:0'],
            'jumlah_murid_sekolah_minggu.perempuan' => ['nullable', 'integer', 'min:0'],
        ];
    }


    /**
     * Pesan error kustom (opsional).
     */
    public function messages(): array
    {
        return [
            'nama.required' => 'Nama gereja wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'status_gereja.in' => 'Status gereja harus salah satu dari: permanen, semi-permanen, atau tidak-permanen.',
        ];
    }
}
