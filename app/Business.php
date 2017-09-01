<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Business extends Model
{

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

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
    public function rating()
    {
        return $this->morphMany(Rating::class , 'entity');
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
    public function promotion(){
        return $this->hasOne(Promotion::class);
    }
}
