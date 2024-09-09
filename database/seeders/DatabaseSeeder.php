<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   */
  public function run(): void
  {
    // User::factory(10)->create();

    // User::factory()->create([
    //     'name' => 'Test User',
    //     'email' => 'test@example.com',
    // ]);
    User::factory()->create([
      'name' => 'Administrator',
      'email' => 'admin@gmail.com',
      'password' => 'admin123',
    ]);
    User::factory()->create([
      'name' => 'Invitado',
      'email' => 'invitado@gmail.com',
      'password' => 'password',
    ]);

    User::factory(28)->create();

    $this->call(CustomerSeeder::class);
  }
}
