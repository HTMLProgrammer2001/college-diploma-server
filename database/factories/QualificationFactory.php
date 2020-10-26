<?php

namespace Database\Factories;

use App\Models\Qualification;
use App\Models\User;
use App\Repositories\QualificationRepository;
use Illuminate\Database\Eloquent\Factories\Factory;

class QualificationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Qualification::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $qualificationRep = new QualificationRepository();

        return [
            'name' => $this->faker->randomElement($qualificationRep->getQualificationNames()),
            'date' => $this->faker->date(),
            'description' => $this->faker->paragraph,
            'user_id' => $this->faker->randomElement(User::query()->get('id'))
        ];
    }
}
