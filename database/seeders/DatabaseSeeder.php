<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   */
  public function run(): void
  {
    $this->call(PermissionSeeder::class);
    $this->call(CustomerSeeder::class);

    $admin = User::factory()->create([
      'name' => 'Administrator',
      'email' => 'admin@gmail.com',
      'password' => 'admin123',
    ]);

    $guest = User::factory()->create([
      'name' => 'Guest',
      'email' => 'guest@gmail.com',
      'password' => 'password',
    ]);

    $adminRole = Role::where(['name' => 'admin'])->first();
    $guestRole = Role::where(['name' => 'guest'])->first();

    $admin->assignRole($adminRole);
    $guest->assignRole($guestRole);

    User::factory(28)->create();
  }
}
