<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void {
    Role::create(['name' => 'admin']);
    Role::create(['name' => 'guest']);
    Role::create(['name' => 'user']);

    Permission::create(['name' => 'view:role']);
    Permission::create(['name' => 'create:role']);
    Permission::create(['name' => 'update:role']);
    Permission::create(['name' => 'delete:role']);

    Permission::create(['name' => 'view:permission']);

    Permission::create(['name' => 'view:user']);
    Permission::create(['name' => 'create:user']);
    Permission::create(['name' => 'update:user']);
    Permission::create(['name' => 'delete:user']);

  }
}
