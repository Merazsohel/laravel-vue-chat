<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    /**
     * @var array
     */
    protected $guarded = [];

    public function user()
    {
       return $this->belongsTo(User::class,'from');
    }
}
