@extends(backpack_view('blank'))

@section('content')

{{-- @include('dashboard.filter')
@include('dashboard.counter')
@include('dashboard.view-map')
@include('dashboard.kpm') --}}

@endsection

{{-- @section('after_scripts')
    @include('dashboard.js.modal')
    <script>
        $('#show_dashboard').on('change', '', function(e){
            var value = $(this).val();

            if(value == 'set_date') {
                $('#show-dashboard-date').show();
            } else {
                $('#show-dashboard-date').hide();
            }
        })
        $('select[name=all-package_length]').css('width', '100px')
        $('#all-package_filter').css('float', 'right');
    </script>
@endsection --}}
