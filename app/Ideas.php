<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ideas extends Model
{
    protected $fillable = [
        'user_id',
        'text',
        'room_id',
        'approved',
        'moderated_by'
    ];
}
