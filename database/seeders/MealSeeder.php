<?php

namespace Database\Seeders;

use App\Models\Meal;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class MealSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->getInitialData() as [$name, $price, $mealCategoryId]) {
            $meal = new Meal([
                'name' => $name,
                'price' => $price,
                'meal_category_id' => $mealCategoryId
            ]);
            $meal->save();
        }
    }

    private function getInitialData(): array
    {
        return [
            ['Tatar wołowy', 32, 1],
            ['Tatar z łososia', 35, 1],
            ['Carpaccio z polędwicy wołowej', 29, 1],
            ['Śledź w oleju', 20, 1],
            ['Skrzydełka z kurczaka', 25, 1],
            ['Wiejski chleb ze smalcem', 8, 1],
            ['Ogórkowa', 14, 2],
            ['Pomidorowa', 14, 2],
            ['Kapuśniak', 15, 2],
            ['Żurek ', 16, 2],
            ['Barszcz czerwony ', 14, 2],
            ['Grochowa ', 15, 2],
            ['Pierś z kaczki z sosem żurawinowym', 50, 3],
            ['Tradycyjny kotlet schabowy', 32, 3],
            ['Dorada pieczona', 37, 3],
            ['Kurczak supreme', 27, 3],
            ['Kotlety mielone', 30, 3],
            ['Kotlet devolay', 32, 3],
            ['Grecka', 22, 4],
            ['Z Kurczakiem i sosem tysiąca wysp', 24, 4],
            ['Salame', 24, 4],
            ['Cezar', 20, 4],
            ['Beza Migdałowa', 12, 5],
            ['Sernik', 14, 5],
            ['Szarlotka', 11, 5],
            ['Lody - (czekolada, truskawka, wanilia)', 15, 5],
            ['Naleśniki', 14, 5],
            ['Brownie', 15, 5],
            ['Nuggetsy z z kurczaka', 20, 6],
            ['Nuggetsy z z dorsza', 20, 6],
            ['Pancakes z bitą śmietaną, sosem czekoladowym i owocami', 20, 6],
            ['Młode ziemniaczki z koperkiem', 10, 7],
            ['Frytki', 10, 7],
            ['Ziemniaki opiekane', 10, 7],
            ['Talarki', 10, 7],
            ['Kluski śląskie', 10, 7],
            ['Ryż', 10, 7],
            ['Kasza gryczana', 10, 7],
            ['Buraki zasmażane', 8, 8],
            ['Kiszone buraki', 8, 8],
            ['Mizeria', 8, 8],
            ['Surówka z selera',8, 8],
            ['Surówka z białej kapusty',8, 8],
            ['Marchewka z jabłkiem',8, 8],
            ['Kiszona kapusta',8, 8],
        ];
    }
}
