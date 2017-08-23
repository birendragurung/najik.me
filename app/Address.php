<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /*
     * Model relationships
     */

    public function business()
    {
        $this->morphTo();
    }
}
