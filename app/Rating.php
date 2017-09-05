<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Rating extends Model
{
    protected $guarded = [];

    /*
     * Top rated businesses
     * */
    public static function getTopRatedBusinessesAttribute()
    {
        $topRatings = Rating::select(DB::raw('* , avg(rating) as avgrate'))->where( 'meta_name' , "user_rating")->groupBy('business_id')->orderBy('avgrate', 'desc')->limit(10)->get();
        //dd($topRatings);
        $topRatedBusinesses = new Collection();
        foreach($topRatings as $topRating)
        {
            if($topRating->business)
            {
                $topRating->business->avgRating =number_format($topRating->avgrate,1);
                $topRatedBusinesses[] = $topRating->business;
            }
            else{
                $topRating->delete();
                //if no business was found, you should delete this inconsistent row from database
            }
        }
        return $topRatedBusinesses;
    }

    /**
     * Get all of the owning commentable models.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function getGlobalRatingAttribute()
    {
        $globalRating = Rating::where('meta_name' , 'global_rating')->get();

        return $globalRating;
    }
}
