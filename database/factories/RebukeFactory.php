<?php

namespace Database\Factories;

use App\Models\Rebuke;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class RebukeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Rebuke::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->title,
            'date_presentation' => $this->faker->date(),
            'order' => $this->faker->creditCardNumber,
            'active' => true,
            'user_id' => $this->faker->randomElement(User::query()->get('id'))
        ];
    }
}
