<?php

namespace CodeFlix\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',

        'value'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
