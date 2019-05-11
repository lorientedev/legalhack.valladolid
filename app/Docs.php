<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Docs extends Model
{
    protected $fillable = [
        'editor', 'room_id', 'text', 'version'
    ];
}
