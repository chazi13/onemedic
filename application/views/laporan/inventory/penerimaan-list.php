<!-- BEGIN CONTENT-->
<?php echo messages(); ?>
<div class="card">
    <div class="card-body">
            <form class="form-horizontal" method="post" action="" id="filter-laporan">
                <input type="hidden" name="tgl_awal" id="tgl_awal" value="<?php echo $tgl_awal?>" />
                <input type="hidden" name="tgl_akhir" id="tgl_akhir" value="<?php echo $tgl_akhir?>" />
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-lg-3">Supplier</label>
                            <div class="col-lg-9">
                            <?php echo form_dropdown('supplier_id', $optionsSupplier, '', 'class="form-control"'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-lg-3">Tgl. Penerimaan</label>
                            <div class="col-lg-9">
                                <div class="input-group">
                                    <input type="text" name="tgl_awal_show" id="tgl_awal_show" value="<?php echo $this->utility->mysql_to_tanggal($tgl_awal)?>"  class="form-control text-right" />
                                    <span class="input-group-append">
                                        <button class="btn btn-light" type="button">s.d</button>
                                    </span>
                                    <input type="text" name="tgl_akhir_show" id="tgl_akhir_show" value="<?php echo $this->utility->mysql_to_tanggal($tgl_akhir)?>"  class="form-control text-right" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <table class="display table table-bordered table-striped" id="lap-penerimaan">
                <thead>
                    <tr>
                        <th style="width:150px;">Tgl. Mutasi</th>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Dari</th>
                        <th>Ke</th>
                    </tr>
                </thead>
            </table>
    </div>
</div>


<script>
    $(function() {
        
        $('select').select2();
        
        $("#tgl_awal_show").datepicker({
            language: 'id',
            autoclose: true,
            format: 'dd MM yyyy'
        }).on("changeDate", function(e) {
            var tglAwal = e.format('yyyy-mm-dd');
            $('#tgl_awal').val(tglAwal);
        });
        $("#tgl_akhir_show").datepicker({
            language: 'id',
            autoclose: true,
            format: 'dd MM yyyy'
        }).on("changeDate", function(e) {
            var tglAkhir = e.format('yyyy-mm-dd');
            $('#tgl_akhir').val(tglAkhir);
        });

        var dataTables = $("#lap-penerimaan").DataTable({
            "processing": true,
            "serverSide": true,
            "dom": '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
            "language": {
                "search": '<span>Filter:</span> _INPUT_',
                "searchPlaceholder": 'Type to filter...',
                "lengthMenu": '<span>Show:</span> _MENU_',
                "paginate": { 'first': 'First', 'last': 'Last', 'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;', 'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;' }
            },
            "searching": false,
            "paging": false,
            "info": false,
            "ajax": {
                "url": "<?php echo site_url('laporan/inventory_penerimaan/datatables_sourcedata') ?>",
                "type": "POST",
                "data": function(d) {
                    d.supplier_id = $('select[name="supplier_id"]').val();
                    d.tgl_awal = $('input[name="tgl_awal"]').val();
                    d.tgl_akhir = $('input[name="tgl_akhir"]').val();
                }
            },
            "columns": [
                {
                    "data": "tanggal_mutasi",
                    "render": function (data, type, row, meta) {
                        return moment(data).isValid() ? moment(data).lang("id").format('DD MMMM YYYY') : data;
                    },
                    "searchable": false,
                    "className": "text-right"
                },
                {"data": "barang_kode"},
                {"data": "barang_nama"},
                {"data": "lokasi_barang_nama_dari"},
                {"data": "lokasi_barang_nama_ke"}
            ]

        });

        $('select[name="unit_id"], select[name="jenis_barang_id"], select[name="lokasi_barang_id_dari"], select[name="lokasi_barang_id_ke"], input[name="tgl_awal_show"], input[name="tgl_akhir_show"]').on('change', function() {
            dataTables.draw();
        });
    });
</script>





<div class="area-top clearfix">
    <div class="pull-left header">
        <h3 class="title">LAPORAN</h3>
        <h5>
            <span>Laporan Penerimaan Barang</span>
        </h5>
    </div>
</div>
<div class="container">
    <div class="box">
            <form class="form-horizontal" method="post" id="mutasi-form" action="">
                <div class="padded">                    
                    <div class="form-group">                                               
                        <label class="control-label col-lg-2">Tanggal Penerimaan</label>
                        <div class="col-lg-4">
                            <input type="hidden" name="tanggal_awal" id="tanggal_awal" value="<?php echo $tanggal_awal ?>"/>
                            <input type="text" name="tanggal_awal_show" id="tanggal_awal_show" value="<?php echo $this->utility->mysql_to_tanggal($tanggal_awal) ?>"  style="width:150px; text-align: right;"/>
                            s.d
                            <input type="hidden" name="tanggal_akhir" id="tanggal_akhir" value="<?php echo $tanggal_akhir ?>"/>
                            <input type="text" name="tanggal_akhir_show" id="tanggal_akhir_show" value="<?php echo $this->utility->mysql_to_tanggal($tanggal_akhir) ?>"  style="width:150px; text-align: right;"/>
                        </div>                        
                    </div>
                    <div class="form-group">                                               
                        <label class="control-label col-lg-2">Supplier</label>
                        <div class="col-lg-4">
                            <?php echo form_dropdown('supplier_id', $optionsSupplier, $supplierId, 'id="supplier_id"'); ?>
                        </div>                        
                    </div>
                    <div class="form-group">                                               
                        <label class="control-label col-lg-2">Tanggal TOP</label>
                        <div class="col-lg-4">
                            <input type="hidden" name="tanggal_awal_top" id="tanggal_awal_top" value="<?php echo $tanggal_awal_top ?>"/>
                            <input type="text" name="tanggal_awal_show_top" id="tanggal_awal_show_top" value="<?php echo $this->utility->mysql_to_tanggal($tanggal_awal_top) ?>"  style="width:150px; text-align: right;"/>
                            s.d
                            <input type="hidden" name="tanggal_akhir_top" id="tanggal_akhir_top" value="<?php echo $tanggal_akhir_top ?>"/>
                            <input type="text" name="tanggal_akhir_show_top" id="tanggal_akhir_show_top" value="<?php echo $this->utility->mysql_to_tanggal($tanggal_akhir_top) ?>"  style="width:150px; text-align: right;"/>
                        </div>                        
                    </div>
                    <div class="form-group">                                               
                        <label class="control-label col-lg-2">Nomor Faktur</label>
                        <div class="col-lg-4">
                            <input type="hidden" name="penerimaan_id" id="penerimaan_id" value="<?php echo $penerimaanId ?>"/>
                            <input type="text" name="nomor_faktur" id="nomor_faktur" value="<?php echo $nomorFaktur ?>"  style="width:100%;"/>
                        </div>                        
                    </div>
                    <div class="form-group">                                               
                        <label class="control-label col-lg-2">&nbsp;</label>
                        <div class="col-lg-4">
                            <button class="btn btn-blue" type="submit" id="btn-filter">Filter</button>
                            <input class="btn btn-green" type="submit" id="btn-download" name="btn-download" value="Download" />
                        </div>                        
                    </div>
                </div>
            </form>
    </div>        
</div>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <span class="title">Data Penerimaan</span>
                </div>
                <div class="box-content">
                    <table class="table table-normal">
                        <thead>
                            <tr>
                                <td colspan="2" style="text-align:center;vertical-align: middle; ">Purchasing Order</td>
                                <td colspan="11" style="text-align:center;vertical-align: middle; ">Penerimaan</td>                   
                                <td rowspan="2" style="text-align:center;vertical-align: middle; ">&nbsp;</td>                   
                            </tr>
                            <tr>
                                <td style="text-align:center;vertical-align: middle; width: 50px;">Tanggal</td>           
                                <td style="text-align:center;vertical-align: middle; width: 100px;">No. PO</td>
                                <td style="text-align:center;vertical-align: middle; width: 50px;">Tanggal</td>
                                <td style="text-align:center;vertical-align: middle; width: 70px;">No. Faktur</td>
                                <td style="text-align:center;vertical-align: middle; width: 70px;">Tanggal TOP</td>
                                <td style="text-align:center;vertical-align: middle; width: 120px;">Supplier</td>
                                <td style="text-align:center;vertical-align: middle;">Nama Barang</td>
                                <td style="text-align:center;vertical-align: middle; width: 70px;">Satuan</td>
                                <td style="text-align:center;vertical-align: middle; width: 40px;">Qty</td>
                                <td style="text-align:center;vertical-align: middle; width: 60px;">Harga</td>
                                <td style="text-align:center;vertical-align: middle; width: 60px;">Diskon (Rp)</td>
                                <td style="text-align:center;vertical-align: middle; width: 60px;">Ppn (%)</td>
                                <td style="text-align:center;vertical-align: middle; width: 100px;">Jumlah</td>
                            </tr>
                        </thead>
                        <tbody id="data-show">
                            <?php
                            if (!empty($rows)) {
                                foreach ($rows as $row):
                                    $rowsItemPenerimaan = $this->penerimaan_item_model->get_by_penerimaan_farmasi_id($row->id);
                                    ?>
                                    <tr>
                                        <td style="text-align: left;"><?php echo $this->utility->mysql_to_tanggal($row->po_tanggal); ?></td>
                                        <td style="text-align: left;"><?php echo $row->po_no; ?></td>
                                        <td style="text-align: right;"><?php echo $this->utility->mysql_to_tanggal($row->tanggal_penerimaan); ?></td>
                                        <td style="text-align: left;"><?php echo $row->nomor_faktur; ?></td>
                                        <td style="text-align: right;"><?php echo $this->utility->mysql_to_tanggal($row->tanggal_top); ?></td>
                                        <td style="text-align: left;"><?php echo $row->supplier; ?></td>
                                        <?php 
                                        if(!empty($rowsItemPenerimaan)){
                                            $i=0;
                                            foreach($rowsItemPenerimaan as $itemPenerimaan){
                                                $i++;
                                                $farmasi = $this->farmasi_model->get_by_id($itemPenerimaan->item_id);
                                                $satuan = $this->satuan_model->get_by_id($itemPenerimaan->satuan_id);
                                                if($i > 1){
                                                    echo '<tr><td colspan="6"></td>';
                                                }
                                        ?>
                                            <td><?php echo $farmasi->nama?></td>
                                            <td><?php echo $satuan->nama?></td>
                                            <td style="text-align: right;"><?php echo $itemPenerimaan->banyaknya?></td>
                                            <td style="text-align: right;"><?php echo $itemPenerimaan->harga?></td>
                                            <td style="text-align: right;"><?php echo round($itemPenerimaan->diskon_rp,2)?></td>
                                            <td style="text-align: right;"><?php echo $itemPenerimaan->ppn?></td>
                                            <td style="text-align: right;"><?php echo $itemPenerimaan->jumlah?></td>
                                        <?php
                                                if($i > 1){
                                                    echo '<td style="text-align: center;"><!--a class="status-success"  data-button="view" href="'. site_url('inventory/penerimaan/view/'. $row->id),'" title="'.lang('view').'"><i class="icon-file-alt"></i></a--></td>';
                                                    echo '</tr>';
                                                }else{
                                                    echo '<td style="text-align: center;"><a class="status-success"  data-button="view" href="'. site_url('inventory/penerimaan/view/'. $row->id),'" title="'.lang('view').'"><i class="icon-file-alt"></i></a></td>';                                                    
                                                }
                                            }
                                        }else{
                                            echo '<td colspan="7"></td>';
                                        }
                                        ?>
                                        
                                    </tr>
                                <?php endforeach; ?>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $("#nomor_faktur").autocomplete({
        source: "<?php echo site_url('laporan/penerimaan/autocomplete'); ?>",
        minLength: 2,
        select: function(event, ui) {
            $('#penerimaan_id').val(ui.item.id);
        }
    });

    $(document).ready(function() {
        
        $('#btn-filter').on('click', function(){
            $('#data-show').empty();
            $('#data-show').append('<tr><td colspan="6">&nbsp;&nbsp; <b>Loading ....</b></td></tr>');
            
        })
        $("#tanggal_awal_show").attr('readonly', true);  
        $("#tanggal_awal_show").datepicker({
            changeMonth: true,
            changeYear: true,
            autoclose: true,
            format: 'd MM yyyy',
            linkFormat: "yy-mm-dd",
            language: 'id',
            linkField: '#tgl_pr'

        }).on("changeDate", function(e) {
            var newDate = e.format('yyyy-mm-dd')
            $("input[name='tanggal_awal']").val(newDate);
        });
        $("#tanggal_akhir_show").attr('readonly', true);  
        $("#tanggal_akhir_show").datepicker({
            changeMonth: true,
            changeYear: true,
            autoclose: true,
            format: 'd MM yyyy',
            linkFormat: "yy-mm-dd",
            language: 'id',
            linkField: '#tgl_pr'

        }).on("changeDate", function(e) {
            var newDate = e.format('yyyy-mm-dd')
            $("input[name='tanggal_akhir']").val(newDate);
        });

        
        $("#tanggal_awal_show_top").attr('readonly', true);  
        $("#tanggal_awal_show_top").datepicker({
            changeMonth: true,
            changeYear: true,
            autoclose: true,
            format: 'd MM yyyy',
            linkFormat: "yy-mm-dd",
            language: 'id'

        }).on("changeDate", function(e) {
            var newDate = e.format('yyyy-mm-dd')
            $("input[name='tanggal_awal_top']").val(newDate);
        });
        $("#tanggal_akhir_show_top").attr('readonly', true);  
        $("#tanggal_akhir_show_top").datepicker({
            changeMonth: true,
            changeYear: true,
            autoclose: true,
            format: 'd MM yyyy',
            linkFormat: "yy-mm-dd",
            language: 'id'

        }).on("changeDate", function(e) {
            var newDate = e.format('yyyy-mm-dd')
            $("input[name='tanggal_akhir_top']").val(newDate);
        });




    });

</script>