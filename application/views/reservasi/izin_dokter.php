<!-- BEGIN CONTENT-->
<?php echo messages(); ?>
<div class="card">
    <div class="col-lg-12">
        <div class="card-header">
            <h5 class="card-title"><?php echo $template['title']; ?></h5>
        </div>
        <div class="card-body">
            <form class="form-horizontal" method="post">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="form-group row">
                            <label for="poli_id" class="col-md-2 col-sm-4 control-label">Dokter</label>
                            <div class="col-lg-4 col-md-8 col-sm-8">
                                <?php
                                $optionsDokter = array();
                                if($rowsDokter){
                                    foreach ($rowsDokter as $dokter) {
                                        $optionsDokter[$dokter->dokter_id] = $dokter->dokter_nama;
                                    }
                                }

                                echo form_dropdown('dokter_id', $optionsDokter, 0, 'class="form-control"');
                                ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="poli_id" class="col-md-2 col-sm-4 control-label">Tanggal Izin/Cuti</label>
                            <div class="col-lg-5 col-md-8 col-sm-8">
                                <div class="input-group" >
                                    <input type="text" class="form-control text-right" name="tgl_mulai_izin">
                                    <span class="input-group-append"> <button class="btn btn-light" type="button">s.d</button> </span>
                                    <input type="text" class="form-control text-right" name="tgl_akhir_izin">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-actionbar">
                    <div class="card-actionbar-row">
                        <?php
                        echo form_actions(array(
                            array(
                                'id' => 'save-button',
                                'type' => 'submit',
                                'value' => lang('save'),
                                'class' => 'btn ink-reaction btn-raised btn-sm btn-success'
                            )
                        ));
                        ?>
                    </div>
                </div>
            </div>
        </form>
            <div class="table-responsive no-margin">
                <table class="table table-striped no-margin">
                    <thead>
                        <tr>
                            <th style="width: 35px;">#</th>
                            <th>Nama Dokter</th>
                            <th class="text-center">Tgl. Mulai </th>
                            <th class="text-center">Tgl. Akhir</th>
                            <th class="text-center">&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if(!empty($rowsDokterIzin)):
                            $i = 0;
                            foreach($rowsDokterIzin as $row):
                                $i++;
                        ?>
                        <tr>
                            <td class="text-right"><?php echo $i;?></td>
                            <td><?php echo $row->dokter_nama; ?></td>
                            <td class="text-center"><?php echo $this->utility->mysql_to_tanggal($row->tgl_mulai_izin); ?></td>
                            <td class="text-center"><?php echo $this->utility->mysql_to_tanggal($row->tgl_akhir_izin); ?></td>
                            <td class="text-center">
                                <a class="btn btn-outline bg-danger border-danger text-danger-800 btn-icon btn-xs" data-button="delete" href="<?php echo site_url('reservasi/izin_dokter/delete/'.$row->id) ?>" style="margin-left: 5px;"><i class="icon-trash"></i></a>
                            </td>
                        </tr>
                        <?php 
                            endforeach;
                        else:
                            echo '<tr><td colspan="4">Data kosong</td></tr>'; 
                        endif;
                        ?>
                    </tbody>
                </table>
            </div>
    </div>
</div>
<?php $this->load->view('delete-modal'); ?>
<script>
    $(document).ready(function() {
        $('select').select2();
        $('input[name="tgl_mulai_izin"], input[name="tgl_akhir_izin"]').datepicker({
            format: 'dd-mm-yyyy',
            formatSubmit: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true
        });
    });
</script>