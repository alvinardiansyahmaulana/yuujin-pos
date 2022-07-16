<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class DefaultProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = ['Coklat', 'Red Velvet', 'Madu'];

        foreach ($products as $id => $product) {
            Product::create([
                'name' => 'Susu ' . $product,
                'price' => 12000,
                'category_id' => 2,
                'has_variant' => $id % 2 == 0 ? true : false,
            ]);
        }
    }
}
