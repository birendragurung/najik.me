<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageController extends Controller
{
    public function getBusinessUploads($url = null)
    {
        try
        {
            $path = storage_path() . '\app\public\uploads\business/' . $url;

            return response()->file($path);
        } catch(\Exception $e)
        {
            return response('File not found' , 404);
        }
    }

    public function getBusinessProfilePic($url = null)
    {
        try
        {
            if($url != null)
            {
                $path = storage_path() . '\app\public\uploads\business/' . $url;
                if(Storage::exists($path))
                {
                    return response()->file($path);
                } else
                {
                    //Return default business profile picture
                    return response()->file(storage_path('app/public/default_business_icon.jpg'));
                }
            }
            //Return default business profile picture
            return response()->file(storage_path('app/public/default_business_icon.jpg'));

        } catch(\Exception $e)
        {
            return response('File not found' , 404);
        }
    }

    public function getDefaultBusinessProfilePic()
    {
        try
        {
            //Return default business profile picture
            return response()->file(storage_path('app/public/default_business_icon.jpg'));

        } catch(\Exception $e)
        {
            return response('File not found' , 404);
        }
    }
}
