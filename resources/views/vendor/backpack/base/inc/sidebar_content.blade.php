<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="fa fa-dashboard nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard-map') }}"><i class="fa fa-map nav-icon"></i> Peta Pengiriman</a></li>

<li class='nav-item'><a class='nav-link' href='{{ backpack_url('salesform') }}'><i class='nav-icon la la-question'></i> SalesForms</a></li>

@if(backpack_user()->hasRole('superadmin'))
<li class="nav-item nav-dropdown">
	<a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon fa fa-cog"></i> Config</a>
	<ul class="nav-dropdown-items">
	  <li class="nav-item"><a class="nav-link" href="{{ backpack_url('user') }}"><i class="nav-icon fa fa-users"></i> <span>Users</span></a></li>
	</ul>
</li>
@endif
