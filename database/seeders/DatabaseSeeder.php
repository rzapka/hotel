<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(MealCategorySeeder::class);
        $this->call(MealSeeder::class);
        $this->call(RoomSeeder::class);
        $this->call(RoomNumberSeeder::class);
        $this->call(AttractionSeeder::class);
        $this->call(AdminCategorySeeder::class);
        $this->call(UserSeeder::class);
        $this->call(OpinionSeeder::class);
    }
}
