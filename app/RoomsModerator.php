<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoomsModerator extends Model
{
    protected $fillable = [
        'user_id',
        'room_id'
    ];
}
