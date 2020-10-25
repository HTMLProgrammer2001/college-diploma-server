<?php

namespace Database\Factories;

use App\Models\Education;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class EducationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Education::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'institution' => $this->faker->name,
            'graduate_year' => $this->faker->year,
            'qualification' => $this->faker->randomElement(Education::QUALIFICATIONS),
            'user_id' => $this->faker->randomElement(User::query()->get('id'))
        ];
    }
}
