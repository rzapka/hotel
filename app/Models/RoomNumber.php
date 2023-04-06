<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomNumber extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'number', 'room_id', 'floor'];
    public $timestamps = false;

    public function bookedRooms(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(BookedRoom::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
