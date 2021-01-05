@if(isset($crud->entry->id))
    @include('order.add-modal')
    @include('order.edit-modal')
@endif

<!-- show modal if in dashboard only -->
@if(\Request::route()->getName() == 'backpack.dashboard')
    @include('dashboard.paket-keluar-modal')
    @include('dashboard.sedang-dikirim-modal')
    @include('dashboard.sampai-ketujuan-modal')
    @include('dashboard.sampai-ketujuan-modal-detail')
@endif