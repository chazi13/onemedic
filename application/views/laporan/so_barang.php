<!-- BEGIN CONTENT-->
<?php echo messages(); ?>
<div class="card">
    <div class="card-body">
        <form class="form-horizontal" method="post" action="" id="filter-laporan">
            <input type="hidden" name="tanggal" id="tanggal" value="<?php echo $tanggal?>" />
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-lg-4 control-label">Tanggal Opname</label>
                        <div class="col-lg-4">
                            <div class="input-group">
                                <input type="text" name="tanggal_show" id="tanggal_show" value="<?php echo $this->utility->mysql_to_tanggal($tanggal)?>"  class="form-control text-right" />
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
        
        $("#tanggal_show").datepicker({
            language: 'id',
            autoclose: true,
            format: 'dd MM yyyy'
        }).on("changeDate", function(e) {
            var tanggal = e.format('yyyy-mm-dd');
            $('#tanggal').val(tanggal);
            loadLaporan()
        });

        function loadLaporan(){
            var tanggal = $("input[name=tanggal]").val();
            window.location = '<?php echo site_url("laporan/so_barang/index/")?>'+tanggal;
        }
    });
</script>
