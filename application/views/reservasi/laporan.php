<?php echo messages(); ?>
<div class="row">
    <div class="col-lg-12">
		<div class="card">
			<div class="card-header header-elements-inline">
                <h5 class="card-title">Laporan Reservasi Pasien</h5>
            </div>
			<div class="card-body">
                <form method="post" action="" >
                    <div class="form-group row">
                        <label class="col-form-label col-md-2">Tanggal Reservasi</label>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-5">
                                    <input type="text" name="tanggal_awal" id="tanggal_awal" value="<?php echo $tglAwal; ?>" class="form-control text-right">
                                </div> s.d
                                <div class="col-md-5">
                                    <input type="text" name="tanggal_akhir" id="tanggal_akhir" value="<?php echo $tglAkhir; ?>" class="form-control text-right">
                                </div>
                            </div>
                        </div>
                        <label class="col-form-label col-md-2">Tipe Pasien</label>
                        <div class="col-md-2">
                            <div class="row">
                                <select id="tipe_pasien" class="form-control" name="tipe_pasien">
                                    <option value="" selected="selected"></option>
                                    <option value="BPJS" <?php echo ($tipePasien) == 'BPJS' ? 'selected=""' : ''; ?> >BPJS</option>
                                    <option value="UMUM" <?php echo ($tipePasien) == 'UMUM' ? 'selected=""' : ''; ?>>UMUM</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <button type="submit" class="btn btn-raised btn-success ink-reaction">Tampilkan</button>
                        </div>
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table reservasi-table">
                        <thead>
                            <tr>
                                <th style="width: 300px;">Poliklinik</th>
                                <th style="">Dokter </th>
                                <th style="width: 150px;">Jumlah Pasien</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                if(!empty($rows)):
                                    foreach($rows as $row):
                            ?>
                            <tr>
                                <td><?php echo $row->poli_nama;?></td>
                                <td><?php echo $row->dokter_nama;?></td>
                                <td class="text-right"><?php echo $row->jumlah;?></td>
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
    </div>
</div>

<script>
    var the_table, filter_tgl_kunjungan_init = '';
    $(document).ready(function() {

        $('#tanggal_akhir, #tanggal_awal').datepicker({
        	autoclose: true,
        	clearBtn: true,
        	todayHighlight: true,
        	format: "dd/mm/yyyy"
        });
    });
</script> 