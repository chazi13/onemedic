<?php
$namaPerusahaan = '';
$perusahaan = $this->perusahaan_model->get_by_id($rowData->perusahaan_id);
if (!empty($perusahaan)) {
    $namaPerusahaan = $perusahaan->nama;
}

$tipePasien = '';
$tipe = $this->tipe_pasien_model->get_by_id($rowData->tipe_pasien_id);
if (!empty($tipe)) {
    $tipePasien = $tipe->nama;
}

$asuransiPasien = '';
$asuransi = $this->asuransi_model->get_by_id($rowData->asuransi_id);
if (!empty($asuransi)) {
    $asuransiPasien = $asuransi->nama;
}

$dokterPemeriksa = '';
$dokter = $this->pegawai_model->get_by_id($rowData->dokter_id);
if (!empty($dokter)) {
    $dokterPemeriksa = $dokter->nama;
}
?>
<div  class="modal fade" tabindex="-1" id="form_pemeriksaan-modal">
    <div class="modal-dialog" style="width: 80%;max-width:100%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <h5>FORM PEMERIKSAAN </h6>
                <table class="table table-bordered" >
                    <thead>
                        <tr>
                            <th style="border:none; width:150px;">Nomor MR</th>
                            <th style="border:none;">: <?php echo $rowData->no_mr ?></th>
                            <th style="border:none;">&nbsp;</th>
                            <th style="border:none; width:180px;">Tipe Pasien</th>
                            <th style="border:none; width:200px;">: <?php echo $tipePasien ?></th>
                        </tr>
                        <tr>
                            <th style="border:none;">Nama</th>
                            <th style="border:none;">: <?php echo $rowData->nama ?>&nbsp;&nbsp;(<?php echo $rowData->umur_tahun ?> tahun, <?php echo $rowData->umur_bulan ?> bulan, <?php echo $rowData->umur_hari ?> hari)</th>
                            <th style="border:none;">&nbsp;</th>
                            <th style="border:none;">Perusahaan</th>
                            <th style="border:none;">: <?php echo $namaPerusahaan ?></th>
                        </tr>
                        <tr>
                            <th style="border:none; ">Alamat</th>
                            <th style="border:none;">: <?php echo $rowData->alamat ?></th>
                            <th style="border:none;">&nbsp;</th>
                            <th style="border:none; ">Nama Penjamin</th>
                            <th style="border:none;">: <?php echo $asuransiPasien ?></th>
                        </tr>
                        <tr>
                            <th style="border:none;">Poliklinik</th>
                            <th style="border:none;">: <?php echo $rowData->poli_nama ?></th>
                            <th style="border:none;">&nbsp;</th>
                            <th style="border:none;">Nomor Surat Penjamin</th>
                            <th style="border:none;">: <?php echo $rowData->no_surat_jaminan ?></th>
                        </tr>
                        <tr>
                            <th style="border:none;">Dokter</th>
                            <th style="border:none;">: <?php echo $dokterPemeriksa ?></th>
                            <th style="border:none;">&nbsp;</th>
                            <th style="border:none;">Nomor Kartu Penjamin</th>
                            <th style="border:none;">: <?php echo $rowData->no_kartu ?></th>
                        </tr>
                        <tr>
                            <th style="border:none;">Nomor Antrian</th>
                            <th style="border:none;">: <?php echo $rowData->no_antrian ?></th>
                            <th style="border:none;">&nbsp;</th>
                            <th style="border:none;">Tanggal Surat Penjamin</th>
                            <th style="border:none;">: <?php
                                if (!empty($rowData->tanggal_surat_jaminan)) {
                                    echo $this->utility->mysql_to_tanggal($rowData->tanggal_surat_jaminan);
                                }
                                ?></th>
                        </tr>
                    </thead>
                </table>
                <table class="table" id="list_pelayanan">
                    <thead>
                        <tr>
                            <th style="width:60px" class="text-center">No.</th>
                            <th class="text-left">Layanan / Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center">&nbsp;</td>
                            <td class="text-center">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="text-center">&nbsp;</td>
                            <td class="text-center">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="text-center">&nbsp;</td>
                            <td class="text-center">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="text-center">&nbsp;</td>
                            <td class="text-center">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="text-center">&nbsp;</td>
                            <td class="text-center">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="text-center">&nbsp;</td>
                            <td class="text-center">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="text-center">&nbsp;</td>
                            <td class="text-center">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="text-center">&nbsp;</td>
                            <td class="text-center">&nbsp;</td>
                        </tr>
                    </tbody>
                </table>
                <table class="table" style="border:none;">
                    <thead>
                        <tr>
                            <th style="text-align:center;width:20%;;border:none;">&nbsp;</th>
                            <th style="text-align:center;width:20%;border:none;"><?php echo $unit->kabupaten_kota . ', ' . $this->utility->mysql_to_tanggal(date('Y-m-d')) ?><br/><br/><br/><u><?php echo $user->full_name ?></u></th>
                    </tr>
                    </thead>
                </table>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-link" data-dismiss="modal"><?php echo lang('cancel'); ?></button>
                <button type="button" class="btn bg-primary"><?php echo lang('print'); ?></button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#form_pemeriksaan-modal').modal('show');
    });
</script>