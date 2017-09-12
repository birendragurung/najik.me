<?php

namespace App\Http\Controllers;

use App\Business;
use App\Promotion;
use App\User;
use App\UserMeta;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class AdminDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function dashboardHome()
    {
        $allUsers  = User::all();
        $admins = UserMeta::where('role' , '=' , 'admin')->get();
        $moderators   = UserMeta::where('role' , '=' , 'moderator')->get();
        $newUserCount = User::where('created_at' , '>' , Carbon::today()->startOfDay());

        return view('admin.home' , [

            'allUsers'     => $allUsers ,
            'user'         => Auth::user() ,
            'admins'       => $admins ,
            'moderators'   => $moderators ,
            'newUserCount' => $newUserCount

        ]);
    }

    /*
     * deleteUser()
     * verifyUser()
     * verifyBusiness()
     * showUsers()
     * showBusinesses()
     * mapBusiness()
     * promoteBusiness()
     * */

    public function promoteBusiness(Business $business)
    {
        $promotions                    = $business->promotion ? : new Promotion();
        $promotions->business_id       = $business->id;
        $promotions->admin_id          = Auth::id();
        $promotions->promoted_at       = Carbon::now();
        $promotions->expires_at        = Carbon::now()->addHours(10 * 24);
        $promotions->promotion_period  = '11 days';
        $promotions->promotion_pricing = Promotion::pricing(10 * 24);
        $promotions->save();
        return Request::ajax() ?
            response()->json(
                [
                    'message'    => 'Business promoted successfully'
                ]
            ): view('admin.home')->with(['message' => 'Business successfully promoted' ,]);
    }
}
