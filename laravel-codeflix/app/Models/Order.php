<?php

namespace CodeFlix\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'code',
        'value'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
