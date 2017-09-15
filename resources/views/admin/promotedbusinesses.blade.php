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
                            <th>Pricing</th>
                            <th>Promotion time</th>
                            <th>Expires at</th>
                            <th>Promoted by admin</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($businesses as $business)
                            <tr class="gradeA odd" role="row">
                                <td class="sorting_1">{{$business->id}}</td>
                                <td><a href="/business/{{$business->id}}">{{$business->name}}</a></td>
                                <td>{{substr($business->description, 0 , 130)}}</td>
                                <td class="center">{{$business->email}}</td>
                                <td class="center">{{$business->website}}</td>
                                <td class="center">
                                    @php
                                        $label = '';
                                        if($business->verified == 'yes')
                                        {
                                            $label = 'label-success';
                                        } elseif($business->verified == 'pending')
                                        {
                                            $label = 'label-warning';
                                        } elseif($business->verified = 'no')
                                        {
                                            $label = 'label-default';
                                        }
                                    @endphp
                                    <span class="label {{$label}}">{{$business->verified}}</span>
                                </td>
                                <td class="center">Rs. {{$business->promotion->promotion_pricing}}</td>
                                <td class="center">{{$business->promotion->promoted_at->diffForHumans() }}</td>
                                <td class="center">{{$business->promotion->expires_at->diffForHumans() }}<br></td>
                                <td class="center">{{App\User::where('id',$business->promotion->admin_id)->first()->name}}</td>

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