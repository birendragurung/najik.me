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
use App\Promotion;
use App\Rating;
use App\User;
use App\UserMeta;
use Carbon\Carbon;
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

Route::group(['name'=>'home routes', "middleware" =>'auth' ], function()
{

    Route::get('/' , "HomeController@index");

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

    Route::get('/business/rate/{business}' , function(Business $business)
    {
        if($business->user_id == Auth::id() )
        {
            //return res
        }
        $rate = (int)Request::get('rate');
        $validator = Validator::make(['rate' => $rate] , [
            'rate' => 'int|min:0|max:5'
        ]);
        if($validator->fails())
        {
            return response($validator->errors()->all(), 406);
        }
        //dd($business->rating->where('user_id', Auth::id()) );
        /*$rating = $business->rating ? $business->rating->where('user_id', Auth::id())->first() : $business->rating->create([

            'user_id' => Auth::id() ,
            'rating'  => $rate ,

        ]);*/

        $rating = Rating::where('user_id' , Auth::id())->where('business_id' , $business->id)->first()?:new Rating([
            'user_id' => Auth::id() ,
            'rating'  => $rate ,
            'business_id' => $business->id ,
            'meta_name' =>'user_rating'
        ]) ;
        $rating->rating = $rate;
        $rating->save();
        return response('Rated:' . $rate);
    });

    Route::get('/business/rate/delete/{business}' , function(Business $business)
    {
        $rate =  $business->ratings()->where('meta_name','user_rating')->where('user_id',Auth::id())/*->get()*/ ;
        return ($rate->first() and $rate->first()->delete()) ?"Successfully deleted rating":'No rating found';
    });
});


///////////////////////////////////////////////////////////////
//////////  Business Routes Group with No middleware    ///////
///////////////////////////////////////////////////////////////

Route::group(['name' => 'Business public routes'] , function()
{
    Route::get('/business/{id}' , 'UserBusinessController@getBusiness')->where('id', '[0-9]+');

    Route::get('profile2' , function()
    {
        return view('business.profile2');
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

});


///////////////////////////////////////////////////////////////
//////////       Search Route Group      ///////////////
///////////////////////////////////////////////////////////////

Route::group(['name' => 'Search'] , function()
{
    Route::get('search' , 'SearchController@getSearchPage');

    Route::get('/search/map','SearchController@mapSearch');

    Route::get('/search/map/{latitude}/{longitude}/{distance?}' , 'SearchController@getMapSearch');

    Route::get('/search/{key}/{category?}' , 'SearchController@getSearchResult');

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
Route::group(['name' => 'testingroutes'] , function()
{
    Route::get('/fbnb' , function()
    {
        config('app.env');
        echo config('najikme.formbindings.newbusiness.name');
    });

    Route::get("/template" , function()
    {
        return view('admin.template');
    });

    Route::get('/isadmin' , function(App\User $user)
    {
         echo $user->isAdmin;

    });
    //Route::get('/isverified' , function(App\User $user)
    //{
    //    echo $user->verified;
    //
    //});
});

Route::get('dashboard', function()
{
    return view("dashboard.home");
});
Route::get('result' , function()
{
    return view("search.results");

});

Route::get('landing',  function()
{
    return view("landing");

});

Route::get('gallery',  function()
{
    return view("gallery");

});

Route::get('component',  function()
{
    return view("component");

});
Route::get('assignpp' , function()
{
    $businesses = Business::all();
    $replica = $businesses[46];
    foreach($businesses as $business)
    {

        if(count($business->file) ==0)
        {
            //$avatar    = $request->file('business_profile_pic');
            //$extension = $avatar->getClientOriginalExtension();
            ////Naming convention: unix timestamp + file extension
            //$filename      = uniqid(time() , true);
            //$absolute_path = storage_path() . '/app/public/uploads/business/' . $filename . '.' . $extension;
            //Storage::makeDirectory('/public/uploads/business');
            //Image::make($avatar)->save($absolute_path);
            $business->file()->create([
                'filename'      => $replica->file->first()->filename  ,
                'file_extension' => $replica->file->first()->file_extension ,
                'meta_name'     => 'business_profile_pic' ,
                'absolute_path' => $replica->file->first()->absolute_path  ,
                'file_title'    => $replica->file->first()->file_title ,
                'description'   => 'Business profile picture' ,
                'file_url'      => '/business/uploads/' . $replica->file->first()->filename  . '.'. $replica->file->first()->extension ,
                'mime_type'     => $replica->file->first()->mime_type ,
                'parent_dir_path'=>  storage_path() . '/app/public/uploads/business/',

            ])    ;

            dump($business->file);
        }
    }
});

Route::get('assignadd' , function()
{
    $businesses = Business::all();
    $replica = $businesses[46];
    foreach($businesses as $business)
    {

        if(count($business->address) ==0)
        {
            //$avatar    = $request->file('business_profile_pic');
            //$extension = $avatar->getClientOriginalExtension();
            ////Naming convention: unix timestamp + file extension
            //$filename      = uniqid(time() , true);
            //$absolute_path = storage_path() . '/app/public/uploads/business/' . $filename . '.' . $extension;
            //Storage::makeDirectory('/public/uploads/business');
            //Image::make($avatar)->save($absolute_path);
            $business->address()->create([
                'street_address'      => $replica->address->first()->street_address  ,
                'town' => $replica->address->first()->town ,
                'state'     => $replica->address->first()->state ,
                'country' => $replica->address->first()->country  ,
                'zip_code'    => $replica->address->first()->zip_code ,
                'latitude'   => $replica->address->first()->latitude ,
                'longitude'      =>$replica->address->first()->longitude ,

            ])    ;

        }
    }
});


Route::get('dfpromote/{business}' , ['middleware' => 'admin' ,function(Business $business)
{
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


Route::get('globalrating' , function()
{
    $businesses = Business::take(5)->get() ;

    foreach($businesses as $business)
    {
        $business->globalRating ;
    }
    dump($businesses);
});