<div class="row">
    <div class="col-md-6"></div>
    <div class="col-md-4 text-right">
        <form class="form-inline" action="/admin/dashboard">
          <select name="show_dashboard" id="show_dashboard" class="form-control mb-4 mr-sm-2">
            <option value="all" {{ old('show_dashboard', request()->get('show_dashboard')) == "all" ? 'selected="selected"' : '' }}>Semua Data</option>
            <option value="today" {{ old('show_dashboard', request()->get('show_dashboard')) == "today" ? 'selected="selected"' : '' }}>Hari Ini</option>
            <option value="set_date" {{ old('show_dashboard', request()->get('show_dashboard')) == "set_date" ? 'selected="selected"' : '' }}>Tanggal</option>
          </select>
          @if(request()->get('show_dashboard') == 'set_date')
          <input type="date" class="form-control mb-4 mr-sm-2" name="show_dashboard_date" id="show-dashboard-date" value="{{ old('show_dashboard_date', request('show_dashboard_date')) }}">
          @else
          <input type="date" class="form-control mb-4 mr-sm-2" name="show_dashboard_date" id="show-dashboard-date" style="display:none;" value="{{ old('show_dashboard_date', request('show_dashboard_date')) }}">
          @endif

          <button type="submit" style="background:#4880D0;color:white;" class="form-control badge-primary mb-4 mr-sm-2"><i class="fa fa-refresh"></i> PERBARUI</button>
        </form>
    </div>
</div>