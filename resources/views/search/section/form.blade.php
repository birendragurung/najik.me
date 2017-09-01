<?php
use App\Category;

$categories = Category::all();
$hide = (isset($hidesearchform) and $hidesearchform == true)? true: false;
?>
@if($hide == false)
<form class="filter-detail-page" action="/search" autocomplete="on" method="post">
    {{csrf_field()}}
    <div class="col-md-offset-2 col-sm-12 col-md-3">
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Keyword" name="search_key" required="true">
        </div><!-- /.form-group -->
    </div><!-- /.col-* -->

    <div class="col-sm-12 col-md-3">
        <div class="form-group">
            <select class="form-control bs-select-hidden" name="search_category" required="true">
                <option value="0">All categories</option>

                @foreach($categories as $category)
                    <option value="{{$category->id }}">{{$category->name }}</option>
                @endforeach

            </select>
        </div><!-- /.form-group -->
    </div><!-- /.col-* -->


    <div class="col-sm-12 col-md-2">
        <button type="submit" class="btn btn-primary btn-block">search again</button>
    </div><!-- /.col-* -->
</form>
@endif