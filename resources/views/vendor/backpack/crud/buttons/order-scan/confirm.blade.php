@if ($crud->hasAccess('delete'))
	<a href="javascript:void(0)" onclick="confirmScan(this)" data-route="{{ route('orderdetail.manual-scan', $entry->getKey()) }}" class="btn btn-sm btn-link" data-button-type="delete"><i class="fa fa-barcode"></i> Tidak Scan QR</a>
@endif

{{-- Button Javascript --}}
{{-- - used right away in AJAX operations (ex: List) --}}
{{-- - pushed to the end of the page, after jQuery is loaded, for non-AJAX operations (ex: Show) --}}
@push('after_scripts') @if (request()->ajax()) @endpush @endif
<script>

	if (typeof confirmScan != 'function') {
	  $("[data-button-type=delete]").unbind('click');

	  function confirmScan(button) {
		// ask for confirmation before deleting an item
		// e.preventDefault();
		var button = $(button);
		var route = button.attr('data-route');
		var row = $("#crudTable a[data-route='"+route+"']").closest('tr');

		swal({
		  title: "Scan QR",
		  text: "Apakah anda yakin?",
		  icon: "warning",
		  buttons: {
		  	cancel: {
			  text: "Batal",
			  value: null,
			  visible: true,
			  className: "bg-secondary",
			  closeModal: true,
			},
		  	delete: {
			  text: "Ya",
			  value: true,
			  visible: true,
			  className: "bg-danger",
			}
		  },
		}).then((value) => {
			if (value) {
				$.ajax({
			      url: route,
			      type: 'POST',
			      success: function(result) {
			          new Noty({
							type: "success",
							text: "Scan QR Berhasil!"
						}).show();

					// Hide the modal, if any
					$('.modal').modal('hide');

					// Remove the details row, if it is open
					if (row.hasClass("shown")) {
						row.next().remove();
					}

					// Remove the row from the datatable
					row.remove();
			      },
			      error: function(response, responseText) {
					  swal({
						title: "Perhatian",
						text: "Terjadi kesalahan. Silahkan Coba Lagi!",
						icon: "error",
						timer: 4000,
						buttons: false,
					});
			      }
			  });
			}
		});

      }
	}

	// make it so that the function above is run after each DataTable draw event
	// crud.addFunctionToDataTablesDrawEventQueue('confirmScan');
</script>
@if (!request()->ajax()) @endpush @endif
