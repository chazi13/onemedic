<!-- BEGIN CONTENT-->
<?php echo messages(); ?>
<div class="card">
    <div class="card-header header-elements-inline">
        <h5 class="card-title">FORM RUANGAN</h5>
        <div class="header-elements">
		</div>
    </div>
    <div class="card-body">
        <form method="post" action="">
            <div class="col-md-6">
            <?php
            echo $form->fields();
            ?>
            <!--<div class="form-group">
                <label class="col-md-4 col-sm-4 control-label">Image Upload</label>
                <div class="col-md-8 col-sm-8">
                    
                    <div class="fileupload fileupload-new" data-provides="fileupload">
                        <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                            <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt="" />
                        </div>
                        <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                        <div>
                            <span class="btn btn-white btn-file">
                                <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select image</span>
                                <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                                <input type="file" class="default" />
                            </span>
                            <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash"></i> Remove</a>
                        </div>
                    </div>
                    
                </div>
            </div>-->
            </div>
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