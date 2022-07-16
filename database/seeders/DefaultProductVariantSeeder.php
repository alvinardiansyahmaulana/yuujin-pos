<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Variant;

class DefaultProductVariantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $variants = [
            'Small', 'Regular'
        ];

        $prices = [
            12000, 14000
        ];

        foreach ($variants as $id => $variant) {
            Variant::create([
                'name' => $variant,
                'price' => $prices[$id],
                'product_id' => 2
            ]);
        }
    }
}
