<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Company;
use App\Models\Product;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $faker = \Faker\Factory::create();
        $faker->addProvider(new \Smknstd\FakerPicsumImages\FakerPicsumImagesProvider($faker));

        return [
            'name' => fake()->name(),
            'barcode' => fake()->ean13(),
            'ingridients' => fake()->text(),
            'allergens' => fake()->text(),
            'image' => $faker->imageUrl(width: 800, height: 600),
            'status' => fake()->randomElement(["haram", "no-contamination", "halal"]),
            'company_id' => Company::factory(),
        ];
    }
}
