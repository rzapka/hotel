<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opinion extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['user_id', 'message', 'stars', 'date'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
