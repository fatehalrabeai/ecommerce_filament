<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\CategoryBrand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class categoryBrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();
        $brands = Brand::all();

        // Randomly associate categories with brands
        foreach ($categories as $category) {
            CategoryBrand::create([
                'category_id' => $category->id,
                'brand_id' => $brands->random()->id,
            ]);
        }
    }
}
