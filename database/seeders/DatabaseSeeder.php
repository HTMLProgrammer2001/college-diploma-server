<?php

namespace Database\Seeders;

use App\Models\Commission;
use App\Models\Department;
use App\Models\Education;
use App\Models\Honor;
use App\Models\InternCategory;
use App\Models\Internship;
use App\Models\Publication;
use App\Models\Qualification;
use App\Models\Rank;
use App\Models\Rebuke;
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
        User::query()->limit(3)->update(['role' => 1]);

        Publication::factory()->count(20)->create();
        Education::factory()->count(50)->create();

        Honor::factory()->count(50)->create();
        Rebuke::factory()->count(50)->create();
        Qualification::factory()->count(50)->create();

        InternCategory::factory()->count(10)->create();
        Internship::factory()->count(200)->create();
    }
}
