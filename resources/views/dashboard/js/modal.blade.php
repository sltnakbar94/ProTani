<script type="text/javascript" src="/packages/datatables.net/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="/packages/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="/packages/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script type="text/javascript" src="/packages/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
<script type="text/javascript" src="/packages/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
<script type="text/javascript" src="/packages/datatables.net-fixedheader-bs4/js/fixedHeader.bootstrap4.min.js"></script>
<script>
    $('body').on('click', '.order-received-btn',function(){
        var detail_url = $(this).attr('id')
        
        // load ajax
         $.ajax({
            url: detail_url,
            type: 'GET',
            dataType: 'json',
            data: {},
            success:function(response){
                var data = response.data;
                $('body').find('#md-nomor_order').val(data.nomor_order);
                $('body').find('#md-surat_jalan').val(data.surat_jalan);
                $('body').find('#md-ekspedisi').val(data.ekspedisi);
                $('body').find('#md-tujuan').val(data.tujuan);
                $('body').find('#md-qty').val(data.qty);
                $('body').find('#md-jumlah_diterima').val(data.jumlah_diterima);
                $('body').find('#md-tanggal_terima').val(data.tanggal_terima);
                $('body').find('#md-nama_penerima').val(data.nama_penerima);
                $('body').find('#md-hp_penerima').val(data.hp_penerima);
                $('body').find('#md-foto').attr('src', data.foto);
            },
            error:function(xhr, responseText, throwError){
                console.log('error!')
            },
        });
    });
</script>