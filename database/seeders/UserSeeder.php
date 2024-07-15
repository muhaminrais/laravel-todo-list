<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    DB::statement('SET FOREIGN_KEY_CHECKS=0;');

    Role::truncate();
    Permission::truncate();
    User::truncate();

    DB::table('model_has_roles')->truncate();
    DB::table('model_has_permissions')->truncate();
    DB::table('role_has_permissions')->truncate();

    DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    Role::create(['name' => 'admin']);

    User::create([
      'name' => 'Admin',
      'username' => 'admin',
      'email' => 'admin@admin.com',
      'password' => 'kYa:Nsd3bO2Eo-+0',
    ])->syncRoles('admin');
  }
}
