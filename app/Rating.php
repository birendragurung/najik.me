<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    /**
     * Get all of the owning commentable models.
     */
    public function rateable()
    {
        return $this->morphTo();
    }
}
