<?php

namespace Database\Factories;

use App\Models\InternCategory;
use App\Models\Internship;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class InternshipFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Internship::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'category_id' => $this->faker->randomElement(InternCategory::query()->get('id')),
            'user_id' => $this->faker->randomElement(User::query()->get('id')),
            'place' => $this->faker->address,
            'title' => $this->faker->title,
            'from' => $this->faker->date(),
            'to' => $this->faker->date(),
            'hours' => $this->faker->randomNumber(2),
            'credits' => 0,
            'code' => $this->faker->unique()->postcode
        ];
    }
}
