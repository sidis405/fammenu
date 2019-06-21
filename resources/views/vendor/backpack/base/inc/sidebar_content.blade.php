<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
<li><a href="{{ backpack_url('dashboard') }}"><i class="fa fa-dashboard"></i> <span>{{ trans('backpack::base.dashboard') }}</span></a></li>
@if(backpack_user()->hasPermissionTo('Manage Restaurants', 'web'))
    <li><a href="{{ backpack_url('restaurants') }}"><i class="fa fa-home"></i> <span>Restaurants</span></a></li>
@endif

@if(backpack_user()->hasPermissionTo('Manage Menus', 'web'))
    <li><a href="{{ backpack_url('menus') }}"><i class="fa fa-list"></i> <span>Menus</span></a></li>
@endif
@if(backpack_user()->hasPermissionTo('Manage Dishes', 'web'))
    <li><a href="{{ backpack_url('dishes') }}"><i class="fa fa-cutlery"></i> <span>Dishes</span></a></li>
@endif

@if(backpack_user()->hasPermissionTo('Manage Users', 'web'))
    <li class="treeview">
        <a href="#"><i class="fa fa-group"></i> <span>ACL</span> <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
          <li><a href="{{ backpack_url('user') }}"><i class="fa fa-user"></i> <span>Users</span></a></li>
          <li><a href="{{ backpack_url('role') }}"><i class="fa fa-group"></i> <span>Roles</span></a></li>
          <li><a href="{{ backpack_url('permission') }}"><i class="fa fa-key"></i> <span>Permissions</span></a></li>
        </ul>
    </li>
@endif


<li><a href="{{ backpack_url('elfinder') }}"><i class="fa fa-files-o"></i> <span>{{ trans('backpack::crud.file_manager') }}</span></a></li>
