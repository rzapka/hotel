<?php

namespace Database\Seeders;

use App\Models\RoomNumber;
use Illuminate\Database\Seeder;

class RoomNumberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->getInitialData() as [$number, $roomId, $floor]) {
            RoomNumber::create([
               'number' => $number,
               'room_id' => $roomId,
               'floor' => $floor
            ]);
        }
    }


    private function getInitialData()
    {
        return [
            [1, 1, 1],
            [2, 1, 1],
            [3, 2, 1],
            [4, 3, 1],
            [5, 3, 1],
            [6, 4, 1],
            [7, 1, 1],
            [8, 1, 1],
            [9, 2, 1],
            [10, 3, 1],
            [11, 3, 1],
            [12, 4, 1],
            [13, 1, 1],
            [14, 1, 1],
            [15, 2, 1],
            [16, 3, 1],
            [17, 3, 1],
            [18, 4, 1],
            [19, 2, 1],
            [20, 4, 1],
            [21, 1, 2],
            [22, 1, 2],
            [23, 2, 2],
            [24, 3, 2],
            [25, 3, 2],
            [26, 4, 2],
            [27, 1, 2],
            [28, 1, 2],
            [29, 2, 2],
            [30, 3, 2],
            [31, 3, 2],
            [32, 4, 2],
            [33, 1, 2],
            [34, 1, 2],
            [35, 2, 2],
            [36, 3, 2],
            [37, 3, 2],
            [38, 4, 2],
            [39, 2, 2],
            [40, 4, 3],
            [41, 1, 3],
            [42, 1, 3],
            [43, 2, 3],
            [44, 3, 3],
            [45, 3, 3],
            [46, 4, 3],
            [47, 1, 3],
            [48, 1, 3],
            [49, 2, 3],
            [50, 3, 3],
            [51, 3, 3],
            [52, 4, 3],
            [53, 1, 3],
            [54, 1, 3],
            [55, 2, 3],
            [56, 3, 3],
            [57, 3, 3],
            [58, 4, 3],
            [59, 2, 3],
            [60, 4, 3],
        ];
    }
}
