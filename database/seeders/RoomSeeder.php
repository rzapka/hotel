<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->getData() as [$name, $description, $area, $price, $images]) {
            $model = new Room();
            $model->name = $name;
            $model->description = $description;
            $model->area = $area;
            $model->price = $price;
            $model->images = json_encode($images);
            $model->save();
        }
    }

    private function getData()
    {
        return [
            ['Pokój Standard', 'W pokoju Standard znajduje się łóżko małżeńskie (190 x 210)cm lub dwa pojedyncze 2x(100 na 210)cm. Powierzchnia pokoju ma 23m2. Pokoje są bardzo przytulne i komfortowe. Pokój posiada łazienke z prysznicem.',
                23, 340,
                ['1.1.jpg', '1.2.jpg', '1.3.jpg']
            ],
            ['Pokój Standard + Taras', 'W pokoju Standard + taras znajduje się łóżko małżeńskie (190 x 210)cm lub dwa pojedyncze (2 x 100 na 210)cm. Powierzchnia pokoju ma 23m2. Pokoje są bardzo przytulne i komfortowe. Pokój posiada łazienke z prysznicem oraz taras (10m2) z kompletem mebli.',
                23, 380,
                ['2.1.jpg', '2.2.jpg', '2.3.jpg']
            ],
            ['Pokój Premium', 'Pokój Premium wyróżnia się sporą przestrzenią. Ma on powierzchnię 50m2. Część sypialna wyposażona została w jedno duże wygodne łóżko malżeńskie (190 x 210)cm. Ekskluzywnie urządzona część wypoczynkowa zachęca do relaksu i wypoczynku. W pokoju znajduje się łazienka z prysznicem.',
                50, 500,
                ['3.1.jpg', '3.2.jpg', '3.3.jpg']
            ],
            ['Pokój Premium + Taras', 'Pokój Premium + Taras wyróżnia się sporą przestrzenią. Ma on powierzchnię 50m2. Część sypialna wyposażona została w jedno duże wygodne łóżko malżeńskie (190 x 210)cm. Ekskluzywnie urządzona część wypoczynkowa zachęca do relaksu i wypoczynku. W pokoju znajduje się łazienka z prysznicem oraz duży balkon z widokiem na ogród',
                50, 540,
                ['4.1.jpg', '4.2.jpg', '4.3.jpg']
            ],
        ];
    }
}
