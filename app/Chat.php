<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $fillable = ['text'];

    public function chat()
    {
        return $this->hasMany(Chat::class);
    }
}
