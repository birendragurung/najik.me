<?php
use App\Category;
use Illuminate\Support\Str;

$categories = isset($categories)?$categories: Category::all();
?>
        <!-- Sidebar Column -->
<div class="col-xs-12 col-md-12 col-lg-12 mb-4">
    <div class="list-group">
        <form class="filter-detail-page" action="/search" autocomplete="on" method="get">

            <input type="text" class="form-control col-md-4 list-group-item mb-3 mt-3" placeholder="Keyword"  value="{{old('search_key')}}" name="search_key" required="true">
            <select class="form-control list-group-item mb-3 mt-3" name="search_category" required="true">
                <option value="0">All categories</option>

                @foreach($categories as $category)
                    <option value="{{$category->id }}">{{$category->name }}</option>
                @endforeach

            </select>
            <div class="mb-3 mt-3">
                <button type="submit" class="btn btn-primary btn-block mb-3 mt-3">search</button>
            </div>
        </form>

    </div>
</div>