<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class EditUserProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user() ? true : false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [//
                'name'           => 'required|max:255' ,
                'email'          => 'required|email|max:255|unique:users' ,
                'password'       => 'required|min:6|confirmed' ,
                'username'       => 'required|min:6' ,
                'dateofbirth'    => 'required' ,
                'streetaddress'  => 'required' ,
                'town'           => 'required' ,
                'state'          => 'required' ,
                'country'        => 'required' ,
                'zipcode'        => ['required', 'integer' ,'digits_between:3,8'],
                'userprofilepic' => 'required|image|mimes:jpeg,jpg,png'
        ];
    }
}
