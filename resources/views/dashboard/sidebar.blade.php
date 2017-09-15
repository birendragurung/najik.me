<!-- SIDEBAR -->
<aside class="sidebar">
    <ul class="nav nav-stacked">
        <li class="{{(\Request::is('admin/dashboard')?"active":'')}}" ><a href="/admin/dashboard"><span class="item-label">Dashboard</span></a></li>
        <li class="menu {{\Request::is('admin/user/newusers')||\Request::is('admin/user/all')?'open' :''}}">
            <a href="#" class="menu-toggle "><i class=""></i><span class="item-label">Manage users</span><i class="caret"></i></a>
            <ul class="submenu">
                <li class="{{(\Request::is('admin/user/newusers')?"active":'')}}"><a href="/admin/user/newusers"><i class=""></i><span>New users</span></a></li>
                <li class="{{(\Request::is('admin/user/all')?"active":'')}}" ><a href="/admin/user/all"><i class=""></i><span>List users</span></a></li>
            </ul>
        </li>
        <li class="menu {{\Request::is('admin/business/all')||\Request::is('admin/business/new')|| \Request::is('admin/promotion/requests')||\Request::is('admin/promotedbusinesses')?'open' :''}}">
            <a href="#" class="menu-toggle"><span class="item-label">Manage businesses</span><i class="caret"></i></a>
            <ul class="submenu">
                <li class="{{(\Request::is('admin/business/all')?"active":'')}}"><a href="/admin/business/all"><span>All businesses</span></a></li>
                <li class="{{(\Request::is('admin/business/new')?"active":'')}}" ><a href="/admin/business/new"><span>New businesses</span></a></li>
                <li class="{{(\Request::is('admin/promotion/requests')?"active":'')}}" ><a href="/admin/promotion/requests"><span>Promotion requests</span></a></li>
                <li class="{{(\Request::is('admin/promotedbusinesses')?"active":'')}}" ><a href="/admin/promotedbusinesses"><span>Promoted businesses</span></a></li>
            </ul>
        </li>
    </ul>
</aside>
<!-- END: SIDEBAR -->