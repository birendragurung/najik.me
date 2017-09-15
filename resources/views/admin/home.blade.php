<?php
use Carbon\Carbon;
?>
@extends('layouts.dashboard')

@section('content')
    <section class="content">

        <ol class="breadcrumb">
            <li class="active"><i class="fa fa-home fa-fw"></i> Home</li>
        </ol>

        <div class="header">
            <div class="col-md-12">
                <h3 class="header-title">Dashboard</h3>
                <p class="header-info">Overview</p>
            </div>
        </div>

        <!-- CONTENT -->
        <div class="main-content">

            <div class="row">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-body">
                            <ul class="col-md-12 stats">
                                <li class="stat col-md-2 col-sm-4 col-xs-6">
                                    <span><b class="value">{{$newUserCount}}</b> </span>
                                    <em>New Users</em>
                                </li>
                                <li class="stat col-md-2 col-sm-4 col-xs-6">
                                    <span><b class="value">{{App\User::all()->count() }}</b> </span>
                                    <em>Total users</em>
                                </li>
                                <li class="stat col-md-2 col-sm-4 col-xs-6">
                                    <span><b class="value">{{$newBusinessCount}}</b> </span>
                                    <em>New Businesses</em>
                                </li>
                                <li class="stat col-md-2 col-sm-4 col-xs-6">
                                    <span><b class="value">{{$totalBusinessCount}}</b> </span>
                                    <em>Total listed businesses</em>
                                </li>
                                <li class="stat col-md-2 col-sm-4 col-xs-6">
                                    <span><b class="value">{{$verifiedUsersCount}}</b> </span>
                                    <em>Total verified users</em>
                                </li>
                                <li class="stat col-md-2 col-sm-4 col-xs-6">
                                    <span><b class="value">{{$verifiedBusinessCount}}</b> </span>
                                    <em>Total verified businesses</em>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="panel ">
                        <div class="panel-heading">
                            <h3 class="panel-title">New user signups</h3>
                        </div>
                        <div class="panel-body">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th class="col-md-4">ID</th>
                                    <th class="col-md-4">User</th>
                                    <th class="col-md-4">Created</th>
                                    <th class="col-md-4">Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($newUsers as $user)
                                    <tr>
                                        <td>{{$user->id }}</td>
                                        <td>{{$user->name }}</td>
                                        <td>{{$user->created_at->diffForHumans() }}</td>
                                        <td class="center">
                                            <?php
                                            $label = '';
                                            if($user->verified == 'yes')
                                            {
                                                $label = 'label-success';
                                            } elseif($user->verified == 'pending' )
                                            {
                                                $label = 'label-warning';
                                            } elseif($user->verified = 'no' )
                                            {
                                                $label = 'label-default';
                                            }
                                            ?>
                                            <span class="label {{$label}}">{{$user->verified}}</span>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">Latest business listings</h3>
                        </div>
                        <div class="panel-body">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th class="col-md-4">ID</th>
                                    <th class="col-md-4">Name</th>
                                    <th class="col-md-4">Created</th>
                                    <th class="col-md-4">Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($newBusinesses as $business)
                                    <tr>
                                        <td>{{$business->id }}</td>
                                        <td><a href="/business/{{$business->id}}">{{$business->name}}</a></td>
                                        <td>{{$business->created_at->diffForHumans() }}</td>
                                        <td class="center">
                                            <?php
                                            $label = '';
                                            if($business->verified == 'yes')
                                            {
                                                $label = 'label-success';
                                            } elseif($business->verified == 'pending' )
                                            {
                                                $label = 'label-warning';
                                            } elseif($business->verified = 'no' )
                                            {
                                                $label = 'label-default';
                                            }
                                            ?>
                                            <span class="label {{$label}}">{{$business->verified}}</span>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- END: CONTENT -->
    </section>
    @push('footerscripts')
        @include('admin.adminscripts')
    @endpush
@endsection