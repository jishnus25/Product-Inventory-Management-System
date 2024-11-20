<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $faker = Faker::create();

        
        $categories = Category::all();

        
        foreach ($categories as $category) {
            for ($i = 0; $i < 5; $i++) { 
                Product::create([
                    'name' => $faker->word . ' ' . $category->name, 
                    'sku' => strtoupper($category->name[0] . $faker->randomNumber(5)),
                    'price' => $faker->randomFloat(2, 100, 2000), 
                    'quantity' => $faker->numberBetween(1, 100), 
                    'category_id' => $category->id, 
                ]);
            }
        }
    }
}
