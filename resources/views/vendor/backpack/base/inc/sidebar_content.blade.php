<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="fa fa-dashboard nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard-map') }}"><i class="fa fa-map nav-icon"></i> Peta Pengiriman</a></li>
@if(backpack_user()->hasAnyRole(['operator', 'superadmin']))
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('order') }}'><i class='nav-icon fa fa-truck'></i> Input Paket Keluar</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('produksi') }}'><i class='nav-icon fa fa-industry'></i>Produksi</a></li>
@endif

<li class="nav-item nav-dropdown">
	<a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon fa fa-download"></i> Download</a>
	<ul class="nav-dropdown-items">
		<li class='nav-item'><a class='nav-link' href='{{ backpack_url('downloadorder') }}'><i class='nav-icon fa fa-download'></i> Download Order</a></li>
		<li class='nav-item'><a class='nav-link' href='{{ backpack_url('download') }}'><i class='nav-icon fa fa-download'></i> Downloads POD</a></li>
	</ul>
</li>

@if(backpack_user()->hasRole('superadmin'))
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('order-scan') }}'><i class='nav-icon fa fa-barcode'></i> Scan Paket</a></li>
<li class="nav-item nav-dropdown">
	<a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon fa fa-cog"></i> Config</a>
	<ul class="nav-dropdown-items">
	  <li class="nav-item"><a class="nav-link" href="{{ backpack_url('user') }}"><i class="nav-icon fa fa-users"></i> <span>Users</span></a></li>
	  <li class="nav-item"><a class="nav-link" href="{{ backpack_url('expedition') }}"><i class="nav-icon fa fa-plane"></i> <span>Ekspedisi</span></a></li>
	  <li class='nav-item'><a class='nav-link' href='{{ backpack_url('destination') }}'><i class='nav-icon fa fa-map-marker'></i> Tujuan</a></li>
	  <li class='nav-item'><a class='nav-link' href='{{ backpack_url('company') }}'><i class='nav-icon fa fa-building'></i> Perusahaan</a></li>
	</ul>
</li>
@endif