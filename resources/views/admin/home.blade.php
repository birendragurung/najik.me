@extends('layouts.dashboard')

@section('content')
    <?php dump($allUsers[5]->address)  ?>
    <section class="content">
        <ol class="breadcrumb">
            <li><a href="index.html"><i class="fa fa-home fa-fw"></i> Home</a></li>
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
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($allUsers as $user)
                        <tr class="odd gradeX">
                            <td>{{$user->id }}</td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email }}</td>
                            <td class="center"> {{$user->created_at }}</td>
                            <td class="center">{{$user->verified}}</td>
                            <td class="center">{{isset($user->address->country)?$user->address->country:"" }}</td>
                            <td class="center">{{count($user->businesses)?:0 }}</td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>


                    <!--<table class="table table-striped table-hover">-->
                    <!--<thead>-->
                    <!--<tr>-->
                    <!--<th>Order Id</th>-->
                    <!--<th>Date</th>-->
                    <!--<th>User</th>-->
                    <!--<th>Status</th>-->
                    <!--<th>Amount</th>-->
                    <!--<th></th>-->
                    <!--</tr>-->
                    <!--</thead>-->
                    <!--<tbody>-->
                    <!--<tr>-->
                    <!--<td><a href="#">#4531</a></td>-->
                    <!--<td>Jun 14, 2013</td>-->
                    <!--<td><a href="#">Sylvia Stingray</a></td>-->
                    <!--<td>-->
                    <!--<span class="label label-success">Delivered</span>-->
                    <!--</td>-->
                    <!--<td>$2,643.00</td>-->
                    <!--<td>-->
                    <!--<a href="#">Edit</a>-->
                    <!--<a href="#">Delete</a>-->
                    <!--</td>-->
                    <!--</tr>-->
                    <!--<tr>-->
                    <!--<td><a href="#">#4532</a></td>-->
                    <!--<td>Feb 8, 2013</td>-->
                    <!--<td><a href="#">Jennifer Garner</a></td>-->
                    <!--<td>-->
                    <!--<span class="label label-primary">Completed</span>-->
                    <!--</td>-->
                    <!--<td>$1,392.00</td>-->
                    <!--<td>-->
                    <!--<a href="#">Edit</a>-->
                    <!--<a href="#">Delete</a>-->
                    <!--</td>-->
                    <!--</tr>-->
                    <!--<tr>-->
                    <!--<td><a href="#">#4533</a></td>-->
                    <!--<td>Dec 21, 2013</td>-->
                    <!--<td><a href="#">Wilma Penaflor</a></td>-->
                    <!--<td>-->
                    <!--<span class="label label-warning">Pending</span>-->
                    <!--</td>-->
                    <!--<td>$2,990.00</td>-->
                    <!--<td>-->
                    <!--<a href="#">Edit</a>-->
                    <!--<a href="#">Delete</a>-->
                    <!--</td>-->
                    <!--</tr>-->
                    <!--<tr>-->
                    <!--<td><a href="#">#4534</a></td>-->
                    <!--<td>Ian 12, 2013</td>-->
                    <!--<td><a href="#">Richard Leigh</a></td>-->
                    <!--<td>-->
                    <!--<span class="label label-default">Canceled</span>-->
                    <!--</td>-->
                    <!--<td>$3,847.00</td>-->
                    <!--<td>-->
                    <!--<a href="#">Edit</a>-->
                    <!--<a href="#">Delete</a>-->
                    <!--</td>-->
                    <!--</tr>-->
                    <!--<tr>-->
                    <!--<td><a href="#">#4535</a></td>-->
                    <!--<td>Ian 17, 2013</td>-->
                    <!--<td><a href="#">Cori Bradley</a></td>-->
                    <!--<td>-->
                    <!--<span class="label label-success">Delivered</span>-->
                    <!--</td>-->
                    <!--<td>$1,744.00</td>-->
                    <!--<td>-->
                    <!--<a href="#">Edit</a>-->
                    <!--<a href="#">Delete</a>-->
                    <!--</td>-->
                    <!--</tr>-->
                    <!--<tr>-->
                    <!--<td><a href="#">#4536</a></td>-->
                    <!--<td>Aug 2, 2013</td>-->
                    <!--<td><a href="#">Roy Brookins</a></td>-->
                    <!--<td>-->
                    <!--<span class="label label-warning">Pending</span>-->
                    <!--</td>-->
                    <!--<td>$5,123.00</td>-->
                    <!--<td>-->
                    <!--<a href="#">Edit</a>-->
                    <!--<a href="#">Delete</a>-->
                    <!--</td>-->
                    <!--</tr>-->
                    <!--<tr>-->
                    <!--<td><a href="#">#4537</a></td>-->
                    <!--<td>Sep 27, 2013</td>-->
                    <!--<td><a href="#">Brenda McConnell</a></td>-->
                    <!--<td>-->
                    <!--<span class="label label-primary">Completed</span>-->
                    <!--</td>-->
                    <!--<td>$4,233.00</td>-->
                    <!--<td>-->
                    <!--<a href="#">Edit</a>-->
                    <!--<a href="#">Delete</a>-->
                    <!--</td>-->
                    <!--</tr>-->
                    <!--</tbody>-->
                    <!--</table>-->
                    <!--<ul class="pagination pagination-sm">-->
                    <!--<li class="disabled"><a href="#">&laquo;</a></li>-->
                    <!--<li class="active"><a href="#">1</a></li>-->
                    <!--<li><a href="#">2</a></li>-->
                    <!--<li><a href="#">3</a></li>-->
                    <!--<li><a href="#">4</a></li>-->
                    <!--<li><a href="#">5</a></li>-->
                    <!--<li><a href="#">&raquo;</a></li>-->
                    <!--</ul>-->
                </div>
            </div>
        </div>
        <!-- END: CONTENT -->
    </section>

@endsection