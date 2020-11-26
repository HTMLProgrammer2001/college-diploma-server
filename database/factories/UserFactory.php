<?php

namespace Database\Factories;

use App\Models\Commission;
use App\Models\Department;
use App\Models\Rank;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'fullName' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => bcrypt('20012007'),
            'commission_id' => Commission::all('id')->random(),
            'department_id' => Department::all('id')->random(),
            'rank_id' => Rank::all('id')->random(),
            'pedagogical_title' => $this->faker->randomKey(\Constants::$pedagogicalTitles)
        ];
    }
}
