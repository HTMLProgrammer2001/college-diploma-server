<?php

namespace Database\Factories;

use App\Models\Honor;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class HonorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Honor::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'order' => $this->faker->creditCardNumber,
            'title' => $this->faker->title,
            'active' => true,
            'date_presentation' => $this->faker->date(),
            'user_id' => $this->faker->randomElement(User::query()->get('id'))
        ];
    }
}
