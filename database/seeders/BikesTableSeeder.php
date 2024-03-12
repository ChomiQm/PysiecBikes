<?php

namespace Database\Seeders;

use App\Models\Bike;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BikesTableSeeder extends Seeder
{
    public function run(): void
    {
        $bikes = [
            [
                'name' => 'Szosówka MTS 28"',
                'price' => 4000,
                'image_path' => 'images/products/product1.png'
            ],
            [
                'name' => 'Cross Trec 32"',
                'price' => 3000,
                'image_path' => 'images/products/product2.png'
            ],
            [
                'name' => 'MTB Trec 32"',
                'price' => 2137,
                'image_path' => 'images/products/product3.png'
            ],
            [
                'name' => 'Cross Trec 28"',
                'price' => 6969,
                'image_path' => 'images/products/product4.png'
            ],
            [
                'name' => 'Electric Czafczano',
                'price' => 1337,
                'image_path' => 'images/products/product5.png'
            ],
            [
                'name' => 'Electric Pysiec',
                'price' => 2115,
                'image_path' => 'images/products/product6.png'
            ],
            [
                'name' => 'Rowerek Pysiec',
                'price' => 3500,
                'image_path' => 'images/products/product7.png'
            ],
            [
                'name' => 'BMX Pysiec',
                'price' => 2500,
                'image_path' => 'images/products/product8.png'
            ]
        ];

        foreach ($bikes as $bike) {
            Bike::create($bike);
        }
    }
}

