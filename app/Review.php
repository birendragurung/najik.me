<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    /**
     * Get all of the owning commentable models.
     */
    public function reviewable()
    {
        return $this->morphTo();
    }
}
