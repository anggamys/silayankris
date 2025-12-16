<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class BeritaRequest extends FormRequest
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
            'judul' => ['required', 'string', 'max:255'],
            'isi' => ['required', 'string', 'max:5000'],
            'gambar_path' => ['nullable', 'file', 'image', 'mimes:jpeg,png,jpg', 'max:2048'], // Max 2MB
        ];

        return $rules;
    }
}
