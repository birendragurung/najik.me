<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    /**
     * Get all of the product's ratings.
     */
    public function ratings()
    {
        return $this->morphMany('App\Rating', 'entity');
    }

    /**
     * Get all of the products's reviews.
     */
    public function reviews()
    {
        return $this->morphMany('App\Review', 'entity');
    }
}
