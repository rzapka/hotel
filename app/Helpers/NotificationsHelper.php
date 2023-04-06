<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

class NotificationsHelper
{
    public static function execute($data)
    {
        $user = Auth::user();
        $userName = $user['isCompany'] ? $user['company'] : $user['firstname'] . ' ' . $user['lastname'];
        switch($data['category']) {
            case 'room':
                $bookedTo = date('Y-m-d', strtotime($data['startingDate']. ' + '. $data['quantity'] .'days'));
                return "Użytkownik $userName zerezerwował pokój nr {$data['roomNumber']} w dniach {$data['startingDate']} - $bookedTo";
            case 'spa':
                return "Użytkownik $userName zerezerwował wizytę w SPA dnia {$data['day']} w godzinach {$data['hours']}";
            case 'bowling':
                return "Użytkownik $userName zerezerwował {$data['track']} dnia {$data['day']} w godzinach {$data['hours']}";
            case 'hall':
                return "Użytkownik $userName zerezerwował salę dnia {$data['day']} w godzinach {$data['hours']}";
            case 'foodDelivery':
                return self::getFoodDeliveryMessage($userName, $data);

        }
    }

    public static function getFoodDeliveryMessage($userName, $data)
    {
        $str = "Użytkownik $userName zamówił do pokoju nr {$data['room']} następujące dania: \n";
        $meals = json_decode($data['meals']);
        foreach ($meals as $meal) {
            $str .= "- $meal->name \n";
        }
        $str .= "o łącznej kwocie {$data['price']}zł \n Opis: \n {$data['description']}";
        return $str;
    }

}
