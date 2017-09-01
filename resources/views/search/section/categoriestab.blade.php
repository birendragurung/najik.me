<?php
use Illuminate\Support\Str;
?><!-- Sidebar Column -->
<div class=" col-lg-12 mb-4 category-sidebar-tab">
    <h3>Browse categories</h3>
    <div class="list-group">
        @foreach($categories as $category)
            <a href="{!!url('/categories/' . $category->id . '/' . Str::slug($category->name,'-') )!!}" class="list-group-item">{{$category->name}}</a>
        @endforeach
    </div>
</div>
