<?php echo messages(); ?>
<div class="card">
    <div class="card-header header-elements-inline">
        <h5><?php echo $template['title'] ?></h5>
    </div>
    <div class="card-body">
        <div class="col-md-6 offset-md-3">
            <div class="form-group row">
                <label class="col-form-label col-2">Kode</label>
                <div class="col-8">
                    <input type="text" class="form-control" placeholder="Search" id="search_code" />
                </div>
            </div>
        </div>
        <table class="table reservasi-table">
            <thead>
                <tr>
                    <th style="width: 20px;font-weight: bold;">#</th>
                    <th style="font-weight: bold;">Pasien</th>
                    <th style="width: 60px;">&nbsp;</th>
                    <th style="width: 220px;font-weight: bold;">Poliklinik</th>
                    <th style="width: 220px;font-weight: bold;">Dokter</th>
                    <th style="width: 150px;font-weight: bold;">Kode Booking</th>
                    <th class="width: 10px;">&nbsp;</th>
                    <th class="width: 10px;">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if(!empty($rows)):
                    $urlKonfirmasi = '';
                    $urlTarget = '';
                    $kunjungan = '';
                    foreach ($rows as $row):
                        $badeTipePasien = '<sup class="badge badge-success">UMUM</sup>';
                        if($row->tipe_pasien == 'BPJS'){
                            $badeTipePasien = '<sup class="badge badge-info">BPJS</sup>';
                        }
                ?>
                <tr rel="<?php echo $row->poli_id; ?>" class='poli'>
                    <td style="font-weight:bold; vertical-align:middle;"><?php echo $row->no_urut_daftar; ?></td>
                    <td style="font-weight: bold;">
                        <?php echo $row->no_mr.' <br/> '. $row->nama .'<br/>'; ?>
                        <?php echo $row->alamat.'<br/>'.$row->telepon; ?>
                    </td>
                    <td><?php echo $badeTipePasien; ?>
                    </td>
                    <td><?php echo $row->poli_nama; ?></td>
                    <td><?php echo $row->dokter_nama.'<br/>'.$row->dokter_praktek_mulai . ' - ' . $row->dokter_praktek_selesai; ?></td>
                    <td style="font-size:18px; font-weight:bold; vertical-align:middle;"><?php echo $row->kode; ?></td>
                    <td class="text-center" style="vertical-align:middle;padding:2px;">
                        <a class="btn btn-outline bg-success border-success text-success-800 btn-icon btn-xs" href="<?php echo site_url('pendaftaran/home/index/'.$row->no_mr.'/'.$row->id); ?>" data-button="confirm" ><i class="icon-checkmark3"></i></a>
                    </td>
                    <td class="text-center" style="vertical-align:middle;padding:2px;">
                        <a class="btn btn-outline bg-danger border-danger text-danger-800 btn-icon btn-xs" href="<?php echo site_url('reservasi/home/delete/'.$row->id); ?>" data-button="delete"  ><i class="icon-trash"></i>
                    </td>
                </tr>
                <?php
                    endforeach;
                endif;
                ?>                                
            </tbody>
        </table>
    </div>
</div>

<?php $this->load->view('delete-modal'); ?>


<script>
$( document ).ready(function() {
    $("#search_code").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $(".reservasi-table > tbody > tr").filter(function() { 
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });
    $('[data-button=approve]').on('click', function(e) {
        var url = $(this).attr('href');
        $('#form-approve').attr('action', url);
        $('#approve-modal').modal('show');
        e.preventDefault();
    });
});
</script>