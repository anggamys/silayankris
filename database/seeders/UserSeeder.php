<?php

namespace Database\Seeders;

use App\Models\Guru;
use App\Models\StaffGereja;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{

  public function run(): void
  {
    $users = [
      [
        'name' => 'Sang Admin',
        'email' => 'admin@gmail.com',
        'password' => bcrypt('Admin123'),
        'role' => 'admin',
        'status' => 'aktif',
      ],
      [
        'name' => 'Sang Guru',
        'email' => 'guru@gmail.com',
        'password' => bcrypt('Guru123'),
        'role' => 'guru',
        'status' => 'aktif',
      ],
      [
        'name' => 'Sang Gereja',
        'email' => 'gereja@gmail.com',
        'password' => bcrypt('Gereja123'),
        'role' => 'staff-gereja',
        'status' => 'aktif',
      ],
    ];

    foreach ($users as $user) {
      User::create($user);
    }

    // make guru in user 
    Guru::create([
      'user_id' => User::where('email', 'guru@gmail.com')->first()->id,
      'nik' => '1234567890',
      'tempat_lahir' => 'Jakarta',
      'tanggal_lahir' => '1980-01-01',
    ]);

    // make gereja in user
    StaffGereja::create([
      'user_id' => User::where('email', 'gereja@gmail.com')->first()->id,
      'gereja_id' => 1, // Sesuaikan dengan ID gereja yang ada
    ]);
  }
}
