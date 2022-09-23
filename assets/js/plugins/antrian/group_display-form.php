<!-- BEGIN CONTENT-->
<?php echo messages(); ?>
<div class="card">
    <div class="card-header header-elements-inline">
        <h5 class="card-title">Display <?php echo str_pad($grup, 2, '0', STR_PAD_LEFT); ?></h5>
        <div class="header-elements">
		</div>
    </div>
    <div class="card-body">
        <form method="post" action="">
        <input type="hidden" name="grup" class="form-control text-center" value="Display <?php echo str_pad($grup, 2, '0', STR_PAD_LEFT); ?>" />
            <?php
            $i = 0;
            $checked = '';
            foreach ($rowsDokterPoli as $row):
                $i++;
                $check = $this->db->select('dokter_id')->get_where('antrian_display', array('dokter_id' => $row->dokter_id, "grup = '1'" => null))->row();
                if($check){
                    $checked = 'checked="checked"';
                }else{
                    $checked = '';
                }
            ?>
            <div class="col-xl-3 col-md-6">
                <div class="card card-body">
                    <div class="media">
                        <div class="media-body">
                            <div class="font-weight-semibold">
                                
                                <?php echo $row->dokter_nama; ?>
                            </div>
                            <span class="text-muted"><?php echo $row->poli_nama; ?></span>
                        </div>

                        <div class="ml-3 align-self-center">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <div class="uniform-checker">
                                        <input type="checkbox" class="form-check-input-styled" name="dokter_id[]" value="<?php echo $row->dokter_id; ?>" <?php echo $checked; ?>>
                                    </div>
                                </label>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
            <?php
            endforeach;
            ?>
            <?php
            echo form_actions(array(
                array(
                    'id' => 'save-button',
                    'type' => 'submit',
                    'value' => lang('save'),
                    'class' => 'btn btn-sm btn-success'
                ),
                array(
                    'id' => 'cancel-button',
                    'type' => 'submit',
                    'value' => lang('cancel'),
                    'class' => 'btn btn-sm btn-default'
                )
            ));
            
            ?>      
        </form>
    </div>
</div>
