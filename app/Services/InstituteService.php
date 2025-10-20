<?php

namespace App\Services;

use App\Models\Institute;
use Illuminate\Support\Facades\Hash;

class InstituteService
{
    /**
     * Get all institutes with optional search.
     */
    public function getAll(?string $search = null)
    {
        $query = Institute::query();
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%")
                    ->orWhere('id', $search);
            });
        }
        return $query->paginate(10)->withQueryString();
    }

    /**
     * Store a new institute.
     */
    public function store(array $data)
    {
        return Institute::create($data);
    }

    /**
     * Update an existing institute.
     */
    public function update(Institute $institute, array $data)
    {
        if (isset($data['profile_path'])) {
            $data['profile_path'] = $data['profile_path']->store('profiles', 'public');
        } else {
            unset($data['profile_path']);
        }

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }
        $institute->update($data);
        return $institute;
    }

    /**
     * Delete an institute.
     */
    public function delete(Institute $institute)
    {
        return $institute->delete();
    }
}
