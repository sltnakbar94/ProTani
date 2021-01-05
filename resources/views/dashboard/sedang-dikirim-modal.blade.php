<!-- Modal -->
<div class="modal bd-example-modal-xl fade" id="showModalPaketDikirim" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="showModalPaketDikirimLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="showModalPaketDikirimLabel">Paket Sedang Dikirim</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <div class="table table-responsive">
                    {!! $dt_paket_dikirim->table(['id' => 'paket-dikirim', 'style' => 'width:100%;']) !!}
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>

{!! $dt_paket_dikirim->scripts() !!}
<script>
$('select[name=paket-dikirim_length]').css('width', '100px')
$('#paket-dikirim_filter').css('float', 'right');
</script>