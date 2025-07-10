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
        $faker = \Faker\Factory::create();
        $faker->addProvider(new \Smknstd\FakerPicsumImages\FakerPicsumImagesProvider($faker));

        return [
            'name' => fake()->name(),
            'description' => fake()->text(),
            'image' => $faker->imageUrl(width: 800, height: 600),
            'status' => fake()->randomElement(["active", "inactive"]),
            'video' => fake()->word(),
            'ingridients' => fake()->text(),
            'allergens' => fake()->text(),
        ];
    }
}
