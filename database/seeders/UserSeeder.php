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
        'name' => 'Sang User',
        'email' => 'user@gmail.com',
        'password' => bcrypt('user123'),
        'role' => 'user',
        'status' => 'inactive',
      ],
    ];

    foreach ($users as $user) {
      User::create($user);
    }
  }
}
