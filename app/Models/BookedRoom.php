<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookedRoom extends Model
{
    use HasFactory;
    protected $dateFormat = 'd.m.Y';

    protected $fillable = ['booked_from', 'booked_to', 'price', 'room_number_id', 'user_id'];

    public $timestamps = false;
}
