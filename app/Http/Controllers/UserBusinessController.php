<?php

namespace App\Http\Controllers;

use App\Address;
use App\Business;
use App\Category;
use App\File;
use App\Http\Requests\AddNewBusinessRequest;
use App\Http\Requests\EditBusinessRequest;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class UserBusinessController extends Controller
{
    /*
     * Show business details/profile page
     */
    public function getBusiness($id)
    {
        try
        {
            $business           = Business::find($id);
            $businessProfilePic = $business->file->where("meta_name" , '=' , 'business_profile_pic')->first();
            //$profilePicFilename = $businessProfilePic->filename . $businessProfilePic->file_extension;
            $address = $business->address;

            return view('business.profile' , [

                'business'           => $business ,
                'businessProfilePic' => $businessProfilePic ,
                'address'            => $address

            ]);
        } catch(\Exception $e)
        {
            echo($e->getTraceAsString());

            return response('Something went wrong..' , 404);
        }
    }

    /*
     * Get the form for adding new business
     */
    public function addBusinessForm()
    {
        $myBusinesses = Auth::user()->businesses;
        $categories   = Category::get();

        return view('business.newbusiness' , ['user'         => User::find(Auth::id()) ,
                                              'myBusinesses' => $myBusinesses ,
                                              'categories'   => $categories ,

        ]);

    }

    /*
     * Get the form for editing business
     */
    public function getEditBusinessForm(Business $business , User $user)
    {
        if($user->isVerified && $business->user == Auth::user()) return redirect('/home')->withErrors(['message' => 'Cannot edit this property']);
        try
        {
            $address             = $business->address;
            $business->open_from = Carbon::createFromFormat('H:i:s' , $business->open_from)->format('H:i');
            $business->open_upto = Carbon::createFromFormat('H:i:s' , $business->open_upto)->format('H:i');

            return view('business.editbusiness' , [

                'business'              => $business ,
                'address'               => $address ,
                'businessProfilePicUrl' => $business->profilePic ,
                'myBusinesses'          => Auth::user()->businesses ,
                'categories'            => Category::get()

            ]);
        } catch(ErrorException $e)
        {
            return response('Something went wrong in this page :' . Request::getBaseUrl() , 404);
        }
    }

    /**
     * Process request for new business
     */
    public function addNewBusiness(AddNewBusinessRequest $request)
    {
        $formData = $request->all();

        DB::beginTransaction();
        try
        {
            $business = Business::create([

                'name'          => $formData['business_name'] ,
                'description'   => $formData['business_description'] ,
                'open_from'     => Carbon::createFromFormat('H:m' , $formData['business_open_from']) ,
                'open_upto'     => Carbon::createFromFormat('H:m' , $formData['business_open_upto']) ,
                'phone_number'  => (int) $formData['business_phone_number'] ,
                'mobile_number' => (int) $formData['business_mobile_number'] ,
                'email'         => $formData['business_email'] ,
                'website'       => $formData['business_website'] ,
                'user_id'       => Auth::id() ,
                'category_id'   => $formData['business_category'] ,

            ]);//create business

            //use Eloquent relation of Business-has-Address with address() method in Business class
            $business->address()->create([

                'address'   => $formData['business_street_address'] ,
                'town'      => $formData['business_town'] ,
                'zip_code'  => $formData['business_zip_code'] ,
                'state'     => $formData['business_state'] ,
                'country'   => $formData['business_country'] ,
                'latitude'  => $formData['business_latitude'] ,
                'longitude' => $formData['business_longitude'] ,

            ]);//create address for business

            //check and upload profile pic
            if($request->hasFile('business_profile_pic') && $request->file('business_profile_pic')->isValid())
            {
                $avatar    = $request->file('business_profile_pic');
                $extension = $avatar->getClientOriginalExtension();
                //Naming convention: unix timestamp + file extension
                $filename      = uniqid(time() , true);
                $absolute_path = storage_path() . '/app/public/uploads/business/' . $filename . '.' . $extension;
                Storage::makeDirectory('/public/uploads/business');
                Image::make($avatar)->save($absolute_path);
                $business->file()->create([

                    'filename'      => $filename ,
                    'file_extension' => $extension,
                    'meta_name'     => 'business_profile_pic' ,
                    'absolute_path' => $absolute_path ,
                    'file_title'    => $business->name ,
                    'description'   => 'Business profile picture' ,
                    'file_url'      => '/business/uploads/' . $filename . '.'. $extension,
                    'mime_type'     => $avatar->getMimeType() ,
                    'parent_dir_path'=>  storage_path() . '/app/public/uploads/business/',
                ]);
                DB::commit();
            }
        } catch(\Exception $e)
        {
            DB::rollBack();

            return redirect()->back()->with(['error' => 'Something went wrong. Please try again..']);
        }

        return redirect('/business/' . $business->id)->with('message' , 'Your business is added!');
    }

    public function updateBusiness(Business $business , EditBusinessRequest $request)
    {
        $formData = $request->all();

        $businessAttributes = [

            'name'          => 'business_name' ,
            'description'   => 'business_description' ,
            'open_from'     => 'business_open_from' ,
            'open_upto'     => 'business_open_upto' ,
            'phone_number'  => 'business_phone_number' ,
            'mobile_number' => 'business_mobile_number' ,
            'email'         => 'business_email' ,
            'website'       => 'business_website' ,
            'category_id'   => 'business_category' ,


        ];
        $addressAttributes  = [

            'address'   => 'business_street_address' ,
            'town'      => 'business_town' ,
            'zip_code'  => 'business_zip_code' ,
            'state'     => 'business_state' ,
            'country'   => 'business_country' ,
            'latitude'  => 'business_latitude' ,
            'longitude' => 'business_longitude' ,

        ];
        DB::beginTransaction();
        try
        {
            foreach($businessAttributes as $key => $value)
            {
                $business->$key = $formData[$value];
            }//setting Business model to updated value
            $business->save();//save into databsse

            $address = $business->address;//Get address model of the particular business
            $address = $address ? : new Address();
            foreach($addressAttributes as $key => $value)
            {
                $address->$key = $formData[$value];
            }//setting Business model to updated value
            $address->save();//save changes to address in database

            //check and upload profile pic
            if($request->hasFile('business_profile_pic') && $request->file('business_profile_pic')->isValid())
            {
                $avatar        = $request->file('business_profile_pic');
                $fileExtension = $avatar->getClientOriginalExtension();
                $filename      = uniqid(time() , true) ;
                $absolute_path = storage_path() . '/app/public/uploads/business/' . $filename. '.' . $fileExtension;

                $oldFile       = $business->file->where('meta_name' , '=' , 'business_profile_pic')->first();
                $oldFile       = $oldFile ? : $business->file()->create([
                    'filename'      => $filename ,
                    'file_extension' => $fileExtension,
                    'meta_name'     => 'business_profile_pic' ,
                    'absolute_path' => $absolute_path ,
                    'file_title'    => $business->name ,
                    'description'   => 'Business profile picture' ,
                    'file_url'      => '/business/uploads/' . $filename . '.' . $fileExtension,
                    'mime_type'     => $avatar->getMimeType() ,
                    'parent_dir_path'=>  storage_path() . '/app/public/uploads/business/',


                ])  ;
                //filename is same as previously stored in database
                $filename      = $oldFile->filename . '.' . $fileExtension;
                $absolute_path = storage_path() . '/app/public/uploads/business/' . $filename;
                Storage::delete($absolute_path);
                Image::make($avatar)->save($absolute_path);
                $oldFile->file_title = $business->name;
                $oldFile->save();
            }
            DB::commit();
        } catch(\Exception $e)
        {
            DB::rollBack();

            return redirect()->back()->with(['error' => 'Something went wrong. Please try again..']);
        }

        return redirect('/business/' . $business->id)->with('message' , 'Your business is added!');

    }

    public function deleteBusiness(Busines $busines)
    {
        if($busines->user->id == Auth::id())
        {

        }
    }
}
