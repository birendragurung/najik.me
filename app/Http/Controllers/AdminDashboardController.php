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
        $promotionsRequestCount = Promotion::where('created_at' , '>' , Carbon::today()->startOfDay())->count() ;
        $admins = UserMeta::where('role' , '=' , 'admin')->get();
        $newUserCount =
            User::where('created_at' , '>' ,
                Carbon::now()->subDays(7)->startOfDay())
            ->count() ;
        $newBusinessCount =
            Business::where('created_at' , '>' ,
                Carbon::now()->subDays(7)
            ->startOfDay())
            ->count() ;
        $newBusinesses =
            Business::orderByDesc('created_at' )
            ->limit(15)
            ->get() ;

        return view('admin.home' , [

            'promotionsRequestCount' => $promotionsRequestCount ,
            'allUsers'               => $allUsers ,
            'user'                   => Auth::user() ,
            'admins'                 => $admins ,
            'newUserCount'           => $newUserCount ,
            'newBusinessCount'       => $newBusinessCount ,
            'totalBusinessCount'     => Business::count() ,
            'newUsers'               => User::orderByDesc('created_at')->limit(15)->get() ,
            'newBusinesses'          => $newBusinesses ,
            'verifiedUsersCount'     => User::where('verified' , 'yes')->count() ,
            'verifiedBusinessCount'  => Business::where('verified' , 'yes')->count() ,


        ]);
    }

    public function showNewUsers()
    {
        //dd(User::raw('select * from users where created_at >'.Carbon::now()->startOfDay()->subDays(100) . ' inner join user_metas ')->get() );
/*        $newUsers = User::where('users.created_at',">" , Carbon::now()->startOfDay()->subDays(100))
            ->where('users.verified','no')
            ->join('user_metas','users.id' , '=' , 'user_metas.user_id','inner')
            ->where('user_metas.role','!=', 'admin')
            ->get() ;*/
        $newUsers = User::raw('SELECT  * FROM users 
                        INNER JOIN user_metas ON users.id = user_metas.user_id 
                        WHERE users.verified != \'yes\' 
                        AND user_metas.role != \'admin\'')
                    ->get();
        return view('admin.newusers' , ['newUsers' => $newUsers ,]);
    }

    public function showAllUsers()
    {
        $users = User::all();

        return view('admin.allusers' , ['users' => $users ,]);
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
            $user->reviews? $user->reviews->each(function($review){
                $review->delete();
            }):false;
            $user->ratings?$user->ratings->each(function($rating){
                $rating->delete();
            }):false;
            $user->delete();
            DB::commit();

            return response()->json(['message' => 'User deleted successfully']);
        } catch(\Exception $e)
        {
            DB::rollBack();
        }

        return response()->json (['message'=> 'Failed' ]);
    }

    public function verifyUser(User $user)
    {
        if($user->verified == 'yes' )
        {
            return $this->unverifyUser($user);
        }
        $user->verified = 'yes';
        $user->save();

        return response()->json(['message' => 'User verified' ,'data' =>'verified' ]);
    }

    public function unverifyUser(User $user)
    {
        $user->verified = 'no';
        $user->save();

        return response()->json(['message' => 'User unverified' ,'data' =>'unverified' ]);
    }

    public function showBusinesses()
    {
        $businesses = Business::all()->sortByDesc('created_at');
        return view('admin.business',['businesses' =>$businesses ]);
    }

    public function showNewBusinesses()
    {
        $businesses = Business::where('created_at' , '>' , Carbon::now()->subDays(10))
            ->orderByDesc('created_at')
            ->limit(1000)
            ->get();

        return view('admin.newbusinesses' , [
            'businesses' => $businesses ,
            'title' => 'Businesses',
            'headerTitle' => "Recently added" ,
            'headerInfo'=>'New businesses'
            ]);
    }

    public function verifyBusiness(Business $business)
    {
        if($business->verified == 'yes' )
        {
            return $this->unverifyBusiness($business);
        }
        $business->verified = 'yes';
        $business->save();

        return response()->json(['message' => 'Business verified' ,'data' =>'verified' ]);
    }

    public function unverifyBusiness(Business $business)
    {
        $business->verified = 'no';
        $business->save();

        return response()->json(['message' => 'Business unverified' ,'data' =>'unverified' ]);
    }

    public function showPromotionRequests()
    {
        $promotionsRequests = Promotion::where('status' , 'requested')->get()->sortByDesc('created_at');
        $businesses = new Collection();
            $promotionsRequests->each(function($r) use ($businesses){
            $businesses[] = $r->business?:null;
        }) ;

        return view('admin.promotionrequests' , ['businesses'=>$businesses ]);
    }

    public function showPromotedBusiness()
    {
        $promoted = Promotion::where('expires_at' , '>' , Carbon::now())->get() ;
        $promotedBusinesses = new Collection();
        $promoted->each(function($p) use ($promotedBusinesses){
            if($p->business)
            {
                $promotedBusinesses[] = $p->business;
            }
        });

        return view('admin.promotedbusinesses' , ['businesses' => $promotedBusinesses ,]);
    }

    public function promoteBusiness(Business $business)
    {
        $promotions                    = $business->promotion ? : new Promotion();
        $promotions->business_id       = $business->id;
        $promotions->admin_id          = Auth::id();
        $promotions->promoted_at       = Carbon::now();
        $promotions->expires_at        = Carbon::now()->addHours(10 * 24);
        $period = (int)str_split($promotions->promotion_period)[0];
        $promotions->promotion_pricing = Promotion::pricing($period * 24);
        $promotions->status = 'active';
        $promotions->save();
        return Request::ajax() ?
            response()->json(
                [
                    'message'    => 'Business promoted for '. $promotions->promotion_period .'with pricing of ' . $promotions->promotion_pricing
                ]
            ): view('admin.home')->with(['message' => 'Business successfully promoted' ,]);
    }

    public function deleteBusiness(Business $business)
    {
        DB::beginTransaction();
        try
        {
            $business->address ? $business->address->delete() : false;

            $business->delete();
            DB::commit();

            return response()->json(['message' => 'business deleted successfully']);
        } catch(\Exception $e)
        {
            DB::rollBack();
        }

        return response('Failed' , 400);
    }
    
    public function addAsAdmin(User $user)
    {
        $meta = $user->userMetas && $user->userMetas()->where('role','admin')->count() != 0  ?$user->userMetas()->where('role','admin')->first():new UserMeta();
        $meta->user_id = $user->id;
        $meta->role = 'admin';
        $meta->save();

        return response()->json(['message' => 'Successfully added as admin' ,]);
    }
}
