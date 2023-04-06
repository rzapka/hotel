<?php

namespace Database\Seeders;

use App\Models\Attraction;
use Illuminate\Database\Seeder;

class AttractionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->getInitialData() as [$name, $title, $description, $color, $icon]) {
            $attraction = new Attraction([
                'name' => $name,
                'title' => $title,
                'description' => $description,
                'color' => $color,
                'icon' => $icon,
            ]);
            $attraction->save();
        }
    }

    private function getInitialData()
    {
        return [
          ['Spa', 'Zarezerwuj pobyt w SPA', 'Zapisz się na masaż u jednego z naszych pracowników, dostepny również basen oraz sauna.', '#e34f32', 'mdi-spa'],
          ['Bowling', 'Zapisz się na kręgle', 'Zarezerwuj sobie jeden z torów do kręgli na daną godzinę.', '#b361ed', 'mdi-bowling'],
          ['Hall', 'Zarezerwuj salę do gry w koszykówkę / siatkówkę / piłkę nożną', 'Zarezerwuj sobie salę, aby w aktywny sposób spędzić czas z rodzina czy przyjaciółmi.', '#3ef06d', 'mdi-basketball'],
          ['FoodDelivery', 'Zamów jedzenie do pokoju', 'Prócz zjedzenia w naszej restauracji istnieje możliwość zamówienia sobie jedzenia do pokoju.', '#3e8ef0', 'mdi-food'],
        ];
    }
}
