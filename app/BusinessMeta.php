<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BusinessMeta extends Model
{
    public function business(){
        return $this->belongsTo(Business::class);
    }
}
