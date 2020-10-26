<?php

namespace Database\Seeders;

use App\Models\Commission;
use App\Models\Department;
use App\Models\Education;
use App\Models\Honor;
use App\Models\Publication;
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
        Publication::factory()->count(20)->create();
        Education::factory()->count(50)->create();

        Honor::factory()->count(50)->create();
    }
}
