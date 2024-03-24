<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Size;
use App\Models\User;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Database\Factories\ItemInfoFactory;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::factory(1)->create();
        // Create 20 item infos using the factory
        ItemInfoFactory::new()->count(20)->create();
    }
}
