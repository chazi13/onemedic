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
                        <label class="col-lg-3 control-label">Jenis Barang</label>
                        <div class="col-lg-7">
                        <?php echo form_dropdown('jenis_barang_id', $optionsJenisBarang, $jenis, 'class="form-control"'); ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-lg-2 control-label">Periode</label>
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
        <hr/>
        <div class="table-responsive">
            <table class="display table table-bordered table-striped" id="dynamic-table-ajax-source">
                <thead>
                    <tr>
                        <td class="font-weight-bold">Tgl. Pemeliharaan</td>
                        <td class="font-weight-bold">Barang / Aset</td>
                        <td class="font-weight-bold">Kondisi</td>
                        <td class="font-weight-bold">Keterangan</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if($rows):
                        foreach($rows as $row):
                    ?>
                    <tr>
                        <td class="text-right" style="width:150px;" ><?php echo $this->utility->mysql_to_tanggal($row->tanggal_pemeliharaan); ?></td>
                        <td><?php echo $row->barang_kode . ' ' .$row->barang_nama ; ?></td>
                        <td><?php echo $row->kondisi_nama ; ?></td>
                        <td><?php echo $row->catatan ; ?></td>
                    </tr>
                    <?php
                        endforeach;
                    endif;
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<script>
    $(function() {
        
        $("select[name=jenis_barang_id]").on('change', function() {
            loadLaporan();
        });
        $("#tgl_awal_show").datepicker({
            language: 'id',
            autoclose: true,
            format: 'dd MM yyyy'
        }).on("changeDate", function(e) {
            var tglAwal = e.format('yyyy-mm-dd');
            $('#tgl_awal').val(tglAwal);
            loadLaporan()
        });
        $("#tgl_akhir_show").datepicker({
            language: 'id',
            autoclose: true,
            format: 'dd MM yyyy'
        }).on("changeDate", function(e) {
            var tglAkhir = e.format('yyyy-mm-dd');
            $('#tgl_akhir').val(tglAkhir);
            loadLaporan()
        });

        function loadLaporan(){
            var jenis = $("select[name=jenis_barang_id]").val();
            var tglAwal = $("input[name=tgl_awal]").val();
            var tglAkhir = $("input[name=tgl_akhir]").val();
            window.location = '<?php echo site_url("laporan/pemeliharaan_barang/index/")?>'+tglAwal+'/'+tglAkhir+'/'+jenis;
        }
    });
</script>
