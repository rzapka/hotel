<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookedSpa extends Model
{
    use HasFactory;
    protected $table = 'booked_spa';
    public $timestamps = false;
    protected $fillable = ['booked_by', 'day', 'hours', 'employee', 'user_id'];


    public function employee()
    {
        return $this->belongsTo(User::class);
    }
}
