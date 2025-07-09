<?php

namespace Database\Factories;

use App\Models\City;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Restaurant;

class RestaurantFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Restaurant::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'address' => fake()->streetAddress(),
            'city_id' => City::factory(),
            'location' => json_encode([
                'lat' => fake()->latitude(),
                'lng' => fake()->longitude(),
            ]),
            'status' => fake()->randomElement(["open", "closed"]),
            'website' => fake()->domainName(),
        ];
    }
}
