<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="fa fa-dashboard nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard-map') }}"><i class="fa fa-map nav-icon"></i> Peta Pengiriman</a></li>

<li class='nav-item'><a class='nav-link' href='{{ backpack_url('salesform') }}'><i class='fa fa-check-square-o nav-icon'></i> Form Sales</a></li>

@if(backpack_user()->hasRole('superadmin'))
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('downloadsalesform') }}'><i class='nav-icon fa fa-download'></i> Report Form Sales</a></li>
<li class="nav-item nav-dropdown">
	<a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon fa fa-cog"></i> Config</a>
	<ul class="nav-dropdown-items">
	  <li class="nav-item"><a class="nav-link" href="{{ backpack_url('user') }}"><i class="nav-icon fa fa-users"></i> <span>Users</span></a></li>
	</ul>
</li>
@endif

<li class='nav-item'><a class='nav-link' href='{{ backpack_url('validate') }}'><i class='nav-icon la la-question'></i> Validates</a></li>