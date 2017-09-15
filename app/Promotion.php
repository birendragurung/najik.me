<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    protected $guarded = [];

    protected $dates = ['promoted_at' ,
                        'expires_at' ,];

    public static $pricePerHour = 0.5;

    public static function pricing($hours){
        return Promotion::$pricePerHour * $hours;
    }

    public function business()
    {
        return $this->belongsTo(Business::class);
    }
}
