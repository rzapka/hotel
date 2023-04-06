<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodOrder extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['room', 'price', 'description', 'meals'];
}
