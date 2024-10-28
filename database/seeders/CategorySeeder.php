<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create the main categories and their subcategories
        $mainCategories = [
            'المنزل والمعيشة' => [
                'مطبخ وعشاء',
                'ديكور منزل',
                'التنظيف المنزلي',
                'أساسيات المنزل',
                'صندوق تخزين',
                'حمام',
            ],
            'رجال' => [
                'ملابس رجالية',
                'ملابس تقليدية وثقافية',
                'احذية رجالية',
                'مجوهرات رجالية',
                'اكسسوارات الملابس',
                'الزي الرسمي والخاص',
            ],
            'نساء' => [
                'فساتين نسائية',
                'ملابس علوية و بلايز',
                'ملابس سفلية نسائية',
                'بدلات نسائية',
            ],
            'إلكترونيات وهواتف' => [
                'منتجات إلكترونية',
                'هواتف خلوية وإكسسوارات',
                'السيارات',
            ],
            'الحقائب والأمتعة' => [
                'حقائب',
                'محافظ وحاملات',
                'اكسسوارات حقائب',
                'حقائب رجالية',
                'حقائب عملية',
            ],
        ];

        // Loop through the main categories
        foreach ($mainCategories as $mainCategoryName => $subcategories) {
            // Create the main category
            $mainCategory = Category::create([

                'name' => $mainCategoryName,
                'slug' => Str::slug($mainCategoryName),
                'status' => 'active',
            ]);

            // Loop through the subcategories and create them
            foreach ($subcategories as $subcategoryName) {
                Category::create([

                    'name' => $subcategoryName,
                    'parent_id' => $mainCategory->id, // Link to the parent category
                    'slug' => Str::slug($subcategoryName),
                    'status' => 'active',
                ]);
            }
        }

//        Category::factory(5)->create()->each(function ($category) {
//            // Create 3 subcategories for each parent category
//            Category::factory(3)->create(['parent_id' => $category->id]);
//        });
    }
}
