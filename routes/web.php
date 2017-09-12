<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Address;
use App\Business;
use App\BusinessCategory;
use App\Category;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UserController;
use App\Promotion;
use App\Rating;
use App\User;
use App\UserMeta;
use Carbon\Carbon;
use Eloquent\Lcs\LcsSolver;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

/*
 * Illuminate\Routing\Router::auth();
 */
Auth::routes();
Route::get('register/verify/{confirmationCode}', [
    'as' => 'confirmation_path',
    'uses' => 'RegisterController@confirm'
]);
Route::get('/' , "HomeController@index");

Route::group(['name'=>'home routes', "middleware" =>'auth' ], function()
{


    Route::get("/logout" , function()
    {
        if(Auth::user())
        {
            Auth::logout();
        }

        return redirect('/login');
    });

    Route::get('/home' , 'HomeController@index')->name('home');

});

///////////////////////////////////////////////////////////////
//////////////      User Routes Group        //////////////////
///////////////////////////////////////////////////////////////

Route::group(['name' => 'user','middleware' =>'auth'] , function()
{
    //TODO add user profile, my businesses list page
    Route::get('/user/profile' , 'UserController@profile');

    Route::post('/user/editprofile' , 'UserController@editProfile');

    Route::post('/review/{business}' , 'UserController@reviewBusiness');

    Route::post('/review/edit/{business}' , 'UserController@editReviewBusiness');

    Route::get('/business/review/delete/{business}' , 'UserController@deleteReview');

    Route::get('/business/rate/{business}' , 'UserController@rateBusiness');

    Route::get('/business/rate/delete/{business}' , 'UserController@deleteRate');
});


///////////////////////////////////////////////////////////////
//////////  Business Routes Group with No middleware    ///////
///////////////////////////////////////////////////////////////

Route::group(['name' => 'Business public routes'] , function()
{
    Route::get('/business/{id}' , 'UserBusinessController@getBusiness')->where('id', '[0-9]+');

    Route::get('business/profile/{business}' , function(Business $business)
    {
        $rating = (new SearchController())->getBusinessRatings($business);
        return view('business.profile2',['business'=> $business]);
    });
});


///////////////////////////////////////////////////////////////
/////   Business Routes Group with Auth middleware  ///////////
///////////////////////////////////////////////////////////////

Route::group(['name' => 'Business Private Routes' , 'middleware' => 'auth'] , function()
{

    Route::get('mybusinesses' , function()
    {
        $myBusinesses = Auth::user()->businesses;
        return view('business.mybusinesses',[

            'myBusinesses'=>$myBusinesses
        ]);
    });

    Route::delete('/business/{business}' , "UserBusinessController@deleteBusiness");

    Route::get('/business/add' ,'UserBusinessController@addBusinessForm');

    Route::post('/business/add' , 'UserBusinessController@addNewBusiness');

    Route::get('/business/edit/{business}' , 'UserBusinessController@getEditBusinessForm')->where('business', '[0-9]+');

    Route::post('/business/edit/{business}' , 'UserBusinessController@updateBusiness')->where('business', '[0-9]+');
});


///////////////////////////////////////////////////////////////
//////////       Administrator Route Group      ///////////////
///////////////////////////////////////////////////////////////
//uses App\Http\Middleware\IsAdmin middleware

Route::group(['name' => 'Admin Dashboard', 'middleware' => 'admin' ] , function()
{
    Route::get('/admin/dashboard' , 'AdminDashboardController@dashboardHome');

    Route::get('promote/{business}' ,  "AdminDashboardController@promoteBusiness");

    Route::get('/user/delete/{user}' , "AdminDashboardController@deleteUser");

    Route::get('/user/delete/{user}' , "AdminDashboardController@deleteUser");

    Route::get('/user/verify/{user}' , "AdminDashboardController@verifyUser");

    Route::get('/business/delete/{business}' , "AdminDashboardController@deleteBusiness");

    Route::get('/business/verify/{business}' , "AdminDashboardController@verifyBusiness");

});


///////////////////////////////////////////////////////////////
//////////       Search Route Group      ///////////////
///////////////////////////////////////////////////////////////

Route::group(['name' => 'Search'] , function()
{
    Route::get('search' , 'SearchController@getSearchPage');

    Route::get('/search/map','SearchController@mapSearch');

    Route::get('/search/map/{latitude}/{longitude}/{distance?}' , 'SearchController@getMapSearch');

    Route::get('/search/results' , 'SearchController@getSearchResult');

    Route::get('/categories/{category}/{category_name?}', 'SearchController@getCategorySearch');

    Route::get('/categories' , function()
    {
        $cats = Category::all();
        $topRatedBusinesses = (new Rating())->topRatedBusinesses ;

        return view('search.categories' , [
            'categories' =>$cats,
            'popularBusinesses' => $topRatedBusinesses
        ]);

    });


});


///////////////////////////////////////////////////////////////
///////////     Image resources Route Group   //////////////////
///////////////////////////////////////////////////////////////

Route::group(['name' => 'File Routes'] , function()
{
    Route::get('/business/uploads/{url?}', 'ImageController@getBusinessUploads');

    Route::get('business/profilepic/{url}' , 'ImageController@getBusinessProfilePic');

    Route::get('/business/profile.jpg' , 'ImageController@getDefaultBusinessProfilePic');

});



///////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////              Test      Routes         ////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////
/*
 * Testing Eloquent relations for our models
 *
 */
Route::group(['name' => 'eloquent_relations' ,'middleware' => 'auth'] , function(){
    /*
     * Test routes for Eloquent relationships between models
     */
    Route::get('/businessowner' , ['middleware' => 'auth' , function(Business $business)
        {
           $user = $business->find(1)->user()->get();
           dump($user);
        }
    ]);//works


    Route::get('/bcategory' , function(Business $business)
    {
        $cats = $business->find(1)->categories()->get();
        foreach($cats as $cat)
        {
            echo $cat->category_name;
        }
    });//works

    Route::get('/busproducts' , function(Business $business)
    {
        $products = $business->find(1)->products();
        $products = $products->get();
        //$business->products()->get() ;
        foreach($products as $product)
        {
            dump($product);
        }

    });//worked

    Route::get('/getcatbusiness' , function()
    {
        $one  = Business::find(1)->first();
        $cats = $one->categories()->get();
        //dd($cats);
        foreach($cats as $category)
        {
            dump($cats);
        }
    });//worked

    Route::get('/address' , function(App\Address $address)
    {
        $user = User::find(1)->first();
        //dd($user);
        foreach($user->address()->get() as $add)
        {
            $add->zip_code = 0;
            $add->save();
        }
    });//works

    Route::get('/products' , function()
    {
        $products = Business::find(1)->first()->products();
        foreach($products as $product)
        {
            echo $product->name;
        }
    });//Works well..

    Route::get('/usermeta' , function()
    {
        $userMetas = UserMeta::where('user_id' , '=' , Auth::id())->get();
        foreach($userMetas as $userMeta)
        {
            echo $userMeta->role;
        }

        //OR access from the User model by below given code.. (comment above codes and uncomment the codes below)
        //$meta = User::find(Auth::user()->id)->userMeta()->get();
        //echo $meta;
    });//workd

    Route::get('factory' , function()
    {
        factory(App\User::class, 10)->create()->each(function(User $u) {
            //$u->userMeta()->save(factory(App\UserMeta::class)->make());
            //dump($u);
            $add = $u->address()->save(factory(App\Address::class)->make());
            dump($add);
            dump($u->address()->get() );
        });
    });//works

    Route::get('/addressable', function()
    {
        $add = Address::find(152);
        //dump($add->addressable);
        $b  = $add->addressable;
        dump($b);
    });//works.. gives the model instance of the owning model ie business, user, etc

    Route::get('/subcategories' , function()
    {
        $categories = Category::find(1);
        $sub = $categories->children;
        dump($categories);
        dump($sub);
    });//workd

    //Route::get('/categories' , function()
    //{
    //    $cats = Category::where('parent_id' , '=' , null)->get();
    //    //dump($cats);
    //    foreach($cats as $cat)
    //    {
    //        $child = $cat->children;
    //        dump($child);
    //        foreach($child as $item)
    //        {
    //            //dump($item->parent);
    //        }
    //    }
    //});//workd .. returns collection of child categories of each parent category

});


/*
 * Test routes
 * */
Route::group(['name' => 'testingroutes'] , function(){
    Route::get('/fbnb' , function(){
        config('app.env');
        echo config('najikme.formbindings.newbusiness.name');
    });

    Route::get("/template" , function(){
        return view('admin.template');
    });

    Route::get('/isadmin' , function(App\User $user){
        echo $user->isAdmin;

    });
    //Route::get('/isverified' , function(App\User $user)
    //{
    //    echo $user->verified;
    //
    //});


    //Route::get('dashboard', function()
    //{
    //    return view("dashboard.home");
    //});
    Route::get('result' , function(){
        return view("search.results");

    });

    Route::get('landing' , function(){
        return view("landing");

    });

    Route::get('gallery' , function(){
        return view("gallery");

    });

    Route::get('component' , function(){
        return view("component");

    });
    Route::get('assignpp' , function(){
        $businesses = Business::all();
        $replica    = $businesses[46];
        foreach($businesses as $business)
        {

            if(count($business->file) == 0)
            {
                //$avatar    = $request->file('business_profile_pic');
                //$extension = $avatar->getClientOriginalExtension();
                ////Naming convention: unix timestamp + file extension
                //$filename      = uniqid(time() , true);
                //$absolute_path = storage_path() . '/app/public/uploads/business/' . $filename . '.' . $extension;
                //Storage::makeDirectory('/public/uploads/business');
                //Image::make($avatar)->save($absolute_path);
                $business->file()->create(['filename'        => $replica->file->first()->filename ,
                                           'file_extension'  => $replica->file->first()->file_extension ,
                                           'meta_name'       => 'business_profile_pic' ,
                                           'absolute_path'   => $replica->file->first()->absolute_path ,
                                           'file_title'      => $replica->file->first()->file_title ,
                                           'description'     => 'Business profile picture' ,
                                           'file_url'        => '/business/uploads/' . $replica->file->first()->filename . '.' . $replica->file->first()->extension ,
                                           'mime_type'       => $replica->file->first()->mime_type ,
                                           'parent_dir_path' => storage_path() . '/app/public/uploads/business/' ,

                ]);

                dump($business->file);
            }
        }
    });

    Route::get('assignadd' , function(){
        $businesses = Business::all();
        $replica    = $businesses[46];
        foreach($businesses as $business)
        {

            if(count($business->address) == 0)
            {
                //$avatar    = $request->file('business_profile_pic');
                //$extension = $avatar->getClientOriginalExtension();
                ////Naming convention: unix timestamp + file extension
                //$filename      = uniqid(time() , true);
                //$absolute_path = storage_path() . '/app/public/uploads/business/' . $filename . '.' . $extension;
                //Storage::makeDirectory('/public/uploads/business');
                //Image::make($avatar)->save($absolute_path);
                $business->address()->create(['street_address' => $replica->address->first()->street_address ,
                                              'town'           => $replica->address->first()->town ,
                                              'state'          => $replica->address->first()->state ,
                                              'country'        => $replica->address->first()->country ,
                                              'zip_code'       => $replica->address->first()->zip_code ,
                                              'latitude'       => $replica->address->first()->latitude ,
                                              'longitude'      => $replica->address->first()->longitude ,

                ]);

            }
        }
    });


    Route::get('dfpromote/{business}' , ['middleware' => 'admin' ,
                                         function(Business $business){
                                             $promotions                    = $business->promotion ? : new Promotion();
                                             $promotions->business_id       = $business->id;
                                             $promotions->admin_id          = Auth::id();
                                             $promotions->promoted_at       = Carbon::now();
                                             $promotions->expires_at        = Carbon::now()->addHours(10 * 24);
                                             $promotions->promotion_period  = '11 days';
                                             $promotions->promotion_pricing = Promotion::pricing(10 * 24);
                                             $promotions->save();
                                             dump('success');
                                         }]);


    Route::get('globalrating' , function(){
        $businesses = Business::take(5)->get();

        foreach($businesses as $business)
        {
            $business->globalRating;
        }
        dump($businesses);
    });


    Route::get('lcs/{key}' , function($key){
        $key         = trim($key);
        $sequenceOne = str_split($key);//First sequence to compare for LCS
        if(strlen($key) == 1)
        {
            $businesses     = Business::where('name' , 'like' , $key . "%")->get(['id' , 'name']);
            $businessesNext = Business::where('name' , 'like' , "% " . $key . "%")->get(['id' , 'name']);

            //Changing collection to desired response result {
            $businesses->map(function($business){
                $business->priority = 1;//higher priority on search result in client's frontend
            });
            $businessesNext->map(function($business){
                $business->priority = 2;//lower priority on search result in client's frontend
            });
            $collection = collect($businesses)->merge($businessesNext)->reject(function($business , $key){
                return $key > 9;
            })->unique('id')->sortBy(function($business){
                return $business->priority;
            })->values();
            // }
            //dump($collection);
            return response($collection->toJson());
        } else
        {
            //get business names whose first letter matches with the key's first letter
            $businesses         = Business::where('name' , 'like' , $key[0] . "%")->get(['id' ,
                                                                                         'name']);//Compares equality of  first letter with database record's first letter
            $businessesNext     = Business::where('name' , 'like' , "% " . $key[0] . "%")->get(['id' , 'name']);
            $exactMatchBusiness = new Collection();
            if(strlen($key) > 3)
            {
                $exactMatchBusiness = Business::where('name' , 'like' , "%" . $key . "%")->get(['id' , 'name']);
                $exactMatchBusiness->map(function($business){
                    $business->priority = 0;
                    $business->type     = 'exact_match';
                });
            }
            $exactMatchBusiness->each(function($matchBusiness) use ($businesses){
                $businesses->each(function($business , $key) use ($matchBusiness , $businesses){
                    if($business->id == $matchBusiness->id)
                    {
                        unset($businesses[$key]);
                    }

                });
            });

            //Changing collection to desired response result {
            $businesses->map(function($business){
                $business->priority = 1;//higher priority on search result in client's frontend
                $business->type     = 'first_match';

            });
            $exactMatchBusiness->each(function($matchBusiness) use ($businessesNext){
                $businessesNext->each(function($business , $key) use ($matchBusiness , $businessesNext){
                    if($business->id == $matchBusiness->id)
                    {
                        unset($businessesNext[$key]);
                    }

                });
            });
            $businessesNext->map(function($business){
                $business->priority = 2;//lower priority on search result in client's frontend
                $business->type     = 'other_match';
            });

            $collection = collect($businesses)->merge($businessesNext)->unique('id')->sortBy(function($business){
                return $business->priority;
            })->values();

            //Perform LCS for each name of businesses
            $collection = $collection->each(function($business) use ($sequenceOne){
                //Convert each letter to small letters
                foreach($sequenceOne as $item)
                {
                    $item = strtolower($item);
                }

                $lcs = (new LcsSolver())->longestCommonSubsequence($sequenceOne , str_split(strtolower($business->name)));
                if(($size = count($lcs)))
                {
                    $business->lcsLength = $size;
                    $business->lcsItems  = $lcs;
                    $business->lcsSize   = $size;
                    $business->lcsString = implode($lcs);
                }
            });
            $collection = $collection->reject(function($business){
                if(isset($business->lcsLength))
                {
                    return $business->lcsLength < 2;
                }

                return true;
            });
            $collection = $collection->sortByDesc(function($business){
                $business->lcsLength;
            })->values()->sortBy(function($business){
                $business->priority;
            })->values();
            $collection = $exactMatchBusiness->merge($collection)->unique(function($business){
                return $business->id;
            })->sortBy(function($business){
                return $business->priority;
            })->values();

            return $collection->toJson();

        }

        //$a->sortBy($a->count());
        //usort($a[] , 'size');
    });

    Route::get('clcs' , function(){
        $lcs = (new SearchController())->longestCommonSubsequence(str_split('butwal durbarb') , str_split('durbar business'));
        dump($lcs);
    });
});