<?php

namespace App\Http\Controllers;

use App\Business;
use App\Promotion;
use App\User;
use App\UserMeta;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function dashboardHome()
    {
        $allUsers  = User::paginate(30);
        dd($allUsers);
        $admins = UserMeta::where('role' , '=' , 'admin')->get();
        $moderators   = UserMeta::where('role' , '=' , 'moderator')->get();
        $newUserCount = User::where('created_at' , '>' , Carbon::today()->startOfDay());

        return view('admin.home' , ['allUsers' => $allUsers ,
                                    'admins' => $admins ,
                                    'moderators'  => $moderators,
                                    'newUserCount'  => $newUserCount
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
        return view('admin.home')->with(['message' => 'Business successfully promoted' ,]);
    }
}
