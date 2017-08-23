<?php

namespace App\Http\Controllers;

use App\Business;
use App\Http\Requests\AddNewBusinessRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class UserBusinessController extends Controller
{
    /**
     * Get form for adding new business
     * @param AddNewBusinessRequest $request
     */
    public function addNewBusiness(AddNewBusinessRequest $request)
    {
        $formData           = $request->all();

        /*$businessAttributes = [

            'business_name' ,
            'business_description' ,
            'business_open_from' ,
            'business_open_upto' ,
            'business_phone_number' ,
            'business_mobile_number' ,
            'business_email' ,
            'business_website' ,
            'businesss_profile_pic'

        ];
        $addressAttributes  = [

            'business_street_name' ,
            'business_town' ,
            'business_zip_code' ,
            'business_state' ,
            'business_country' ,
            'business_latitude' ,
            'business_longitude' ,

        ];*/
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


            ]);//create business

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
                $avatar = $request->file('business_profile_pic');
                $mime   = $avatar->getClientOriginalExtension();
                //Naming convention: unix timestamp + file extension
                $filename      = uniqid(time() , true) . '.' . $mime;
                $absolute_path = storage_path() . '/app/public/uploads/business/' . $filename;
                Storage::makeDirectory('/public/uploads/business');
                Image::make($avatar)->save($absolute_path);
                $business->file()->create([

                    'filename'        => $filename ,
                    'meta_name'       => 'business_profile_pic' ,
                    'absolute_path'   => $absolute_path ,
                    'file_title'      => $business->name ,
                    'description'     => 'Business profile picture' ,
                    'file_url'        => '/business/uploads/' . $filename ,
                    'mime_type'       => $avatar->getMimeType() ,
                    'parent_dir_path' => storage_path('app/uploads/business/')
                ]);
            }
            DB::commit();
        } catch(\Exception $e)
        {
            DB::rollBack();

            return redirect()->back();
        }

        return redirect('/business/' . $business->id)->with('message','Your business is added!') ;
    }

    public function getBusiness($id)
    {
        return Business::find($id);
    }
}
