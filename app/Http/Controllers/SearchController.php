<?php

namespace App\Http\Controllers;

use App\Address;
use App\Business;
use App\Category;
use App\Http\Requests\SearchRequest;
use App\Promotion;
use App\Rating;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SearchController extends Controller
{
    public function getSearchPage(Business $business)
    {
        $promotedBusinesses = $this->getPromotedBusinesses();

        return view('search.searchpage' , [

            'promotedBusinesses' => $promotedBusinesses ,
            'categories'         => Category::all() ,
            'recents'            => $business->orderBy('created_at' , 'desc')->limit(10)->get()

        ]);
    }

    public function getSearchResult(Request $request)
    {
        $query          = ['search_key'      => $request->get('search_key') ,
                           'search_category' => $request->get('category')];
        $businesses     = null;
        $metaSearchData = [];
        if(isset($query['search_category']) && $query['search_category'] == 0)
        {
            $businesses = Business::where('name' , 'like' , '%' . $query['search_key'] . '%')->orWhere('description' , 'like' , '%' . $query['search_key'] . '%')->get();
            foreach($businesses as $business)
            {
                $this->getBusinessRatings($business);
            }
            $metaSearchData['count'] = $businesses->count();
        } else
        {
            $businesses = Business::where('name' , 'like' , '%' . $query['search_key'] . '%')->orWhere('description' , 'like' , '%' . $query['search_key'] . '%')->where('category_id' , $query['search_category'])->get();
            foreach($businesses as $business)
            {
                $this->getBusinessRatings($business);
            }
            $metaSearchData['count'] = $businesses->count();

        }
        //$metaSearchData['count'] = count($businesses);
        if(count($businesses) == 0)
        {
            $promotedBusinesses = $this->getPromotedBusinesses();
        }
        $data = ['businesses'     => $businesses ,
                 'metaSearchData' => $metaSearchData ,
                 'categories'     => Category::all() ,];
        if(isset($promotedBusinesses))
        {
            $data['promotedBusinesses'] = $promotedBusinesses;
        }

        return view('search.results' , $data);
    }

    public function getCategorySearch(Category $category)
    {
        $categoryBusinesses = Business::where('category_id' , $category->id)
            ->paginate(15)
            ->withPath('/categories/' . $category->id . '/' . Str::slug($category->name));

        $metaSearchData['count'] = count(Business::where('category_id' , $category->id)->get());
        foreach($categoryBusinesses as $business)
        {
            $business->rating = count($business->ratings) ? $business->ratings()
                ->where('user_id' , Auth::id())
                ->first() : 0; // get rating of current user of each business
            $this->getBusinessRatings($business);

        }
        $topRatedBusinesses = (new Rating())->topRatedBusinesses;
        foreach($topRatedBusinesses as $business)
        {
            $this->getBusinessRatings($business);
        }

        return view('search.categoryresult' , [

            'popularBusinesses' => $topRatedBusinesses ,
            'businesses'        => $categoryBusinesses ,
            'metaSearchData'    => $metaSearchData ,
            'categories'        => Category::all()]);
    }

    public function mapSearch($distance = 30 , $latitude = -62.8652 , $longitude = 44.5256)
    {

        //REF: https://stackoverflow.com/a/574736/5350097 ->Haversine formula
        $addresses = Address::select(DB::raw('*, ( 6371 * acos( cos( radians(' . $latitude . ') ) * cos( radians( latitude ) ) * cos( radians(longitude ) - radians(' . $longitude . ') ) + sin( radians(' . $latitude . ') ) * sin( radians( latitude ) ) ) ) AS distance'))
            ->having('distance' , '<' , $distance)
            ->orderBy('distance')
            ->offset(0)
            ->limit(20)
            ->get();
        //dd($addresses);
        $businesses              = Business::take(5)->get();
        $metaSearchData['count'] = count($businesses);

        //This gets current user's rating of above businesses
        foreach($businesses as $business)
        {
            $business->rating = count($business->ratings)
                ? $business->ratings()
                    ->where('user_id' , Auth::id())
                    ->first() : 0; // get rating of current user of each business
            //getting user's rating of the business
        }

        return view('search.searchmap' , [
            'locationBasedSearchQueried' =>true,

            'businesses'     => $businesses ,
            'metaSearchData' => $metaSearchData ,
            'categories'     => Category::all()]);
    }

    /*
     * Get nearby businesses
     * Get Top rated businesses
     * */
    public function getMapSearch($latitude = 27.684 , $longitude = 83.462 , $distance = 30 , $category = null)
    {
        $category = $category != null? Category::where('id' , $category)->first() : null;
        $nearbyBusinesses = $this->nearbyBusinesses($latitude , $longitude , $distance);
        //dd($nearbyBusinesses);
        //Fetch rating for each nearby businesses
        foreach($nearbyBusinesses as $business)
        {
            if(!($business->category && $business->category->id == $category->id))
            {
                $business = null;
            }
            else
            {
                $this->getBusinessRatings($business);
            }
        }
        $nearbyBusinesses->sortBy(function($b){
            $b->distance;
        });
        //dump($nearbyBusinesses);

        $topRatedBusinesses = (new Rating())->topRatedBusinesses;
        //dd($topRatedBusinesses);

        //$metaSearchData['count'] = count($businesses);

        return view('search.searchmap' , [
            'locationBasedSearchQueried' =>true,
            'topRatedBusinesses' => $topRatedBusinesses ,
            "nearbyBusinesses"   => $result =  $nearbyBusinesses->slice(0,30)  ,
            'businesses'         => $nearbyBusinesses ,
            //'metaSearchData'     => $metaSearchData ,
            'categories'         => Category::all()

        ]);
    }


    /*
     * Protected functions
     * */

    protected function nearbyBusinesses($latitude = -62.8652 , $longitude = 44.5256 , $distance = 30)
    {
        $nearbyAddresses  = Address::select(DB::raw('*, ( 6371 * acos( cos( radians(' . $latitude . ') ) * cos( radians( latitude ) ) * cos( radians(longitude ) - radians(' . $longitude . ') ) + sin( radians(' . $latitude . ') ) * sin( radians( latitude ) ) ) ) AS distance'))
            ->where('entity_type' , Business::class)
            ->having('distance' , '<' , $distance)
            ->orderBy('distance')
            ->get();
        $nearbyBusinesses = new Collection();
        foreach($nearbyAddresses as $address)
        {
            if($address->addressable)
            {
                $address->addressable->distance = $address->distance < 1 ?number_format( $address->distance * 1000,0 ). ' meters from here' : number_format($address->distance , 2) . " km from here";
                $nearbyBusinesses[]             = $address->addressable;
            }
        }
        foreach($nearbyBusinesses as $business)
        {
            $this->getBusinessRatings($business);
        }

        return $nearbyBusinesses;
    }

    public function getBusinessRatings(Business &$business)
    {
        //Only authenticated user will have myRating property and they don't have myRating property for their own business
        if(Auth::user() && Auth::id() != $business->user->id)
        {
            //dd(Rating::select(DB::raw('* , avg(rating) as avgrate'))->where('meta_name' , "user_rating")->where('business_id' , $business->id)->first()->avgrate );
            $business->myRating = Rating::where('user_id' , Auth::id())
                ->where('meta_name' , 'user_rating')
                ->where('business_id' , $business->id)
                ->first()
                ? Rating::where('user_id' , Auth::id())
                    ->where('meta_name' , 'user_rating')
                    ->where('business_id' , $business->id)
                    ->first()
                    ->rating
                : 0;
        }
        $business->rateCounts = Rating::select(DB::raw('* , avg(rating) as avgrate'))
            ->where('meta_name' , "user_rating")
            ->where('business_id' , $business->id)
            ->groupBy('business_id')
            ->count();
        //assign rating to business model instance by fetching from Rating model of the associated business
        $business->avgRating = Rating::select(
            DB::raw('* , avg(rating) as avgrate'))
            ->where('meta_name' , "user_rating")
            ->where('business_id' , $business->id)
            ->groupBy('business_id')
            ->first()
            ? number_format(
                Rating::select(
                    DB::raw('* , avg(rating) as avgrate'))
                    ->where('meta_name' , "user_rating")
                    ->where('business_id' , $business->id)
                    ->groupBy('business_id')
                    ->first()
                    ->avgrate
                , 1) : 0;

        //dd($business);
        return $business;
    }

    public function topRatedBusinesses()
    {
        $topRatings = Rating::select(DB::raw('* , avg(rating) as avgrate'))->where('meta_name' , "user_rating")->groupBy('business_id')->orderBy('avgrate' , 'desc')->limit(10)->get();
        //dd($topRatings);
        $topRatedBusinesses = new Collection();
        foreach($topRatings as $topRating)
        {
            if($topRating->business)
            {
                $topRating->business->avgRating = $topRating->avgrate;
                $topRatedBusinesses[]           = $topRating->business;
            } else
            {
                $topRating->delete();
                //if no business was found, you should delete this inconsistent row from database
            }
        }

        return $topRatedBusinesses;
    }

    public function getPromotedBusinesses()
    {
        $promotions = Promotion::where('expires_at' , '>' , Carbon::now())->get();

        $promotedBusinesses = new Collection();
        foreach($promotions as $promotion)
        {
            if(!$promotion->business)
            {
                $promotion->delete();
                continue;
            }
            $thisBusiness = $promotion->business;
            $this->getBusinessRatings($thisBusiness);

            $promotedBusinesses[] = $promotion->business;
        }

        return $promotedBusinesses;
    }

    public function lcsSearch($key)
    {
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

                $lcs = $this->longestCommonSubsequence($sequenceOne , str_split(strtolower($business->name)));
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
    }

    public function longestCommonSubsequence(array $sequenceA , array $sequenceB)
    {
        $m = count($sequenceA);
        $n = count($sequenceB);

        // $a[$i][$j] = length of LCS of $sequenceA[$i..$m] and $sequenceB[$j..$n]
        $a = array();

        // compute length of LCS and all subproblems via dynamic programming
        for($i = 0 ; $i < $m ; $i++)
        {
            for($j = 0 ; $j < $n ; $j++)
            {
                if($sequenceA[$i] == $sequenceB[$j])
                {
                    $a[$i][$j] = (isset($a[$i - 1][$j - 1]) ? $a[$i - 1][$j - 1] : 0) + 1;
                } else
                {
                    $a[$i][$j] = max((isset($a[$i - 1][$j]) ? $a[$i - 1][$j] : 0) , (isset($a[$i][$j - 1]) ? $a[$i][$j - 1] : 0));
                }
            }
        }

        // recover LCS itself
        $i   = $m - 1;
        $j   = $m - 1;
        $lcs = array();

        while($i >= 0 && $j >= 0)
        {
            if($sequenceA[$i] == $sequenceB[$j])
            {
                $lcs[] = $sequenceA[$i];

                $i--;
                $j--;
            } elseif((isset($a[$i - 1][$j]) ? $a[$i - 1][$j] : 0) >= (isset($a[$i][$j - 1]) ? $a[$i][$j - 1] : 0))
            {
                $i--;
            } else
            {
                $j--;
            }
        }

        return array_reverse($lcs);
    }
}
