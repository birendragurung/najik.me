<?php
use App\Category;
use Illuminate\Support\Str;

$categories = Category::all();
?>
        <!-- Sidebar Column -->
<div class="col-lg-12 mb-4">
    <div class="list-group">
        <form class="filter-detail-page" action="/search" autocomplete="on" method="post">
            {{csrf_field()}}

            <input type="text" class="form-control list-group-item mb-3 mt-3" placeholder="Keyword" name="search_key" required="true">
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