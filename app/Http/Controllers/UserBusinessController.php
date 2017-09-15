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
            (new SearchController())->getBusinessRatings($business);
            return view('business.profile2' , [

                'business'           => $business
            ]);
        } catch(\Exception $e)
        {

            return response()->view('errors.404',[],404);
        }
    }

    /*
     * Get the form for adding new business
     */
    public function addBusinessForm()
    {
        if(Auth::user()->isVerified ) :

            $myBusinesses = Auth::user()->businesses;
            $categories   = Category::get();

            return view('business.newbusiness' , ['user'         => User::find(Auth::id()) ,
                                                  'myBusinesses' => $myBusinesses ,
                                                  'categories'   => $categories ,

            ]);
        elseif(Auth::user()->isVerified == false):
            return redirect()->back()->with('message' , 'Please wait for your account verification.');
        else:
            return redirect()->back()->with('message' , 'Unauthorized access to this page');
        endif;
    }

    /*
     * Get the form for editing business
     */
    public function getEditBusinessForm(Business $business , User $user)
    {
        if($user->isVerified && $business->user == Auth::user()) :
            try
            {
                $address             = $business->address;
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
        elseif($user->isVerified == false):
            return redirect()->back()->with('message' , 'You must be verified to modify your business');
        else:
            return redirect()->back()->with('message' , 'Unauthorized access to this page');
        endif;
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

                'street_address'   => $formData['business_street_address'] ,
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

                    'filename'        => $filename ,
                    'file_extension'  => $extension ,
                    'meta_name'       => 'business_profile_pic' ,
                    'absolute_path'   => $absolute_path ,
                    'file_title'      => $business->name ,
                    'description'     => 'Business profile picture' ,
                    'file_url'        => '/business/uploads/' . $filename . '.' . $extension ,
                    'mime_type'       => $avatar->getMimeType() ,
                    'parent_dir_path' => storage_path() . '/app/public/uploads/business/' ,]);
            }
            DB::commit();
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

        $this->authorize('edit' , $business);//check if the user can edit/destroy this business using BookPolicy

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

            'street_address'   => 'business_street_address' ,
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
                $filename      = uniqid(time() , true);
                $absolute_path = storage_path() . '/app/public/uploads/business/' . $filename . '.' . $fileExtension;

                $oldFile = $business->file->where('meta_name' , '=' , 'business_profile_pic')->first();
                $oldFile = $oldFile ? : $business->file()->create([

                    'filename'        => $filename ,
                    'file_extension'  => $fileExtension ,
                    'meta_name'       => 'business_profile_pic' ,
                    'absolute_path'   => $absolute_path ,
                    'file_title'      => $business->name ,
                    'description'     => 'Business profile picture' ,
                    'file_url'        => '/business/uploads/' . $filename . '.' . $fileExtension ,
                    'mime_type'       => $avatar->getMimeType() ,
                    'parent_dir_path' => storage_path() . '/app/public/uploads/business/' ,


                ]);
                //filename is same as previously stored in database
                $filename      = $oldFile->filename . '.' . $fileExtension;
                $absolute_path = storage_path() . '/app/public/uploads/business/' . $filename;
                Storage::delete($absolute_path);
                Image::make($avatar)->save($absolute_path);
                $oldFile->mime_type      = $avatar->getMimeType();
                $oldFile->file_url       = '/business/uploads/' . $filename . '.' . $fileExtension;
                $oldFile->file_title     = $business->name;
                $oldFile->file_extension = $fileExtension;
                $oldFile->save();
            }
            DB::commit();
        } catch(\Exception $e)
        {
            DB::rollBack();

            return redirect()->back()->with(['message' => 'Something went wrong. Please try again..']);
        }

        return redirect('/business/' . $business->id)->with('message' , 'Your business was updated successfully!');

    }

    public function deleteBusiness(Business $business)
    {
        $this->authorize('delete' , $business);//check if the user can edit/destroy this business using BookPolicy
        try
        {
            DB::beginTransaction();
            if($business->file )
            {
                foreach($business->file as $file)
                {
                    $file->delete();
                }
            }
            $business->delete();
            DB::commit();
            return redirect()->back()->with('message' ,'Successfully deleted');
        } catch(\Exception $e)
        {
            DB::rollBack();

            return redirect()->back()->with('message' ,'Somethings went wrong. Cannot delete business now' );
        }
    }

    public function requestPromotion(Business $business, $days)
    {
        $newPromotion = isset($business->promotion) ? $business->promotion : $business->promotion()->create([
            'business_id' =>$business->id,
            'status' => 'requested' ,
            'promotion_period'=> $days . ' days',
        ]);
        $newPromotion->business_id = $business->id;
        $newPromotion->status = "requested";
        $newPromotion->promotion_period = $days . ' days';
        $newPromotion->save();

        return response()->json(['message' => 'Successfully requested for promotion. Please wait for admin verification' ,]);
    }
}
