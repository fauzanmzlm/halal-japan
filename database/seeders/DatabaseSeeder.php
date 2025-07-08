<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Fauzan Mazlam',
            'email' => 'fake.email.cc.1@gmail.com',
        ]);

        $this->call([
            ProductSeeder::class,
            CompanySeeder::class,
            RestaurantSeeder::class,
            MenuSeeder::class,
            RecipeSeeder::class,
            StepSeeder::class,
            CountrySeeder::class,
            CitySeeder::class,
        ]);
    }
}
