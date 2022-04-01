<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => 'Item 1',
                'price' => 100000,
            ],
            [
                'name' => 'Item 2',
                'price' => 200000,
            ],
            [
                'name' => 'Item 3',
                'price' => 300000,
            ],
            [
                'name' => 'Item 4',
                'price' => 400000,
            ],
            [
                'name' => 'Item 5',
                'price' => 500000,
            ],
            [
                'name' => 'Item 6',
                'price' => 600000,
            ],
            [
                'name' => 'Item 7',
                'price' => 700000,
            ],
            [
                'name' => 'Item 8',
                'price' => 800000,
            ],
            [
                'name' => 'Item 9',
                'price' => 900000,
            ],
            [
                'name' => 'Item 10',
                'price' => 1000000,
            ],
        ];

        foreach ($data as $item) {
            Item::query()
                ->updateOrCreate(
                    [
                        'name' => $item['name'],
                    ],
                    [
                        'name' => $item['name'],
                        'price' => $item['price'],
                    ]
                );
        }
    }
}
