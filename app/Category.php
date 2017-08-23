<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function business()
    {
        return $this->morphTo(Business::class,'entity');
    }
}
