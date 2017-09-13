@extends('layouts.dashboard')

@section('content')

    <section class="content">

        <ol class="breadcrumb">
            <li><a href="index.html"><i class="fa fa-home fa-fw"></i> Home</a></li>
            <li class="active">All businesses</li>
        </ol>

        <div class="header">
            <div class="col-md-12">
                <h3 class="header-title">Business Tables</h3>
                <p class="header-info">All businesses</p>
            </div>
        </div>

        <!-- CONTENT -->
        <div class="main-content">
            <div class="row">
                <div class="col-md-12">
                    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-hover datatable">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Email</th>
                            <th>Website</th>
                            <th>Verified</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($businesses as $business)
                            <tr class="gradeA odd" role="row">
                                <td class="sorting_1">{{$business->id}}</td>
                                <td>{{$business->name}}</td>
                                <td>{{substr($business->description, 0 , 130)}}</td>
                                <td class="center">{{$business->email}}</td>
                                <td class="center">{{$business->website}}</td>
                                <td class="center">{{$business->verified}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- END: CONTENT -->
    </section>
@endsection