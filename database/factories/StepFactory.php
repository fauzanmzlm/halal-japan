<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Recipe;
use App\Models\Step;

class StepFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Step::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'description' => fake()->text(),
            'image' => fake()->word(),
            'recipe_id' => Recipe::factory(),
        ];
    }
}
