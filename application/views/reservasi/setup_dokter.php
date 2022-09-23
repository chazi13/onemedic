<?php
echo messages();
$arrPraktek = array();
if(!empty($rowsPraktek)):
    foreach ($rowsPraktek as $rowPraktek):
        $arrPraktek[] = array(
                            'poli_id' => $rowPraktek->poli_id,
							// 'max_reg_ol' => $rowPraktek->max_reg_ol,
							// 'max_reg_ol_bpjs' => $rowPraktek->max_reg_ol_bpjs,
                            'hari_1' => $rowPraktek->hari_1,
                            'hari_2' => $rowPraktek->hari_2,
                            'hari_3' => $rowPraktek->hari_3,
                            'hari_4' => $rowPraktek->hari_4,
                            'hari_5' => $rowPraktek->hari_5,
                            'hari_6' => $rowPraktek->hari_6,
                            'hari_7' => $rowPraktek->hari_7,
                            'start_num_reg_ol_1' => $rowPraktek->start_num_reg_ol_1,
                            'start_num_reg_ol_2' => $rowPraktek->start_num_reg_ol_2,
                            'start_num_reg_ol_3' => $rowPraktek->start_num_reg_ol_3,
                            'start_num_reg_ol_4' => $rowPraktek->start_num_reg_ol_4,
                            'start_num_reg_ol_5' => $rowPraktek->start_num_reg_ol_5,
                            'start_num_reg_ol_6' => $rowPraktek->start_num_reg_ol_6,
                            'start_num_reg_ol_7' => $rowPraktek->start_num_reg_ol_7,
                            'max_reg_ol_1' => $rowPraktek->max_reg_ol_1,
                            'max_reg_ol_2' => $rowPraktek->max_reg_ol_2,
                            'max_reg_ol_3' => $rowPraktek->max_reg_ol_3,
                            'max_reg_ol_4' => $rowPraktek->max_reg_ol_4,
                            'max_reg_ol_5' => $rowPraktek->max_reg_ol_5,
                            'max_reg_ol_6' => $rowPraktek->max_reg_ol_6,
                            'max_reg_ol_7' => $rowPraktek->max_reg_ol_7,
                            'max_reg_ol_bpjs_1' => $rowPraktek->max_reg_ol_bpjs_1,
                            'max_reg_ol_bpjs_2' => $rowPraktek->max_reg_ol_bpjs_2,
                            'max_reg_ol_bpjs_3' => $rowPraktek->max_reg_ol_bpjs_3,
                            'max_reg_ol_bpjs_4' => $rowPraktek->max_reg_ol_bpjs_4,
                            'max_reg_ol_bpjs_5' => $rowPraktek->max_reg_ol_bpjs_5,
                            'max_reg_ol_bpjs_6' => $rowPraktek->max_reg_ol_bpjs_6,
                            'max_reg_ol_bpjs_7' => $rowPraktek->max_reg_ol_bpjs_7
                            );
    endforeach;
endif;
?>
<div class="card">
    <div class="col-lg-12">
        <div class="card-header">
            <h5 class="card-title"><?php echo $template['title']; ?></h5>
        </div>
        <div class="card-body">
            <form method="post" action="">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="form-group row">
                            <label for="poli_id" class="col-md-2 col-sm-4 control-label">Dokter</label>
                            <div class="col-lg-4 col-md-8 col-sm-8">
                                <?php
                                $optionsDokter = array();
                                $optionsDokter[] = '( Kosong )';
                                foreach($rowsDokter as $rowDokter){
                                    $optionsDokter[$rowDokter->id] = $rowDokter->nama;
                                }
                                echo form_dropdown('dokter_id', $optionsDokter, $dokterId, 'class="form-control"');
                                
                                $optionsPoliklinik = array();
                                $optionsPoliklinik[] = '';
                                foreach ($rowsPoli as $poli) {
                                    $optionsPoliklinik[$poli->poli_id] = $poli->poli_nama;
                                }

                                ?>
                            </div>
                        </div>
                        <?php
                        for($i=1; $i<=3;$i++):
                            $poliId = '';
                            if (array_key_exists(($i-1),$arrPraktek)){
                                $poliId = $arrPraktek[($i-1)]['poli_id'];
                            }

                            if($i != 1){
                                echo '<br/><br/>';
                            }
                        ?>
                        <h3>JADWAL (<?php echo $i?>)</h3>
                        <hr/>
                        <p/>
                        <div class="form-group row">
                            <label for="poli_id_1" class="col-lg-2 col-md-4  col-sm-4 control-label">Poliklinik</label>
                            <div class="col-lg-3 col-sm-8">
                                <?php echo form_dropdown('poli_id_'.$i, $optionsPoliklinik, $poliId, 'class="form-control"'); ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-12 col-sm-12">
                                <div class="table-responsive">
                                    <table class="table no-margin">
                                        <thead>
                                            <tr>
                                                <th class="">&nbsp;</th>
                                                <th class="text-center" style="width:110px;">SENIN</th>
                                                <th class="text-center" style="width:110px;">SELASA</th>
                                                <th class="text-center" style="width:110px;">RABU</th>
                                                <th class="text-center" style="width:110px;">KAMIS</th>
                                                <th class="text-center" style="width:110px;">JUM'AT</th>
                                                <th class="text-center" style="width:110px;">SABTU</th>
                                                <th class="text-center" style="width:110px;">MINGGU</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td style="font-weight:bold;">Jam Praktek</td>
                                                <?php 
                                                for($h=1;$h<=7;$h++):
                                                ?>
                                                <td>
                                                    <div class="input-group">
                                                        <input type="text" name="<?php echo $h.'_'.$i?>" class="form-control form-inline time-mask" value="<?php echo !empty($arrPraktek[($i-1)]['hari_'.$h]) ? $arrPraktek[($i-1)]['hari_'.$h] : ''; ?>">
                                                    </div>
                                                </td>
                                                <?php endfor; ?>
                                            </tr>
                                            <tr>
                                                <td>Nomor Mulai Antrian</td>
                                                <?php 
                                                for($j=1;$j<=7;$j++):
                                                ?>
                                                <td>
                                                    <div class="input-group">
                                                        <input type="text" name="start_num_reg_ol_<?php echo $j.'_'.$i?>" class="form-control form-inline text-center" value="<?php echo !empty($arrPraktek[($i-1)]['start_num_reg_ol_'.$j]) ? $arrPraktek[($i-1)]['start_num_reg_ol_'.$j] : ''; ?>">
                                                    </div>
                                                </td>
                                                <?php endfor; ?>
                                            </tr>
                                            <tr>
                                                <td>Kuota Reg. Umum</td>
                                                <?php 
                                                for($k=1;$k<=7;$k++):
                                                ?>
                                                <td>
                                                    <div class="input-group">
                                                        <input type="text" name="max_reg_ol_<?php echo $k.'_'.$i?>" class="form-control form-inline  text-center" value="<?php echo !empty($arrPraktek[($i-1)]['max_reg_ol_'.$k]) ? $arrPraktek[($i-1)]['max_reg_ol_'.$k] : ''; ?>">
                                                    </div>
                                                </td>
                                                <?php endfor; ?>
                                            </tr>
                                            <tr>
                                                <td>Kuota Reg. BPJS</td>
                                                <?php 
                                                for($l=1;$l<=7;$l++):
                                                ?>
                                                <td>
                                                    <div class="input-group">
                                                        <input type="text" name="max_reg_ol_bpjs_<?php echo $l.'_'.$i?>" class="form-control form-inline  text-center" value="<?php echo !empty($arrPraktek[($i-1)]['max_reg_ol_bpjs_'.$l]) ? $arrPraktek[($i-1)]['max_reg_ol_bpjs_'.$l] : ''; ?>">
                                                    </div>
                                                </td>
                                                <?php endfor; ?>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <?php 
                        endfor;
                        ?>
                    </div>
                </div>
                <div class="text-right">
                    <button type="submit" name="save-button" class="btn btn-sm btn-primary" value="1">Simpan <i class="icon-paperplane ml-2"></i></button>
                </div>
            </form>
            <hr/>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('select[name="dokter_id"]').on('change', function(){
            window.location = '<?php echo site_url('reservasi/setup_dokter/index/') ?>'+$(this).val();
        });
        $(".form-control.time-mask").inputmask('h:s - h:s', {placeholder: 'hh:mm - hh:mm'});
    });
</script>