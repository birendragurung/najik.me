<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Intervention\Image\Facades\Image;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function confirm($confirmation_code)
    {
        if(!$confirmation_code)
        {
            throw new InvalidConfirmationCodeException;
        }

        $user = User::whereConfirmationCode($confirmation_code)->first();

        if(!$user)
        {
            throw new InvalidConfirmationCodeException;
        }

        $user->confirmed         = 1;
        $user->confirmation_code = null;
        $user->save();

        Flash::message('You have successfully verified your account.');

        return Redirect::route('login_path');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data , [

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

        ]);
    }

    /*
     * REF: http://bensmith.io/email-verification-with-laravel
     */

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User
     */
    protected function create(array $data)
    {
        DB::beginTransaction();
        $user = User::create([

            'name'     => $data['name'] ,
            'email'    => $data['email'] ,
            'password' => bcrypt($data['password']) ,
            //'confirmation_code' =>$confirmation_code

            'username'      => $data['username'] ,
            //'first_name'    => $data['firstname'] ,
            //'middle_name'   => $data['middlename'] ,
            //'last_name'     => $data['lastname'] ,
            'date_of_birth' => $data['dateofbirth'] ,

        ]);
        $user->address()->create([

            'street_address' => $data['streetaddress'] ,
            'town'           => $data['town'] ,
            'state'          => $data['state'] ,
            'country'        => $data['country'] ,
            'zip_code'       => $data['zipcode'] ,
            'latitude'       => null ,
            'longitude'      => null

        ]);
        $request = Request::createFromGlobals();

        //check and upload profile pic
        if($request->hasFile('userprofilepic') && $request->file('userprofilepic')->isValid())
        {
            $avatar    = $request->file('userprofilepic');
            $extension = $avatar->getClientOriginalExtension();
            //Naming convention: unix timestamp + file extension
            $filename      = uniqid(time() , true);
            $absolute_path = storage_path() . '/app/public/uploads/users/' . $filename . '.' . $extension;
            Storage::makeDirectory('/public/uploads/users');
            Image::make($avatar)->save($absolute_path);
            $user->files()->create([

                'filename'        => $filename ,
                'file_extension'  => $extension ,
                'meta_name'       => 'user_profile_pic' ,
                'absolute_path'   => $absolute_path ,
                'file_title'      => $user->name ,
                'description'     => $user->username . ' profile picture' ,
                'file_url'        => '/business/uploads/' . $filename . '.' . $extension ,
                'mime_type'       => $avatar->getMimeType() ,
                'parent_dir_path' => storage_path() . '/app/public/uploads/users/' ,

            ]);
        }
        DB::commit();
        return $user;
    }
}
