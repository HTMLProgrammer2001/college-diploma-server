<?php

namespace Database\Seeders;

use App\Models\Commission;
use App\Models\Department;
use App\Models\Rank;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Commission::factory()->count(10)->create();
        Department::factory()->count(10)->create();
        Rank::factory()->count(5)->create();

        User::factory()->count(10)->create();
    }
}
