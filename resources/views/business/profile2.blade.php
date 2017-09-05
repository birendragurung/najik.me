@extends('layouts.app',['hideform'=>true ])
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
@push('header-scripts')
        <!-- Easy Responsive Tabs -->
<link rel="stylesheet" href="css/easy-responsive-tabs.css">

@endpush
<div class="container">
    <div class="row">
        <div class="col-lg-9">

            <div class="card mt-4">
                <img class="card-img-top img-fluid" src="http://placehold.it/900x400" alt="">
                <div class="card-body">
                    <h3 class="card-title">Product Name</h3>
                    <h4>$24.99</h4>
                    <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sapiente dicta fugit fugiat hic aliquam itaque facere, soluta. Totam id dolores, sint aperiam sequi pariatur praesentium animi perspiciatis molestias iure, ducimus!</p>
                    <span class="text-warning">★ ★ ★ ★ ☆</span>
                    4.0 stars
                </div>
            </div>
            <!-- /.card -->

            <div class="card card-outline-secondary my-4">
                <div class="card-header">
                    Product Reviews
                </div>
                <div class="card-body">
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Omnis et enim aperiam inventore, similique necessitatibus neque non! Doloribus, modi sapiente laboriosam aperiam fugiat laborum. Sequi mollitia, necessitatibus quae sint natus.</p>
                    <small class="text-muted">Posted by Anonymous on 3/1/17</small>
                    <hr>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Omnis et enim aperiam inventore, similique necessitatibus neque non! Doloribus, modi sapiente laboriosam aperiam fugiat laborum. Sequi mollitia, necessitatibus quae sint natus.</p>
                    <small class="text-muted">Posted by Anonymous on 3/1/17</small>
                    <hr>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Omnis et enim aperiam inventore, similique necessitatibus neque non! Doloribus, modi sapiente laboriosam aperiam fugiat laborum. Sequi mollitia, necessitatibus quae sint natus.</p>
                    <small class="text-muted">Posted by Anonymous on 3/1/17</small>
                    <hr>
                    <a href="#" class="btn btn-success">Leave a Review</a>
                </div>
            </div>
            <!-- /.card -->

        </div>
        <!-- /.col-lg-9 -->
        <div class="col-lg-3">
        @include("search.section.search-sidebar")
        @include("search.section.categoriestab")
        </div>

    </div>
    <div class="col-md-12 animate-box fadeInUp animated">
        <div id="fh5co-tab-feature-vertical" class="fh5co-tab resp-vtabs hor_1" style="display: block; width: 100%; margin: 0px;">
            <ul class="resp-tabs-list hor_1" style="margin-top: 3px;">
                <li class="resp-tab-item hor_1 resp-tab-active" aria-controls="hor_1_tab_item-0" role="tab" style="background-color: white;">
                    <i class="fh5co-tab-menu-icon ti-ruler-pencil"></i>Design
                </li>
                <li class="resp-tab-item hor_1" aria-controls="hor_1_tab_item-1" role="tab" style="">
                    <i class="fh5co-tab-menu-icon ti-paint-bucket"></i> Branding
                </li>
                <li class="resp-tab-item hor_1" aria-controls="hor_1_tab_item-2" role="tab" style="">
                    <i class="fh5co-tab-menu-icon ti-shopping-cart"></i> E-Commerce
                </li>
            </ul>
            <div class="resp-tabs-container hor_1">
                <h2 class="resp-accordion hor_1 resp-tab-active" role="tab" aria-controls="hor_1_tab_item-0" style="background: none white;">
                    <span class="resp-arrow ti-angle-down"></span><i class="fh5co-tab-menu-icon ti-ruler-pencil"></i>Design
                </h2>
                <div class="resp-tab-content hor_1 resp-tab-content-active" aria-labelledby="hor_1_tab_item-0" style="display:block">
                    <div class="row">
                        <div class="col-md-12">
                            <h2 class="h3">Aesthetic Design</h2>
                        </div>
                        <div class="col-md-6">
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Assumenda quis deserunt dolorem, debitis cupiditate nihil velit dolores, inventore voluptatem delectus quos atque similique natus eaque qui, nisi repudiandae dolore sit! Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cum aut maxime eius magnam. Ipsa qui consequatur laborum culpa recusandae ullam repellendus, quod cum nemo consequuntur quidem labore minima dignissimos, eum!</p>
                        </div>
                        <div class="col-md-6">
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Odio voluptatem, vitae nesciunt ad hic quam quisquam sit possimus officia ratione. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Molestias, ex. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ex fuga illum necessitatibus consequuntur aspernatur omnis quidem ut, similique esse assumenda.</p>
                        </div>
                    </div>
                </div>
                <h2 class="resp-accordion hor_1" role="tab" aria-controls="hor_1_tab_item-1" style="">
                    <span class="resp-arrow ti-angle-down"></span><i class="fh5co-tab-menu-icon ti-paint-bucket"></i> Branding
                </h2>
                <div class="resp-tab-content hor_1" aria-labelledby="hor_1_tab_item-1">
                    <div class="row">
                        <div class="col-md-12">
                            <h2 class="h3">Branding &amp; Identity</h2>
                        </div>
                        <div class="col-md-6">
                            <p>Nam tristique porttitor neque, sit amet aliquet metus ultricies non. Vestibulum lacinia ante sit amet enim iaculis tempus. Nulla aliquam tincidunt leo, et consequat justo viverra id. Maecenas lacinia libero vel iaculis tincidunt. Quisque luctus massa eu sodales vehicula. Duis gravida at nunc sit amet sagittis. Fusce pulvinar scelerisque enim, vel interdum erat ullamcorper a. Cras elementum mauris justo, quis lacinia erat mollis sed. Donec malesuada odio eu metus consequat interdum. </p>
                        </div>
                        <div class="col-md-6">
                            <p>In varius, ex ut tincidunt tempor, nunc nisi commodo quam, vel volutpat ex eros id tellus. Morbi cursus libero mi. In condimentum leo in libero volutpat rutrum. Ut pellentesque finibus lacus, sed imperdiet ex tincidunt vel. Proin et blandit nisl, dapibus faucibus urna. Praesent et nisi dictum, placerat purus eget, varius est. Suspendisse potenti. Curabitur blandit faucibus auctor.</p>
                        </div>
                    </div>
                </div>
                <h2 class="resp-accordion hor_1" role="tab" aria-controls="hor_1_tab_item-2" style="">
                    <span class="resp-arrow ti-angle-down"></span><i class="fh5co-tab-menu-icon ti-shopping-cart"></i> E-Commerce
                </h2>
                <div class="resp-tab-content hor_1" aria-labelledby="hor_1_tab_item-2">
                    <div class="row">
                        <div class="col-md-12">
                            <h2 class="h3">Online Shop</h2>
                        </div>
                        <div class="col-md-6">
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Assumenda quis deserunt dolorem, debitis cupiditate nihil velit dolores, inventore voluptatem delectus quos atque similique natus eaque qui, nisi repudiandae dolore sit! Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cum aut maxime eius magnam.</p>
                        </div>
                        <div class="col-md-6">
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Odio voluptatem, vitae nesciunt ad hic quam quisquam sit possimus officia ratione. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Molestias, ex. Lorem ipsum dolor sit amet.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('footerscripts')
        <!-- Easy Responsive Tabs -->
<script src="js/easyResponsiveTabs.js"></script>
<script>
$('#fh5co-tab-feature-vertical').easyResponsiveTabs();
</script>
@endpush
@endsection