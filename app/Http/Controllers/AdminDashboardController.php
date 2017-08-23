<?php

namespace App\Http\Controllers;

use App\User;
use App\UserMeta;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function dashboardHome()
    {
        $user['all']  = User::all();
        $user['role'] = ['admin'     => UserMeta::where('role' , '=' , 'admin')->get('user_id') ,
                         'moderator' => UserMeta::where('role' , '=' , 'moderator')->get('user_id') ,
        ];
        $user['newUserCount']=User::where('created_at' , '>' , Carbon::today());

        return view('admin.home' , [
            'data' => $user
        ]);
    }
}
