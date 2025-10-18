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
        'name' => 'Sang Admin',
        'email' => 'admin@gmail.com',
        'password' => bcrypt('admin123'),
        'role' => 'admin',
        'status' => 'active',
      ],
      [
        'name' => 'Sang Guru',
        'email' => 'guru@gmail.com',
        'password' => bcrypt('guru123'),
        'role' => 'guru',
        'status' => 'active',
      ],
      [
        'name' => 'Sang Gereja',
        'email' => 'gereja@gmail.com',
        'password' => bcrypt('gereja123'),
        'role' => 'pengurus-gereja',
        'status' => 'active',
      ],
    ];

    foreach ($users as $user) {
      User::create($user);
    }

    User::factory()->count(10)->create();
  }
}
