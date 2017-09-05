<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddNewBusinessRequest;
use App\Http\Requests\EditUserProfileRequest;
use App\User;
use Illuminate\Support\Facades\Auth;

/**
 * Class UserController
 * @package App\Http\Controllers
 */
class UserController extends Controller
{
    public function profile(User $user){
        return view('user.profile' , ['user' => $user ,]);
    }

    public function editProfile(EditUserProfileRequest $request)
    {
        $user = Auth::user();
        $formData = $request->all();

        $userAttributes = [

            'name'     => $formData['name'] ,
            'email'    => $formData['email'] ,
            'password' => bcrypt($formData['password']) ,
            //'confirmation_code' =>$confirmation_code

            'username'      => $formData['username'] ,
            //'first_name'    => $formData['firstname'] ,
            //'middle_name'   => $formData['middlename'] ,
            //'last_name'     => $formData['lastname'] ,
            'date_of_birth' => $formData['dateofbirth'] ,



        ];
        $addressAttributes  = [

            'street_address' => $formData['streetaddress'] ,
            'town'           => $formData['town'] ,
            'state'          => $formData['state'] ,
            'country'        => $formData['country'] ,
            'zip_code'       => $formData['zipcode'] ,
            'latitude'       => null ,
            'longitude'      => null

        ];
        DB::beginTransaction();
        try
        {
            foreach($userAttributes as $key => $value)
            {
                $user->$key = $formData[$value];
            }//setting user model to updated value
            $user->save();//save into databsse

            $address = $user->address;//Get address model of the particular user
            $address = $address ? : new Address();
            foreach($addressAttributes as $key => $value)
            {
                if(in_array($key , ['latitude' , 'longitude']))
                {
                    $address->$key = null;
                    //we dont have latitude and longitude to be saved to user's address
                    continue;
                }
                $address->$key = $formData[$value];
            }//setting user model to updated value
            $address->save();//save changes to address in database

            //check and upload profile pic
            if($request->hasFile('user_profile_pic') && $request->file('user_profile_pic')->isValid())
            {
                $avatar        = $request->file('user_profile_pic');
                $fileExtension = $avatar->getClientOriginalExtension();
                $filename      = uniqid(time() , true) ;
                $absolute_path = storage_path() . '/app/public/uploads/user/' . $filename. '.' . $fileExtension;

                $oldFile       = $user->file->where('meta_name' , '=' , 'user_profile_pic')->first();
                $oldFile       = $oldFile ? : $user->file()->create([
                    
                    'filename'      => $filename ,
                    'file_extension' => $fileExtension,
                    'meta_name'     => 'user_profile_pic' ,
                    'absolute_path' => $absolute_path ,
                    'file_title'    => $user->name ,
                    'description'   => 'user profile picture' ,
                    'file_url'      => '/user/uploads/' . $filename . '.' . $fileExtension,
                    'mime_type'     => $avatar->getMimeType() ,
                    'parent_dir_path'=>  storage_path() . '/app/public/uploads/user/',

                ])  ;
                
                //filename is same as previously stored in database
                $filename      = $oldFile->filename . '.' . $fileExtension;
                $absolute_path = storage_path() . '/app/public/uploads/user/' . $filename;
                Storage::delete($absolute_path);
                Image::make($avatar)->save($absolute_path);
                $oldFile->mime_type= $avatar->getMimeType();
                $oldFile->file_url = '/users/uploads/' . $filename . '.' . $fileExtension;
                $oldFile->file_title = $user->name;
                $oldFile->file_extension = $fileExtension;
                $oldFile->save();
            }
            DB::commit();
        } catch(\Exception $e)
        {
            DB::rollBack();

            return redirect()->back()->with(['error' => 'Something went wrong. Please try again..']);
        }

        return redirect('/user/' . $user->id)->with('message' , 'Your user is added!');
    }
}
