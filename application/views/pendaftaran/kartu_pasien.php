<div  class="modal fade" tabindex="-1" id="partu_pasien-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kartu Pasien </h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <h5>KARTU BEROBAT</h6>
                <h6><?php echo strtoupper($unit->nama) ?></h5>
                <h7><?php echo strtoupper($unit->alamat) ?></h6>
                <hr>
                <table>
                    <tr>
                        <td>
                            <table>
                                <tr>
                                    <th style="border:none;">Nama</th>
                                    <th style="border:none;">: <?php echo $rowData->nama ?></th>
                                </tr>
                                <tr>
                                    <th style="border:none;">Tempat, Tgl lahir</th>
                                    <th style="border:none;">: <?php echo $rowData->tempat_lahir.', '.$this->utility->mysql_to_tanggal($rowData->tanggal_lahir)   ?>
                                </th>
                                </tr>
                                <tr>
                                    <th style="border:none;">Pekarjaan</th>
                                    <th style="border:none;">: <?php echo $rowData->pekerjaan ?></th>
                                </tr>
                                <tr>
                                    <th style="border:none; ">Alamat</th>
                                    <th style="border:none;">: <?php echo $rowData->alamat ?></th>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <img src="<?php echo site_url('qr/build/'.$rowData->no_mr); ?>" width="84" />
                        </td>
                    </tr>
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
        $('#partu_pasien-modal').modal('show');
    });
</script>