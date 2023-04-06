<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookedBowling extends Model
{
    use HasFactory;
    protected $table = 'booked_bowling';
    public $timestamps = false;
    protected $fillable = ['booked_by', 'day', 'hours', 'track', 'user_id'];
}
