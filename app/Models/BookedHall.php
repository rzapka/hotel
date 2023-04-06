<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookedHall extends Model
{
    use HasFactory;
    protected $table = 'booked_hall';
    public $timestamps = false;
    protected $fillable = ['booked_by', 'day', 'user_id', 'hours'];
}
