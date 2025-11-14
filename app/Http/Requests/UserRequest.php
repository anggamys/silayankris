<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UserRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($this->user?->id)],
            'nomor_telepon' => ['nullable', 'string', 'max:15'],
            'profile_photo_path' => ['nullable', 'file', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'role' => ['required', Rule::in([User::ROLE_ADMIN, User::ROLE_GURU, User::ROLE_STAFF_GEREJA])],
        ];

        // Only require password on create
        if ($this->isMethod('post')) {
            $rules['password'] = ['required', 'string', 'min:8', 'confirmed'];
            $rules['status'] = ['nullable', Rule::in([User::STATUS_AKTIF, User::STATUS_NONAKTIF])];
        } elseif ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules['password'] = ['nullable', 'string', 'min:8', 'confirmed'];
            $rules['status'] = ['required', Rule::in([User::STATUS_AKTIF, User::STATUS_NONAKTIF])];
        }

        if ($this->input('role') === User::ROLE_GURU) {
            $guruRules = $this->guruRules();
            $rules = array_merge($rules, $guruRules);
        } elseif ($this->input('role') === User::ROLE_STAFF_GEREJA) {
            $staffGerejaRules = $this->staffGerejaRules();
            $rules = array_merge($rules, $staffGerejaRules);
        }

        return $rules;
    }

    public function guruRules(): array
    {
        $guruRules = [
            'nip' => ['required', 'string', 'max:50', Rule::unique('gurus', 'nip')->ignore($this->user->guru->id ?? null, 'id')->where(function ($query) {
                return $query->where('user_id', $this->user->id ?? null);
            })],
            'tempat_lahir' => ['required', 'string', 'max:100'],
            'tanggal_lahir' => ['required', 'date'],
            'sekolah_id' => ['required', 'exists:sekolahs,id'],
        ];

        return $guruRules;
    }

    public function pengurusGerejaRules(): array
    {
        $pengurusGerejaRules = [
            'gembala_sidang' => ['required', 'string', 'max:100'],
            'gereja_id' => ['required', 'exists:gerejas,id'],
        ];

        return $pengurusGerejaRules;
    }
}
