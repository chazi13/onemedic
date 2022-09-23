<?php echo messages(); ?>
<!-- BEGIN CONTENT-->
<div class="section-header">
    <h2 class="no-margin"> Laporan Piutang</h2>
</div>
<div class="section-body">
    <div class="row">
        <div class="card">
            <form class="form-horizontal" method="post" action="">
				<div class="card-body col-lg-6">
					<div class="form-group">
						<label for="pasien_nama" class="col-md-3 col-sm-3 control-label">Tanggal</label>
						<div class="input-group">
							<div class="col-md-12 col-sm-12">
								<input type="text" name="tanggal_awal" id="tanggal_awal" value="" class="form-control">
							</div>
							<span class="input-group-addon"> s.d </span>
							<div class="col-md-12 col-sm-12">
								<input type="text" name="tanggal_akhir" id="tanggal_akhir" value="" class="form-control">
							</div>
						</div>
					</div>
				</div>
				<div class="card-body col-lg-6">
					<div class="form-group">
						<label class="col-md-3 col-sm-3 control-label" for="pdf_asuransi_id">Tipe Pasien</label>
						<div class="col-md-7 col-sm-7">
							<select id="pdf_asuransi_id" class="form-control" name="pdf_asuransi_id">
								<option value="" selected="selected"></option>
								<option value="28">AIA Financial</option>
								<option value="1">BPJS</option>
								<option value="21">MANULIFE</option>
							</select>
						</div>
					</div>
					<div class="card-actionbar">
						<div class="card-actionbar-row">
							<input type="submit" name="filter-button" value="Tampilkan" id="filter-button" class="btn ink-reaction btn-raised btn-sm btn-success">
							<input type="submit" name="download-button" value="Download" id="download-button" class="btn ink-reaction btn-raised btn-sm btn-info">
						</div>
					</div>
				</div>
			</form>
        </div>
    </div>
    <!-- BEGIN DATATABLE -->
    <div class="row">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="display table table-bordered table-striped" id="dynamic-table-ajax-source">
                        <thead>
                            <tr>
                                <th style="width: 15px;" rowspan="2">No.</th>
                                <th style="width: 115px;" rowspan="2">Tgl. Invoice</th>
                                <th style="width: 115px;" rowspan="2">Tgl. Terima</th>
                                <th style="width: 115px;" rowspan="2">Periode</th>
                                <th style="width: 180px;" rowspan="2">No. Invoice</th>
                                <th rowspan="2">Jenis</th>
                                <th style="width: 170px;" rowspan="2">Materai</th>
                                <th style="width: 150px;" rowspan="2">Jml. Tagihan</th>
                                <th style="width: 150px;" rowspan="2">Disc.</th>
                                <th style="width: 150px;" rowspan="2">After Disc.</th>
                                <th colspan="4">Keterangan Bayar</th>
                                <th style="width: 150px;" rowspan="2">Saldo Akhir</th>
                                <th style="width: 150px;" colspan="4">Saldo Per Umur Piutang</th>
								<th style="width: 150px;" rowspan="2">Grand Total</th>
								<th style="width: 150px;" rowspan="2">Tgl. Hari Ini</th>
							</tr>
							<tr>
                                <th style="width: 15px;">Tgl. Bayar</th>
                                <th style="width: 115px;">Bayar</th>
                                <th style="width: 115px;">(-)Bayar</th>
                                <th style="width: 115px;">(+)Bayar</th>
                                <th style="width: 115px;">1-15 Hari</th>
                                <th style="width: 115px;">16-30 Hari</th>
                                <th style="width: 115px;">31-60 Hari</th>
                                <th style="width: 115px;">>60 Hari</th>
							</tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="7"></td>
                            </tr>
                        </tbody>
                    </table>
                </div><!--end .table-responsive -->
            </div>
        </div><!--end .col -->
    </div><!--end .row -->
    <!-- END DATATABLE 1 -->
</div><!--end .section-body -->
<!-- END CONTENT -->


<?php $this->load->view('delete-modal'); ?>
<script>

    $(document).ready(function() {
        
$('#tanggal_awal, #tanggal_akhir').datepicker({autoclose: true, todayHighlight: true});


        $('#periode-tanggal').datepicker({
            format: 'dd/mm/yyyy',
            todayHighlight: true,
            autoclose: true
        });

        $('table').on("click", "[data-button=dialog-kartu]", function(e) {
            e.preventDefault();
            var url = $(this).attr('href');
            $('#load-dialog').load(url);
        });

        $('table').on("click", "[data-button=dialog-form-pemeriksaan]", function(e) {
            e.preventDefault();
            var url = $(this).attr('href');
            $('#load-dialog').load(url);
        });

        var dataTables = $('#dynamic-table-ajax-source').DataTable({
            "sAjaxSource": "<?php echo site_url('laporan/lap_piutang/datatables') ?>",
            "sServerMethod": "POST",
            "dom": 'lCfrtip',
            "order": [],
            "colVis": {
                "buttonText": "Columns",
                "overlayFade": 0,
                "align": "right"
            },
            "language": {
                "lengthMenu": '_MENU_ entries per page',
                "search": '<i class="fa fa-search"></i>',
                "paginate": {
                    "previous": '<i class="fa fa-angle-left"></i>',
                    "next": '<i class="fa fa-angle-right"></i>'
                }
            }
        });

    });
</script>

