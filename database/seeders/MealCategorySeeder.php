<?php

namespace Database\Seeders;

use App\Models\MealCategory;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class MealCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->getInitialData() as $row) {
            $mealCategory = new MealCategory([
                'name' => $row
            ]);
            $mealCategory->save();
        }
    }

    private function getInitialData(): array
    {
        return [
            'przystawki','zupy', 'dania główne', 'sałatki', 'desery', 'menu dla dzieci', 'dodatki', 'surówki'
        ];
    }

}
