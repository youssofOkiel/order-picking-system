<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\Location;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $orders = Order::factory()
            ->count(50)
            ->has(
                User::factory()
                    ->count(1),
                'owner'
            )
            ->hasAttached(
                Product::factory()
                    ->count(5)
                    ->has(
                        Location::factory()
                            ->count(1)
                    ),
                ['quantity' => rand(1, 5)]
            )
            ->create();

        foreach (User::all() as $user) {
            $user->assignRole(Role::BusinessOwner);
        }
    }
}
