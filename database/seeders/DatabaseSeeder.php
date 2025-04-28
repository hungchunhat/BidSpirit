<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Auction;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'role' => 'admin',
        ]);
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'role' => 'collector',
        ]);
        User::factory(2)->create([
            'role' => 'collector'
        ]);
        User::factory(10)->create();

        //auctions:
        Auction::factory()->create([
            'status' => 'live',
        ]);
        Auction::factory(3)->create();
        Auction::factory(3)->create([
            'status' => 'ended',
        ]);

        //category:
        $categories = [
            [
                'name' => 'fine_art',
                'description' => 'The fine_art category features high-value, unique artworks like paintings, sculptures, and prints with cultural, historical, or aesthetic significance.',
            ],
            [
                'name' => 'antique',
                'description' => 'The antique category includes rare, collectible items over 100 years old, valued for their historical, cultural, or artistic significance.',
            ],
            [
                'name' => 'furniture',
                'description' => 'The furniture category features high-quality, collectible pieces such as chairs, tables, cabinets, and more, prized for craftsmanship and design.',
            ],
            [
                'name' => 'collectible',
                'description' => 'The collectible category includes unique, sought-after items like coins, stamps, toys, or memorabilia, valued for rarity and significance.',
            ],
            [
                'name' => 'other',
                'description' => 'The other category includes items that do not fit into any of the other categories.'
            ]
        ];
        foreach ($categories as $category) {
            Category::create($category);
        }
        //product:
        Product::factory(30)->create();
        Auction::find(1)->product()->attach([1, 2, 3, 4, 5]);
        Product::whereIn('id', [1, 2, 3, 4, 5])->update(['status' => 'in-auction']);
        User::find(2)->product()->attach([
            1 => ['action_type' => 'own'],
            2 => ['action_type' => 'own'],
            3 => ['action_type' => 'own'],
            4 => ['action_type' => 'own'],
            5 => ['action_type' => 'own'],
            6 => ['action_type' => 'own'],
            7 => ['action_type' => 'own'],
            8 => ['action_type' => 'own'],
            9 => ['action_type' => 'own'],
            10 => ['action_type' => 'own'],
        ]);
        User::find(3)->product()->attach([
            11 => ['action_type' => 'own'],
            12 => ['action_type' => 'own'],
            13 => ['action_type' => 'own'],
            14 => ['action_type' => 'own'],
            15 => ['action_type' => 'own'],
            16 => ['action_type' => 'own'],
            17 => ['action_type' => 'own'],
            18 => ['action_type' => 'own'],
            19 => ['action_type' => 'own'],
            20 => ['action_type' => 'own'],
        ]);
        User::find(4)->product()->attach([
            21 => ['action_type' => 'own'],
            22 => ['action_type' => 'own'],
            23 => ['action_type' => 'own'],
            24 => ['action_type' => 'own'],
            25 => ['action_type' => 'own'],
            26 => ['action_type' => 'own'],
            27 => ['action_type' => 'own'],
            28 => ['action_type' => 'own'],
            29 => ['action_type' => 'own'],
            30 => ['action_type' => 'own'],
        ]);
        User::find(5)->product()->attach([
            31 => ['action_type' => 'own'],
            32 => ['action_type' => 'own'],
            33 => ['action_type' => 'own'],
            34 => ['action_type' => 'own'],
            35 => ['action_type' => 'own'],
            36 => ['action_type' => 'own'],
            37 => ['action_type' => 'own'],
            38 => ['action_type' => 'own'],
            39 => ['action_type' => 'own'],
            40 => ['action_type' => 'own'],
        ]);
    }
}
