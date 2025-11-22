<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
  public function run(): void
  {
    $users = [
      [
        'id' => '00000000-0000-0000-0000-000000000001',
        'name' => 'Sang Admin',
        'email' => 'admin@gmail.com',
        'password' => bcrypt('Admin123'),
        'role' => 'admin',
        'status' => 'aktif',
      ],
      [ 
        'id' => '00000000-0000-0000-0000-000000000002',
        'name' => 'Sang Guru',
        'email' => 'guru@gmail.com',
        'password' => bcrypt('Guru123'),
        'role' => 'guru',
        'status' => 'aktif',
      ],
      [
        'id' => '00000000-0000-0000-0000-000000000003',
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

    // User::factory()->count(10)->create();
  }
}
