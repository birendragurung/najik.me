<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name' ,
        'email' ,
        'password' ,
        'email',
        'username' ,
        'first_name' ,
        'middle_name' ,
        'last_name' ,
        'date_of_birth' ,
        'verified' ,
        'verified_at' ,
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password' ,
        'remember_token' ,
    ];

    public function getIsAdminAttribute()
    {
        $metas = Auth::user()->userMetas;
        foreach($metas as $meta)
        {
            if($meta->role == 'admin' )
            {
                return true;
            }
        }
        return false;

    }

    /*
     * Get all the user roles
     * */
    public function getUserRolesAttribute($id = null)
    {
        $metas = $id ? User::find($id)->userMetas : Auth::user()->userMetas;
        $roles = [];
        foreach($metas as $meta)
        {
            $roles[] =  $meta->role;
        }
        return $roles;
    }

    public function getIsVerifiedAttribute()
    {
        $user = User::find(Auth::id());

        return ($user->verified == 'yes') ? true : false;
    }

    public function getUserVerificationPendingAttribute()
    {
        $user = User::find(Auth::id());

        return ($user->verified == 'pending') ? true : false;
    }

    /*
     * Relationships with other models
     */
    public function businesses()
    {
        return $this->hasMany(Business::class);
    }

    public function address()
    {
        return $this->morphOne(Address::class,'entity');
    }

    public function userMetas()
    {
        return $this->hasMany(UserMeta::class);
    }

    public function files()
    {
        return $this->morphMany(File::class, 'entity');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

}
