@extends('layouts.dashboard')

@section('content')
    <section class="content">
        <ol class="breadcrumb">
            <li><a href="/admin/dashboard"><i class="fa fa-home fa-fw"></i> Home</a></li>
            <li class="active">{{$title}}</li>
        </ol>

        <div class="header">
            <div class="col-md-12">
                <h3 class="header-title">{{$headerTitle}}</h3>
                <p class="header-info">{{$headerInfo}}</p>
            </div>
        </div>

        <!-- CONTENT -->
        <div class="main-content">
            <div class="row">
                <div class="col-md-12">
                    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-hover datatable">
                        <thead>
                        <tr>
                            <th>Business id</th>
                            <th>Business name</th>
                            <th>Email</th>
                            <th>Created at</th>
                            <th>Verified</th>
                            <th>Address</th>
                            <th>Total businesses</th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($businesses as $business)
                            <tr class="odd gradeX" id="business-{{$business->id}}">
                                <td>{{$business->id }}</td>
                                <td><a href="/business/{{$business->id}}">{{$business->name}}</a></td>
                                <td>{{$business->email }}</td>
                                <td class="center"> {{$business->created_at }}</td>
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
                                    <span id="business-span-{{$business->id}}" class="label {{$label}}">{{$business->verified}}</span>
                                </td>
                                <td class="center">{{isset($business->address)? $business->address->street_address . ' ' .$business->address->town  . ' ' . $business->address->state  . ', ' . $business->address->country:"" }}</td>
                                <td class="center">{{count($business->businesses)?:0 }}</td>
                                <td class="center"><a href="#verify-business-{{$business->id}}" id="verify-business-{{$business->id}}" onclick="verifyBusiness({{$business->id}})"  class="verify-button">{{$business->verified == 'yes'?'Unverify':'Verify' }}</a></td>
                                <td>
                                    <a href="#delete-{{$business->id}}" id="delete-{{$business->id}}" onclick="deletebusiness({{$business->id}})" data-url="/admin/deletebusiness/{{$business->id}}">Delete</a>
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