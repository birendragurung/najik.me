<?php
use App\Category;
use Illuminate\Support\Str;
$categories = isset($categories)?$categories: Category::all();
?><!-- Sidebar Column -->
<div class="col-xs-12 col-sm-12 col-lg-12 mb-4 category-sidebar-tab">
    <h3>Browse categories</h3>
    <div class="list-group">
        @foreach($categories as $category)
            <a href="{!!url('/categories/' . $category->id . '/' . Str::slug($category->name,'-') )!!}" class="list-group-item">{{$category->name}}</a>
        @endforeach
    </div>
</div>
