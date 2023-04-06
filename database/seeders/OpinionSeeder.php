<?php

namespace Database\Seeders;

use App\Models\Opinion;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class OpinionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->getInitialData() as [$userId, $stars, $message]) {
            Opinion::create([
               'user_id' => $userId,
               'stars' => $stars,
               'message' => $message,
               'date' => Carbon::now()->format('Y-m-d'),
            ]);
        }
    }

    private function getInitialData(): array
    {
        return [
            [5, 5, 'Wspaniały pobyt. Świetne atrakcje'],
            [6, 5, 'Pokoje w jak najwyższym standardzie i jedzenie tez pyszne.'],
            [7, 5, 'Świetnie sie bawiliśmy z rodziną. Pobyt w SPA mnie odprężył.'],
            [8, 4, 'Super ceny, miła obsługa, jednak kotlet lekko przypalony.'],
            [9, 5, 'Super standard i ceny adekwatne do jakości.'],
        ];
    }
}
