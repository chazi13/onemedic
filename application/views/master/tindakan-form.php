<!-- BEGIN CONTENT-->
<div class="section-header">
    <h2 class="no-margin"><?php echo $form_title ?></h2>
</div>
<div class="section-body">
    <!-- BEGIN FORM -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <form class="form-horizontal" novalidate="novalidate" method="post" action="">
					<div class="card-body">
						<div class="col-lg-6 col-md-6"> 
							<?php
								echo $form->fields(
										array(
											'id',
											'kategori_tindakan_id',
											'sumber_pendapatan_id',
											'group_bagian_rs_id',
											'group_tindakan_rs_id',
											'is_parent',
											'kode',
											'nama',
											'satuan_id'
										)
								);
							?>
							
						</div>
						<div class="col-lg-6 col-md-6">
							<?php
								echo $form->fields(
										array(
											'tipe_jasmed',
											'tarif'
										)
								);
								if($tipe_jasmed=='N'){
									$display='';
								}else{
									$display='none';
								}
							?>
							<div class="nominal-field" style="display:<?php echo $display?>;">
								<?php
									$jasmed_rupiah = 0;
									$jasmed_id = 0;
									$katJasMeds = $this->kategori_jasa_medis_model->get_list_nominal();
									foreach($katJasMeds as $katJasmed){
										$tarifJasmeds = $this->jasa_medis_model->get_by_tindakan($id);
										foreach($tarifJasmeds as $tarifJasmed){
											if($tarifJasmed->kategori_jasa_medis_id==$katJasmed->id){
												$jasmed_rupiah = $tarifJasmed->jasa_medis_rupiah;
												$jasmed_id = $tarifJasmed->id;
											}
										}
								?>
								<div class="form-group">
									<label class="col-md-4 col-sm-4 control-label" for="tarif_<?php echo $katJasmed->id?>"><?php echo $katJasmed->nama?></label>
									<div class="col-md-8 col-sm-8">
										<input type="hidden" value="<?php echo $jasmed_id?>" name="tarif_jasmed[<?php echo $katJasmed->id?>][jasmed_id]"/>
										<input type="hidden" value="<?php echo $katJasmed->id?>" name="tarif_jasmed[<?php echo $katJasmed->id?>][kategori_jasa_medis_id]"/>
										<input type="hidden" value="<?php echo $katJasmed->kode_nominal?>" name="tarif_jasmed[<?php echo $katJasmed->id?>][kode_nominal]"/>
										<input type="text" value="<?php echo $jasmed_rupiah;?>" id="tarif_<?php echo $katJasmed->id?>" name="tarif_jasmed[<?php echo $katJasmed->id?>][tarif]" class="form-control"/>
									</div>
								</div>
								<?php
									}
								?>
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
								),
								array(
									'id' => 'cancel-button',
									'type' => 'submit',
									'value' => lang('cancel'),
									'class' => 'btn ink-reaction btn-raised btn-sm btn-default'
								)
							));
							?>
						</div>
					</div>
				</form>
            </div>
        </div><!--end .col -->
    </div><!--end .row -->
    <!-- END FORM -->
</div><!--end .section-body -->
<!-- END CONTENT -->

<script>
    $(window).load(function() {
		
		$('select[name="group_bagian_rs_id"]').removeClass('form-control').addClass('group_bagian_rs form-control');
		$('select[name="tipe_jasmed"]').removeClass('form-control').addClass('tipe_jasmed form-control');
		
        // Pemilihan Group Tindakan RS
        $('.group_bagian_rs').on('change', function() {
            var id = this.name;
            var action = 'get_group_bagian_rs';
            var next_dd = 'group_tindakan_rs_id';
            var value_id = this.value;

            get_group_bagian_rs(value_id, action, next_dd, 0);
        });
		
        function get_group_bagian_rs(value_id, action, next_dd, selectedVal) {
            $.ajax({
                url: '<?php echo site_url("master/tindakan") ?>/' + action,
                type: "POST",
                data: {id: value_id},
                success: function(response) {
                    if (next_dd !== '') {
                        var listitems;
                        var $select = $('select[name="' + next_dd + '"]');
                        $select.find('option').remove();
                        $.each(response, function(keyOpt, valueOpt) {
                            if (valueOpt !== undefined) {
                                listitems += '<option value=' + keyOpt + '>' + valueOpt + '</option>';
                            }
                        });
                        $('select[name="' + next_dd + '"]').append(listitems);
                        $('select[name="' + next_dd + '"]').val(selectedVal);
                    }
                },
                error: function() {
                }
            });
        }
		
		$('.tipe_jasmed').on('change', function() {
            var value = this.value;

            if(value == 'N'){
				$('.nominal-field').show();
			}else{
				$('.nominal-field').hide();
			}
        });

    });
</script>