<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MealCategory extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['name'];

    public function meals()
    {
        return $this->hasMany(Meal::class);
    }
}
