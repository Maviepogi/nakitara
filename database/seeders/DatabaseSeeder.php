<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@nakitara.com',
            'password' => Hash::make('password'),
            'is_admin' => true,
            'email_verified_at' => now(),
        ]);

        // Create categories
        $categories = [
    'Electronics',
    'Clothing',
    'Accessories',
    'Documents',
    'Keys',
    'Bags',
    'Jewelry',
    'Books',
    'Wallets',
    'Toys',
    'Sports Equipment',
    'Animals',
    'Gadgets',
    'Eyewear',
    'Footwear',
    'Medical Equipment',
    'Musical Instruments',
    'Tools',
    'Household Items',
    'Art Supplies',
    'Others',
];


        foreach ($categories as $category) {
            Category::create(['name' => $category]);
        }
    }
}