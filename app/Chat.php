<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $fillable = [
        'sender', 'receiver','message', 'status', 'notified'
    ];
}
