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
use App\User;
use App\UserMeta;
use Illuminate\Support\Facades\Auth;
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

Route::get('/home' , "HomeController@home");

Route::get("/logout" , function()
{
    if(Auth::user())
    {
        Auth::logout();
    }

    return redirect('/login');
});

Route::get('/home' , 'HomeController@index')->name('home');


Route::get('admin_area' , ['middleware' => 'admin' ,function(){
                               //
}]);

Route::get('/home' , 'HomeController@index')->name('home');

//////////////////////User Routes Group////////////////////////////////////////////////////////////////////////
Route::group(['name' => 'user'] , function()
{
    //TODO add user profile, my businesses list page

});




//////////////////////Business Routes Group////////////////////////////////////////////////////////////////////////
Route::group(['name' => 'Business Routes'] , function()
{
    //TODO  business profile page, edit business page ,

    Route::get('/business/add' , ['middleware' => 'auth' ,
                                  function(User $user)
                                  {
                                      $myBusinesses = Auth::user()->businesses;

                                      return view('business.newbusiness' , ['user'         => User::find(Auth::id()) ,
                                                                            'myBusinesses' => $myBusinesses ,]);
                                  }])->name('addplace');

    Route::post('/business/add' , 'UserBusinessController@addNewBusiness');

    Route::get('/business/{id}' , 'UserBusinessController@getBusiness');

    Route::get('/business/edit/{business}' , function(Business $business)
    {
        $address  = $business->address;

        return view('business.editbusiness', [
            'business' =>$business,
            'address' => $address,
            'myBusinesses' => Business::where('id' , '=' , Auth::id())->get() ,
        ]);
    });
});


////////File resources Route Group////////////////////////////////////////////////////////////////////////////
Route::group(['name' => 'File Routes'] , function()
{
    //Route::resource()
});




////////Administrator Route Group////////////////////////////////////////////////////////////////////////////
Route::group(['name' => 'Admin Dashboard', 'middleware' => 'admin' ] , function()
{
    Route::get('/admin/dashboard' , 'AdminDashboardController@dashboardHome');
});






///////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////Test Routes////////////////////////////////////////////////////////////////
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
        $add = Address::find(102);
        //dump($add->addressable);
        dump($add->addressable() );
    });
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