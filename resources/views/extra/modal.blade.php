@if(isset($crud->entry->id))

@endif

<!-- show modal if in dashboard only -->
@if(\Request::route()->getName() == 'backpack.dashboard')
@endif
