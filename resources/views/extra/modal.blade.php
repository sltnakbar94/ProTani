@if(isset($crud->entry->id))
    @include('order.add-modal')
    @include('order.edit-modal')
@endif

<!-- show modal if in dashboard only -->
@if(\Request::route()->getName() == 'backpack.dashboard')
@endif
