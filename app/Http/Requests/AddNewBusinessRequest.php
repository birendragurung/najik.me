<?php

namespace App\Http\Requests;

use App\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AddNewBusinessRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request i.e. adding new business.
     *
     * @return bool
     */
    public function authorize(User $user)
    {
        if(Auth::user())
        {
            if($user->isVerified)
            {
                return true;
            } else
            {
                redirect('/home')->withErrors(['message' => 'Please wait for your account verification']);
            }
        }

        return redirect("/login")->with('require_login' , 'Please login to add new business');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return ['business_name'           => 'required|string|max:200|min:8|regex:/^[a-z A-Z]+$/u' ,
                'business_street_address' => 'required|string|max:200' ,
                'business_zip_code'       => ['required' ,
                                              'integer' ,
                                              'digits_between:3,8',
                                              'regex:/^[0-9]{5}(?:-[0-9]{4})?$/' ,
                ] ,
                'business_town'           => 'required|string|regex:/^[a-zA-Z]+$/u' ,
                'business_state'          => 'required|string|regex:/^[a-zA-Z]+$/u' ,
                'business_description'    => 'required|string|regex:/^[a-z A-Z]+$/u' ,
                'business_open_from'      => ['required' , 'regex:/(2[0-4]|[01][1-9]|10):([0-5][0-9])/'] ,
                'business_open_upto'      => ['required' , 'regex:/(2[0-4]|[01][1-9]|10):([0-5][0-9])/'] ,
                'business_phone_number'   => 'required|digits_between:6,10' ,
                'business_mobile_number'  => 'required|digits_between:10,13' ,
                'business_email'          => 'required|email|unique:users,email' ,
                //REF: https://laravel.com/docs/5.4/validation#rule-regex
                'business_website'        => ['required' ,
                                              'regex:@^(http\:\/\/|https\:\/\/)?([a-z0-9][a-z0-9\-]*\.)+[a-z0-9][a-z0-9\-]*$@i'] ,
                'business_latitude'       => ['required' , 'regex:/^(\-?\d+(\.\d+)?).\s*(\-?\d+(\.\d+)?)$/'] ,
                'business_longitude'      => ['required' , 'regex:/^(\-?\d+(\.\d+)?).\s*(\-?\d+(\.\d+)?)$/'] ,
                'business_profile_pic'    => 'required|image|mimes:jpeg,jpg,png'

        ];
    }

    /**
     * Get the validation messages.
     *
     * @return array
     */
    public function messages()
    {
        return [

        ];
    }
}
