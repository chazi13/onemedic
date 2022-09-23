<!-- BEGIN CONTENT-->
<?php echo messages(); ?>
<div class="card">
    <div class="card-header header-elements-inline">
        <h5 class="card-title"><?php echo $title; ?></h5>
        <div class="header-elements">
		</div>
    </div>
    <div class="card-body">
        <form method="post" action="">
            <div class="col-md-6">
            <?php
            echo $form->fields();
            
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

<?php $this->load->view('delete-modal'); ?>
