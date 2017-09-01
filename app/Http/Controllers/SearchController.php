<?php

namespace App\Http\Controllers;

use App\Business;
use App\Category;
use App\Http\Requests\SearchRequest;
use App\Promotion;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Str;

class SearchController extends Controller
{
    public function getSearchPage(Business $business)
    {
        $promotions = Promotion::get();
        $businessesPromoted = [];
        foreach($promotions as $promotion)
        {
            $curBusiness = $promotion->business;
            if($promotion->expires_at <= Carbon::now() )
            {
                $businessesPromoted = $curBusiness;
            }
        }
        return view('search.searchpage' , [
            'promotedBusinesses' =>$businessesPromoted,
            'categories' => Category::all() ,
            'recents' => $business-> orderBy('created_at', 'desc')->limit(5)->get()

        ]);

    }

    public function getSearchResult(SearchRequest $request)
    {
        $query          = $request->all();
        $businesses     = null;
        $metaSearchData = [];
        if($query['search_category'] == 0)
        {
            $businesses              = Business::where('name' , 'like' , '%' . $query['search_key'] . '%')->orWhere('description' , 'like' , '%' . $query['search_key'] . '%')->paginate(10);
            $metaSearchData['count'] = Business::where('name' , 'like' , '%' . $query['search_key'] . '%')->orWhere('description' , 'like' , '%' . $query['search_key'] . '%')->count();
        } else
        {
            $businesses              = Business::where('name' , 'like' , '%' . $query['search_key'] . '%')->orWhere('description' , 'like' , '%' . $query['search_key'] . '%')->where('category_id' , $query['search_category'])->paginate(10);
            $metaSearchData['count'] = Business::where('name' , 'like' , '%' . $query['search_key'] . '%')->orWhere('description' , 'like' , '%' . $query['search_key'] . '%')->where('category_id' , $query['search_category'])->count();

        }
        $metaSearchData['count'] = count($businesses);

        return view('search.results' , [

            'businesses'     => $businesses ,
            'metaSearchData' => $metaSearchData ,
            'categories'     => Category::all()

        ]);
    }

    public function getCategorySearch(Category $category)
    {
        $businesses = Business::where('category_id' , $category->id)->paginate(15)->withPath('/categories/' . $category->id . '/' . Str::slug($category->name));;
        $metaSearchData['count'] = count(Business::where('category_id' , $category->id)->get());

        return view('search.categoryresult' , [

            'businesses'     => $businesses ,
            'metaSearchData' => $metaSearchData ,
            'categories'     => Category::all()]);
    }
}
