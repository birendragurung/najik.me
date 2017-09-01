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

    public function addressable()
    {
        //morphTo relation between Business::class and Address::class.
        // @parameter $name => field name of the representing class
        return $this->morphTo('entity');
    }

}
