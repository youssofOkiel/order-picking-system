<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use \App\Enums\Role as RoleEnum;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (RoleEnum::getValues() as $role) {
            Role::query()->updateOrCreate([
                'name' => $role
            ]);
            Role::query()->updateOrCreate([
                'name' => $role,
                'guard_name' => 'api'
            ]);
        }
    }
}
