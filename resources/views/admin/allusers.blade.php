@extends('layouts.dashboard')

@section('content')
    <section class="content">
        <ol class="breadcrumb">
            <li><a href="/admin/dashboard"><i class="fa fa-home fa-fw"></i>Home</a></li>
            <li class="active">Users Tables</li>
        </ol>

        <div class="header">
            <div class="col-md-12">
                <h3 class="header-title">Users Tables</h3>
                <p class="header-info"></p>
            </div>
        </div>

        <!-- CONTENT -->
        <div class="main-content">
            <div class="row">
                <div class="col-md-12">
                    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-hover datatable">
                        <thead>
                        <tr>
                            <th>User id</th>
                            <th>User name</th>
                            <th>Email</th>
                            <th>Created at</th>
                            <th>Verified</th>
                            <th>Address</th>
                            <th>Total businesses</th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr class="odd gradeX" id="user-{{$user->id}}">
                                <td>{{$user->id }}</td>
                                <td>{{$user->name}}</td>
                                <td>{{$user->email }}</td>
                                <td class="center"> {{$user->created_at }}</td>
                                <td class="center">
                                    <?php
                                    $label = '';
                                    if($user->verified == 'yes')
                                    {
                                        $label = 'label-success';
                                    } elseif($user->verified == 'pending')
                                    {
                                        $label = 'label-warning';
                                    } elseif($user->verified = 'no')
                                    {
                                        $label = 'label-default';
                                    }
                                    ?>
                                    <span id="user-span-{{$user->id}}" class="label {{$label}}">{{$user->verified}}</span>
                                </td>
                                <td class="center">{{isset($user->address)? $user->address->street_address . ' ' .$user->address->town  . ' ' . $user->address->state  . ', ' . $user->address->country:"" }}</td>
                                <td class="center">{{count($user->businesses)?:0 }}</td>
                                <td class="center">
                                <td class="center">
                                    <a href="#verify-link-{{$user->id}}" id="verify-link-{{$user->id}}" onclick="verifyUser({{$user->id}})" class="verify-button">{{$user->verified == 'yes'?'Unverify':'Verify' }}</a>
                                </td>
                                <td>
                                    <a href="#" id="delete-{{$user->id}}" onclick="deleteUser({{$user->id}})">Delete</a>
                                </td>
                                <td>
                                    @if(App\UserMeta::where('role' , 'admin')->where('user_id', $user->id)->count() >0)
                                        <span>Admin</span>
                                    @else
                                        <a href="#" id="make-admin-{{$user->id}}" onclick="makeAdmin({{$user->id}})">Make Admin</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- END: CONTENT -->
    </section>
    @push('footerscripts')
        @include('admin.adminscripts')
    @endpush
@endsection