<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    /**
     * Get all of the service's ratings.
     */
    public function rateable()
    {
        return $this->morphMany('App\Rating', 'entity');
    }

    /**
     * Get all of the service's reviews.
     */
    public function reviewable()
    {
        return $this->morphMany('App\Review', 'entity');
    }
}
