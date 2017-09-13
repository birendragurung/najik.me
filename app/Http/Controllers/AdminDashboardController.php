<?php

namespace App\Http\Controllers;

use App\Business;
use App\Promotion;
use App\User;
use App\UserMeta;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use PhpParser\ErrorHandler\Collecting;

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

    public function showNewUsers()
    {
        $newUsers = User::where('created_at',">" , Carbon::now()->subDays(100))->join('user_metas','user.id' , '=' , 'user_metas.user_id','inner' , 'role != admin') ->get() ;

        return view('admin.newusers' , ['newUsers' => $newUsers ,]);
    }

    public function showVerifyUser()
    {
        return view();
    }

    public function verifyUser(User $user)
    {
        $user->verified = 'yes';
        $user->save();

        return response()->json(['message' => 'User verified' ,]);
    }

    public function unverifyUser(User $user)
    {
        $user->verified = 'no';
        $user->save();

        return response()->json(['message' => 'User unverified' ,]);
    }

    public function deleteUser(User $user)
    {
        DB::beginTransaction();
        try
        {
            if(UserMeta::where('user_id' , $user->id)->where('role' , 'admin')->get()->count() > 0)
            {
                return response()->json(['message' => 'Admin users cannot be deleted' ,]);
            }
            $user->address ? $user->address->delete() : false;
            $user->files->each(function($file , $key){
                $file->delete();
            });
            $user->businesses ? $user->businesses->each(function($business){
                $business->files ? $business->files->each(function($file){
                    $file->delete();
                }) : false;
                $business->address ? $business->address->delete() : false;
                $business->delete();
            }) : false;
            $user->userMetas ? $user->userMetas->each(function($userMeta){
                $userMeta->delete();
            }) : false;
            $a = $user->delete();
            DB::commit();

            return response()->json(['message' => 'User deleted successfully']);
        } catch(\Exception $e)
        {
            DB::rollBack();
        }

        return response('Failed' , 400);
    }

    public function showBusinesses()
    {
        $businesses = Business::all()->sortByDesc('created_at');
        return view('admin.business',['businesses' =>$businesses ]);
    }

    public function showNewBusinesses()
    {
        $businesses = Business::where('created_at' , '<' , Carbon::now()->subDays(1))->get();

        return view('admin.business' , ['businesses' => $businesses ,]);
    }

    public function verifyBusiness(Business $business)
    {
        $business->verified = 'yes';
        $business->save();

        return response()->json(['message' => 'Business verified' ,]);
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

    public function showPromotionRequests()
    {
        $promotionsRequests = Promotion::where('status' , 'requested')->get()->sortByDesc('created_at');
        $businesses = new Collection();
            $promotionsRequests->each(function($r) use ($businesses){
            $businesses[] = $r->business;
        }) ;

        return view('admin.promotion' , ['businesses'=>$businesses ]);
    }

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
