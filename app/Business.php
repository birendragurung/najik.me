<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Business extends Model
{

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function getIsVerifiedAttribute()
    {

        return ($this->verified == 'yes') ? true : false;
    }

    public function getVerificationPendingAttribute()
    {
        return ($this->verified == 'pending') ? true : false;
    }

    public function getCategoryNameAttribute()
    {
        return $this->category->name;
    }

    public function getOpenFromTimeAttribute()
    {

        return Carbon::createFromFormat('H:i:s' , $this->attributes['open_from'])->format('H:s A');
        //return Carbon::createFromFormat('h:i:s' , $this['open_from'])->format('h:i A');
    }

    public function getOpenUptoTimeAttribute()
    {
        return Carbon::createFromFormat('H:i:s' , $this->attributes['open_from'])->format('H:s A');
    }

    public function getProfilePicAttribute()
    {
        try
        {
            return $this->file->where('meta_name' , '=' , 'business_profile_pic')->first()->file_url;
        } catch(\Exception $e)
        {
            //Business has no profile pic set.. so
            //send default image for business profile pic
        }

        return url('business/profile.jpg');
    }

    /*
     * Global rating
     * */
    public function getGlobalRatingAttribute()
    {
        $globalRating = 0;
        $globalRating = Rating::where('meta_name' , 'global_rating')->where('business_id' , $this->id)->first();

        return $globalRating->rating;
    }


    /*
     * Get the business's owner user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /*
     * Get the business's address
     */
    public function address()
    {
        return $this->MorphOne(Address::class , 'entity');
    }

    /*
     * Get the business's services
     */
    public function services()
    {
        return $this->hasMany(Service::class);
    }

    /*
    * Get the business's products
    */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /*
    * Get the business's categories
    */
    public function categories()
    {
        return $this->morphMany(Category::class , 'entity');
    }

    /**
     * Get all of the Business's ratings.
     */
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    /**
     * Get all of the Business's reviews.
     */
    public function review()
    {
        return $this->morphMany(Review::class , 'entity');
    }

    /*
     * Business files
     */
    public function file()
    {
        return $this->morphMany(File::class , 'entity');
    }

    /*
     * Business category
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /*
     *
     * */
    public function promotion()
    {
        return $this->hasOne(Promotion::class);
    }
}
