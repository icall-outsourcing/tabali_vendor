<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orderlog extends Model
{
    //
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
        protected $fillable = [
            'id',
            'user_id',
            'orderlog_id',
            'order_id',
            'before',
            'after',
        ];
        protected $casts = [
            'before' => 'array',
            'after' => 'array'
        ];
}