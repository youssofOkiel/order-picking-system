<?php

namespace Database\Seeders;

use Database\Factories\TimeSlotFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TimeSlotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TimeSlotFactory::times(5)->create();
    }
}
