@extends('layouts.dashboard')

@section('content')

    <section class="content" style="min-height: 286px;">

        <ol class="breadcrumb">
            <li><a href="index.html"><i class="fa fa-home fa-fw"></i> Home</a></li>
            <li class="active">Users</li>
        </ol>

        <div class="header">
            <div class="col-md-12">
                <h3 class="header-title">Users table</h3>
                <p class="header-info">Users</p>
            </div>
        </div>

        <!-- CONTENT -->
        <div class="main-content">
            <div class="row">
                <div class="col-md-12">
                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline no-footer">
                        <div class="row">
                            <div class="col-xs-6 records">
                                <div class="dataTables_length" id="DataTables_Table_0_length"><label>
                                        <div class="select2-container select2" id="s2id_autogen1">
                                            <a href="javascript:void(0)" onclick="return false;" class="select2-choice" tabindex="-1">
                                                <span class="select2-chosen">10</span><abbr class="select2-search-choice-close"></abbr>
                                                <span class="select2-arrow"><b></b></span></a><input class="select2-focusser select2-offscreen" type="text" id="s2id_autogen2">
                                            <div class="select2-drop select2-display-none select2-with-searchbox">
                                                <div class="select2-search">
                                                    <input type="text" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" class="select2-input">
                                                </div>
                                                <ul class="select2-results"></ul>
                                            </div>
                                        </div>
                                        <select name="DataTables_Table_0_length" aria-controls="DataTables_Table_0" class="select2 select2-offscreen" tabindex="-1">
                                            <option value="10">10</option>
                                            <option value="25">25</option>
                                            <option value="50">50</option>
                                            <option value="100">100</option>
                                        </select> records per page</label></div>
                            </div>
                            <div class="col-xs-6 search_input">
                                <div id="DataTables_Table_0_filter" class="dataTables_filter">
                                    <label>Search:<input type="search" class="form-control input-sm" placeholder="" aria-controls="DataTables_Table_0"></label>
                                </div>
                            </div>
                        </div>
                        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-hover datatable dataTable no-footer" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
                            <thead>
                            <tr role="row">
                                <th class="sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" style="width: 206px;">Rendering engine</th>
                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 254px;">Browser</th>
                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending" style="width: 229px;">Platform(s)</th>
                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending" style="width: 178px;">Engine version</th>
                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" style="width: 122px;">CSS grade</th>
                            </tr>
                            </thead>
                            <tbody>


                            <tr class="gradeA odd" role="row">
                                <td class="sorting_1">Gecko</td>
                                <td>Firefox 1.0</td>
                                <td>Win 98+ / OSX.2+</td>
                                <td class="center">1.7</td>
                                <td class="center">A</td>
                            </tr>
                            <tr class="gradeA even" role="row">
                                <td class="sorting_1">Gecko</td>
                                <td>Firefox 1.5</td>
                                <td>Win 98+ / OSX.2+</td>
                                <td class="center">1.8</td>
                                <td class="center">A</td>
                            </tr>
                            <tr class="gradeA odd" role="row">
                                <td class="sorting_1">Gecko</td>
                                <td>Firefox 2.0</td>
                                <td>Win 98+ / OSX.2+</td>
                                <td class="center">1.8</td>
                                <td class="center">A</td>
                            </tr>
                            <tr class="gradeA even" role="row">
                                <td class="sorting_1">Gecko</td>
                                <td>Firefox 3.0</td>
                                <td>Win 2k+ / OSX.3+</td>
                                <td class="center">1.9</td>
                                <td class="center">A</td>
                            </tr>
                            <tr class="gradeA odd" role="row">
                                <td class="sorting_1">Gecko</td>
                                <td>Camino 1.0</td>
                                <td>OSX.2+</td>
                                <td class="center">1.8</td>
                                <td class="center">A</td>
                            </tr>
                            <tr class="gradeA even" role="row">
                                <td class="sorting_1">Gecko</td>
                                <td>Camino 1.5</td>
                                <td>OSX.3+</td>
                                <td class="center">1.8</td>
                                <td class="center">A</td>
                            </tr>
                            <tr class="gradeA odd" role="row">
                                <td class="sorting_1">Gecko</td>
                                <td>Netscape 7.2</td>
                                <td>Win 95+ / Mac OS 8.6-9.2</td>
                                <td class="center">1.7</td>
                                <td class="center">A</td>
                            </tr>
                            <tr class="gradeA even" role="row">
                                <td class="sorting_1">Gecko</td>
                                <td>Netscape Browser 8</td>
                                <td>Win 98SE+</td>
                                <td class="center">1.7</td>
                                <td class="center">A</td>
                            </tr>
                            <tr class="gradeA odd" role="row">
                                <td class="sorting_1">Gecko</td>
                                <td>Netscape Navigator 9</td>
                                <td>Win 98+ / OSX.2+</td>
                                <td class="center">1.8</td>
                                <td class="center">A</td>
                            </tr>
                            <tr class="gradeA even" role="row">
                                <td class="sorting_1">Gecko</td>
                                <td>Mozilla 1.0</td>
                                <td>Win 95+ / OSX.1+</td>
                                <td class="center">1</td>
                                <td class="center">A</td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">Showing 1 to 10 of 57 entries</div>
                            </div>
                            <div class="col-xs-6">
                                <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate">
                                    <ul class="pagination pagination-sm">
                                        <li class="paginate_button previous disabled" aria-controls="DataTables_Table_0" tabindex="0" id="DataTables_Table_0_previous">
                                            <a href="#">Previous</a></li>
                                        <li class="paginate_button active" aria-controls="DataTables_Table_0" tabindex="0">
                                            <a href="#">1</a></li>
                                        <li class="paginate_button " aria-controls="DataTables_Table_0" tabindex="0">
                                            <a href="#">2</a></li>
                                        <li class="paginate_button " aria-controls="DataTables_Table_0" tabindex="0">
                                            <a href="#">3</a></li>
                                        <li class="paginate_button " aria-controls="DataTables_Table_0" tabindex="0">
                                            <a href="#">4</a></li>
                                        <li class="paginate_button " aria-controls="DataTables_Table_0" tabindex="0">
                                            <a href="#">5</a></li>
                                        <li class="paginate_button " aria-controls="DataTables_Table_0" tabindex="0">
                                            <a href="#">6</a></li>
                                        <li class="paginate_button next" aria-controls="DataTables_Table_0" tabindex="0" id="DataTables_Table_0_next">
                                            <a href="#">Next</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>


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