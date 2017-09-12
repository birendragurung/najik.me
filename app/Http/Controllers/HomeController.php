<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $promotedBusinesses = (new SearchController())->getPromotedBusinesses();
        if(Auth::guest())
        {
            return view('search.searchmap',['promotedBusinesses'=>$promotedBusinesses ]);
        }
        return view('search.searchmap',['promotedBusinesses'=>$promotedBusinesses ]);
    }
}
