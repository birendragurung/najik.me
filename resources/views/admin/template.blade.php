<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>ArkAdmin Theme</title>
    <link rel="shortcut icon" href="/img/ico/favicon.png" />

    <!-- CSS -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" type="text/css" />
    <link href="/css/bootstrap.min.css" rel="stylesheet" />
    <link href="/ark/jasny-bootstrap/dist/css/jasny-bootstrap.min.css" rel="stylesheet" />
    <!--<link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet" />-->
    <link href="/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css"  />
    <link href="/ark/bootstrap-daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
    <link href="/ark/bootstrap-datepicker/css/datepicker.css" rel="stylesheet" type="text/css" />
    <link href="/ark/select2/select2.css" rel="stylesheet" type="text/css" />
    <link href="/ark/select2/select2-bootstrap.css" rel="stylesheet" type="text/css" />
    <link href="/ark/jquery.uniform/themes/default/css/uniform.default.min.css" rel="stylesheet" type="text/css" />
    {{--<link href="scripts/css/prettify.css" rel="stylesheet" type="text/css" />--}}
    <link href="/ark/fullcalendar/dist/fullcalendar.css" rel="stylesheet" />
    <link href="/css/plugins/fullcalendar/fullcalendar.print.css" rel="stylesheet" media="print" />
    <link href="/js/plugins/dataTables/jquery.dataTables.js" rel="stylesheet" type="text/css" />
    <link href="/css/ark/ark.css" rel="stylesheet" type="text/css" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>

<body class="cover">

    <div class="wrapper">
        <!-- Demo Bar -->
        <div id="layout_options">
            <a href="#" class="options-handle"><i class="fa fa-gear"></i></a>
            <h5>Layout Options</h5>
            <label>
                <input type="checkbox" id="fixed_header" />
                Fixed header
            </label>
            <label>
                <input type="checkbox" id="fixed_container" />
                Within a container
            </label>
        </div>
        <!-- END: Demo Bar -->

        <!-- HEAD NAV -->
        <div class="navbar navbar-default navbar-static-top navbar-main" role="navigation">
            <div class="navbar-header">
                <a class="navbar-brand" href="index.html">
                    <img src="img/logo/default_90x32.png" alt="Ark">
                </a>
            </div>
            <ul class="nav navbar-nav navbar-left">
                <li class="sidemenu-switch">
                    <a href="#">
                        <span class="sr-only">Toggle navigation</span>
                        <i class="fa fa-bars"></i>
                    </a>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="visible-xs">
                    <a href="#" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar">
                        <span class="sr-only">Toggle navigation</span>
                        <i class="fa fa-bars"></i>
                    </a>
                </li>
                <li class="dropdown notification">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span class="label label-danger arrowed arrow-left-in pull-right">12</span>
                        <i class="fa fa-bell"></i>
                    </a>
                    <ul class="dropdown-menu pull-right">
                        <li>
                            <a href="#">
                                <i class="fa fa-inbox pull-left"></i>
                                <span class="time">now</span>
                                <p>Stet clita kasd gubergren, no sea takimata Lorem ipsum dolor sit amet.</p>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="fa fa-bell pull-left"></i>
                                <span class="time">13 min. ago</span>
                                <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy et dolore.</p>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="fa fa-bell pull-left"></i>
                                <span class="time">17 min. ago</span>
                                <p>Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="fa fa-inbox pull-left"></i>
                                <span class="time">23 min. ago</span>
                                <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco ut aliquid ex ea commodi consequat.</p>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="fa fa-inbox pull-left"></i>
                                <span class="time">26 min. ago</span>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisici elit, sed eiusmod tempor et dolore magna aliqua.</p>
                            </a>
                        </li>
                        <li class="open-section">
                            <a href="#">View All Notifications</a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown notification">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span class="label label-primary arrowed arrow-left-in pull-right">6</span>
                        <i class="fa fa-inbox"></i>
                    </a>
                    <ul class="dropdown-menu pull-right">
                        <li>
                            <a href="#">
                                <img src="img/users/alex.jpg" alt="alex" class="img-avatar pull-left" />
                                <span class="time">now</span>
                                <p>Stet clita kasd gubergren, no sea takimata Lorem ipsum dolor sit amet.</p>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <img src="img/users/fabbian.jpg" alt="fabbian" class="img-avatar pull-left" />
                                <span class="time">13 min. ago</span>
                                <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy et dolore.</p>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <img src="img/users/lex.jpg" alt="lex" class="img-avatar pull-left" />
                                <span class="time">17 min. ago</span>
                                <p>Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <img src="img/users/lex.jpg" alt="lex" class="img-avatar pull-left" />
                                <span class="time">23 min. ago</span>
                                <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco ut aliquid ex ea commodi consequat.</p>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <img src="img/users/molly.jpg" alt="molly" class="img-avatar pull-left" />
                                <span class="time">26 min. ago</span>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisici elit, sed eiusmod tempor et dolore magna aliqua.</p>
                            </a>
                        </li>
                        <li class="open-section">
                            <a href="#">View All Messages</a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle avatar pull-right" data-toggle="dropdown">
                        <img src="img/users/mike.jpg" alt="mike" class="img-avatar" />
                        <span class="hidden-small">Mike Smith<b class="caret"></b></span>
                    </a>
                    <ul class="dropdown-menu pull-right">
                        <li><a href="#"><i class="fa fa-gear"></i>Account Settings</a></li>
                        <li><a href="profile.html"><i class="fa fa-user"></i>View Profile</a></li>
                        <li class="divider"></li>
                        <li><a href="login.html"><i class="fa fa-sign-out"></i>Logout</a></li>
                    </ul>
                </li>
            </ul>

        </div>
        <!-- END: HEAD NAV -->

        <!-- BODY -->
        <div class="body">

            <!-- SIDEBAR -->
            <aside class="sidebar">
                <ul class="nav nav-stacked">
                    <li class="active" ><a href="index.html"><i class="fa fa-dashboard fa-fw"></i><span class="item-label">Dashboard</span></a></li>
                    <li class="menu ">
                        <a href="#" class="menu-toggle"><i class="fa fa-sort-alpha-asc fa-fw"></i><span class="item-label">Look &amp; Feel</span><i class="caret"></i></a>
                        <ul class="submenu">
                            <li  ><a href="typography.html"><i class="fa fa-sort-alpha-asc fa-fw"></i><span>Typography</span></a></li>
                            <li  ><a href="grid.html"><i class="fa fa-th-large fa-fw"></i><span>Grid</span></a></li>
                            <li  ><a href="topnav.html"><i class="fa fa-dashboard fa-fw"></i>Top Navigation</a></li>
                            <li  ><a href="search_results.html"><i class="fa fa-search fa-fw"></i><span>Search Results</span></a></li>
                        </ul>
                    </li>
                    <li class="menu ">
                        <a href="#" class="menu-toggle"><i class="fa fa-cogs fa-fw"></i><span class="item-label">UI Elements</span><i class="caret"></i></a>
                        <ul class="submenu">
                            <li  ><a href="ui_components.html"><i class="fa fa-wrench fa-fw"></i><span>Components</span></a></li>
                            <li  ><a href="ui_buttons.html"><i class="fa fa-hand-o-up fa-fw"></i><span>Buttons &amp; Labels</span></a></li>
                            <li  ><a href="ui_nested_lists.html"><i class="fa fa-list-ul fa-fw"></i><span>Nested Lists</span></a></li>
                            <li  ><a href="ui_images.html"><i class="fa fa-picture-o fa-fw"></i><span>Images &amp; Icons</span></a></li>
                            <li  ><a href="wysiwyg_editor.html"><i class="fa fa-edit fa-fw"></i>Wysiwyg Editor</a></li>
                            <li  ><a href="google_maps.html"><i class="fa fa-map-marker fa-fw"></i>Google Maps</a></li>
                        </ul>
                    </li>
                    <li class="menu ">
                        <a href="#" class="menu-toggle"><i class="fa fa-table fa-fw"></i><span><span class="item-label">Tables</span> <i class="caret"></i></span></a>
                        <ul class="submenu">
                            <li  ><a href="tables.html"><i class="fa fa-table fa-fw"></i>Default Tables</a></li>
                            <li  ><a href="datatables.html"><i class="fa fa-table fa-fw"></i>Data Tables</a></li>
                        </ul>
                    </li>
                    <li  ><a href="forms.html"><i class="fa fa-credit-card fa-fw"></i><span class="item-label">Forms</span></a></li>
                    <li  ><a href="calendar.html"><i class="fa fa-calendar fa-fw"></i><span class="item-label">Calendar</span> <span class="badge badge-danger">4</span></a></li>
                    <li  ><a href="charts.html"><i class="fa fa-bar-chart-o fa-fw"></i><span class="item-label">Charts</span></a></li>
                    <li  ><a href="gallery.html"><i class="fa fa-picture-o fa-fw"></i><span class="item-label">Gallery</span></a></li>
                    <li class="menu ">
                        <a href="#" class="menu-toggle"><i class="fa fa-bell fa-fw"></i><span><span class="item-label">Error Pages</span> <i class="caret"></i></span></a>
                        <ul class="submenu">
                            <li  ><a href="error_404.html"><i class="fa fa-laptop fa-fw"></i><span>Error 404</span></a></li>
                            <li  ><a href="error_500.html"><i class="fa fa-laptop fa-fw"></i><span>Error 500</span></a></li>
                        </ul>
                    </li>
                    <li class="menu ">
                        <a href="#" class="menu-toggle"><i class="fa fa-sitemap fa-fw"></i><span><span class="item-label">Other</span> <i class="caret"></i></span></a>
                        <ul class="submenu">
                            <li  ><a href="profile.html"><i class="fa fa-user fa-fw"></i><span>User Profile</span></a></li>
                            <li  ><a href="login.html"><i class="fa fa-sign-in fa-fw"></i><span>Login</span></a></li>
                            <li  ><a href="register.html"><i class="fa fa-check-square-o fa-fw"></i><span>Register</span></a></li>
                        </ul>
                    </li>
                </ul>
            </aside>
            <!-- END: SIDEBAR -->

            <section class="content">

                <ol class="breadcrumb">
                    <li class="active"><i class="fa fa-home fa-fw"></i> Home</li>
                </ol>

                <div class="header">
                    <div class="col-md-12">
                        <h3 class="header-title">Dashboard</h3>
                        <p class="header-info">Overview and latest statistics</p>
                    </div>
                </div>

                <!-- CONTENT -->
                <div class="main-content">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="panel ">
                                <div class="panel-heading">
                                    <div class="panel-actions">
                                        <div id="reportrange" class="pull-right">
                                            <i class="fa fa-calendar"></i>
                                            <span>This month</span> <b class="caret"></b>
                                        </div>
                                    </div>
                                    <h3 class="panel-title">Conversions</h3>
                                </div>
                                <div class="panel-body">
                                    <div id="dashboardConversions" class="chart"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="panel">
                                <div class="panel-body">
                                    <ul class="col-md-12 stats">
                                        <li class="stat col-md-3 col-sm-3 col-xs-6">
                                            <span><b class="value">2,304</b> New Users</span>
                                            <em>Today</em>
                                        </li>
                                        <li class="stat col-md-3 col-sm-3 col-xs-6">
                                            <span><b class="value">5,402</b> New Visits</span>
                                            <em>Today</em>
                                        </li>
                                        <li class="stat col-md-3 col-sm-3 col-xs-6">
                                            <span><b class="value">741</b> Orders</span>
                                            <em>This week</em>
                                        </li>
                                        <li class="stat col-md-3 col-sm-3 col-xs-6">
                                            <span><b class="value">$23,441</b> Revenue</span>
                                            <em>This month</em>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="panel ">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Overview</h3>
                                </div>
                                <div class="panel-body">
                                    <div class="col-md-4 col-sm-4 col-xs-6 text-center pie-box">
                                        <div class="pie-chart" data-percent="73"><span>0%</span></div>
                                        <a href="#" class="pie-title">Likes</a>
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-6 text-center pie-box">
                                        <div class="pie-chart" data-percent="34" data-bar-color="#1F8A70"><span>0%</span></div>
                                        <a href="#" class="pie-title">Tweets</a>
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-6 text-center pie-box">
                                        <div class="pie-chart" data-percent="57" data-bar-color="#FF530D"><span>0%</span></div>
                                        <a href="#" class="pie-title">Server Load</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="panel">
                                <div class="panel-heading">
                                    <div class="panel-actions">
                                        <a href="#" class="panel-action" ><i class="fa fa-gear"></i></a>
                                        <a href="#" class="panel-action" ><i class="fa fa-filter"></i></a>
                                        <a href="#" class="panel-action" ><i class="fa fa-eye"></i></a>
                                    </div>
                                    <h3 class="panel-title">Latest Orders</h3>
                                </div>
                                <div class="panel-body">
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th class="col-md-4">ID</th>
                                            <th class="col-md-4">User</th>
                                            <th class="col-md-4">Value</th>
                                            <th class="col-md-4">Status</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>#1249</td>
                                            <td>Joe Walker</td>
                                            <td>$653</td>
                                            <td><span class="label label-info">PENDING</span></td>
                                        </tr>
                                        <tr>
                                            <td>#1248</td>
                                            <td>Zoe Hart</td>
                                            <td>$1,342</td>
                                            <td><span class="label label-default">INACTIVE</span></td>
                                        </tr>
                                        <tr>
                                            <td>#1247</td>
                                            <td>Zoe Hart</td>
                                            <td>$1,012</td>
                                            <td><span class="label label-primary">ACTIVE</span></td>
                                        </tr>
                                        <tr>
                                            <td>#1246</td>
                                            <td>Tim Butcher</td>
                                            <td>$2,500</td>
                                            <td><span class="label label-warning">PROCESSING</span></td>
                                        </tr>
                                        <tr>
                                            <td>#1245</td>
                                            <td>Mark Smith</td>
                                            <td>$45</td>
                                            <td><span class="label label-success">COMPLETED</span></td>
                                        </tr>
                                        <tr>
                                            <td>#1244</td>
                                            <td>Dave Gibbs</td>
                                            <td>$948</td>
                                            <td><span class="label label-danger">CANCELED</span></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="panel ">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Revenue</h3>
                                </div>
                                <div class="panel-body">
                                    <div id="dashboardRevenues" class="chart"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- END: CONTENT -->
            </section>
        </div>
        <!-- END: BODY -->
    </div>

    <!-- JS -->
    <script src="/js/jquery.js"></script>
    <script src="/ark/jquery-ui/js/jquery-ui.min.js"></script>
    <script src="/ark/jquery.uniform/jquery.uniform.min.js"></script>
    <script src="/ark/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="/ark/jasny-bootstrap/dist/js/jasny-bootstrap.min.js"></script>
    <script src="/ark/jquery-autosize/jquery.autosize.min.js"></script>
    <script src="/ark/momentjs/min/moment.min.js"></script>
    <script src="/ark/bootstrap-daterangepicker/daterangepicker.js"></script>
    <script src="/ark/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script src="/ark/dropzone/dist/min/dropzone.min.js"></script>
    <script src="/ark/jquery.easy-pie-chart/dist/jquery.easypiechart.min.js"></script>
    <script src="/ark/jquery-flot/jquery.flot.js"></script>
    <script src="/ark/jquery-flot/jquery.flot.pie.js"></script>
    <script src="/ark/jquery-flot/jquery.flot.stack.js"></script>
    <script src="/ark/jquery-flot/jquery.flot.resize.js"></script>
    <script src="/ark/jquery-flot/jquery.flot.time.js"></script>
    <script src="/ark/jquery-flot/jquery.flot.navigate.js"></script>
    <script src="/ark/select2/select2.min.js"></script>
    <script src="/ark/fullcalendar/dist/fullcalendar.min.js"></script>
    <script src="/ark/nestable/jquery.nestable.js"></script>
    <script src="/ark/ckeditor/ckeditor.js"></script>
    {{--<script src="/css/ark/prettify.js"></script>--}}
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyABa3_QsifCyHhVppeEPPElKetaSh9Wkhs&callback=initMap"></script>
    <script src="/js/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="/js/ark.min.js"></script>
    {{--<script src="/js/ark.js"></script>--}}

    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-972204-19', 'around25.com');
        ga('send', 'pageview');

    </script>
</body>
</html>