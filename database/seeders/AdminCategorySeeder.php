<?php

namespace Database\Seeders;

use App\Models\AdminCategory;
use Illuminate\Database\Seeder;

class AdminCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->getInitialData() as $row) {
            AdminCategory::create([
               'name' => $row
            ]);
        }
    }


    private function getInitialData()
    {
        return ['Pracownicy Hotelu', 'Pracownicy SPA', 'Pracownicy Restauracji'];
    }

}
