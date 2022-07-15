<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Category;

class DefaultCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            'No Category', 'Drink', 'Food'
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category
            ]);
        }
    }
}
