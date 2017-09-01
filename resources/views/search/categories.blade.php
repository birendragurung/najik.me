@extends('layouts.app')
<?php
use App\Category;
use Illuminate\Support\Str;
$categories = Category::all();
?>
@section('categoriesSidebar')
        <!-- Sidebar Column -->
<div class="col-lg-3 mb-4">
    <div class="list-group">
        @foreach($categories as $category)
            <a href="{!!url('/categories/' . $category->id . '/' . Str::slug($category->name,'-') )!!}" class="list-group-item">{{$category->name}}</a>
        @endforeach
    </div>
</div>
@endsection
@section('content')
    <div class="container">

        @yield('categoriesSidebar')

        <div class="col-md-6">
            <div class="categories-wrapper">
                <h2 class="text-center">Popular businesses</h2>
                <div class="dock">

                </div>
            </div>
        </div>
    </div>
@endsection