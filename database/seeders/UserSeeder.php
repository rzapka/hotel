<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->getInitialData() as $row) {
            User::create([
                'email' => $row['email'],
                'firstname' => $row['firstname'],
                'lastname' => $row['lastname'],
                'phonenumber' => $row['phonenumber'],
                'password' => $row['password'],
                'admin_category_id' => $row['admin_category_id'],
            ]);
        }
    }

    public function getInitialData()
    {
        return [
            ['email' => 'kasia@onet.pl', 'firstname' => 'Katarzyna', 'lastname' => 'Sobierajska', 'phonenumber' => 111111111, 'password' => Hash::make('haslo123'), 'admin_category_id' => 2],
            ['email' => 'zbigniew@onet.pl', 'firstname' => 'Zbigniew', 'lastname' => 'Stonoga', 'phonenumber' => 222222222, 'password' => Hash::make('haslo123'), 'admin_category_id' => 2],
            ['email' => 'marzena@onet.pl', 'firstname' => 'Marzena', 'lastname' => 'Wrona', 'phonenumber' => 333333333, 'password' => Hash::make('haslo123'), 'admin_category_id' => 2],
            ['email' => 'iza@onet.pl', 'firstname' => 'Izabela', 'lastname' => 'Łęcka', 'phonenumber' => 444444444, 'password' => Hash::make('haslo123'), 'admin_category_id' => 2],
            ['email' => 'test1@onet.pl', 'firstname' => 'Jan', 'lastname' => 'Kowalski', 'phonenumber' => 55555555, 'password' => Hash::make('haslo123'), 'admin_category_id' => null],
            ['email' => 'test2@onet.pl', 'firstname' => 'Anna', 'lastname' => 'Nowak', 'phonenumber' => 523523523, 'password' => Hash::make('haslo123'), 'admin_category_id' => null],
            ['email' => 'test3@onet.pl', 'firstname' => 'Mirosław', 'lastname' => 'Stabiński', 'phonenumber' => 614671532, 'password' => Hash::make('haslo123'), 'admin_category_id' => null],
            ['email' => 'test4@onet.pl', 'firstname' => 'Julia', 'lastname' => 'Cesarz', 'phonenumber' => 168257942, 'password' => Hash::make('haslo123'), 'admin_category_id' => null],
            ['email' => 'test5@onet.pl', 'firstname' => 'Zygmunt', 'lastname' => 'Stodoła', 'phonenumber' => 158537983, 'password' => Hash::make('haslo123'), 'admin_category_id' => null],
            ['email' => 'hotel@onet.pl', 'firstname' => 'Hotel', 'lastname' => 'Hotel', 'phonenumber' => 666666666, 'password' => Hash::make('haslo123'), 'admin_category_id' => 1],
            ['email' => 'kuchnia@onet.pl', 'firstname' => 'Kuchnia', 'lastname' => 'Kuchnia', 'phonenumber' => 777777777, 'password' => Hash::make('haslo123'), 'admin_category_id' => 3],
        ];
    }
}
