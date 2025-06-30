<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Recipe;

class RecipeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Recipe::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'description' => fake()->text(),
            'image' => fake()->word(),
            'status' => fake()->randomElement(["active","inactive"]),
            'video' => fake()->word(),
            'ingridients' => fake()->text(),
            'allergens' => fake()->text(),
        ];
    }
}
