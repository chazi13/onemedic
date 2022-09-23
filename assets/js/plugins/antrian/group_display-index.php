<!-- BEGIN CONTENT-->
<?php
echo messages();
?>
<div class="section-header">
    <h3 class="no-margin">Daftar Group Display</h3>
</div>
<div class="section-body">
    <div class="row">
        <?php
            for($i=1;$i<=8;$i++){
        ?>
        <div class="col-xl-3 col-md-6">
            <div class="card card-body">
                <div class="media">

                    <div class="media-body">
                        <h3 class="text-center">DISPLAY <?php echo str_pad($i, 2, '0', STR_PAD_LEFT); ?></h3>
                        <?php
                        // get data display
                        $rows = $this->antrian_display_model->get_all(array('grup' => "$i"));
                        if($rows){
                            foreach($rows as $row){
                                echo '<div class="font-weight-semibold">'.$row->dokter_nama.'</div>';
                            }
                        }
                        ?>
                        <br>
                        <a href="<?php echo site_url('antrian/display/index/'.$i) ?>" class="btn btn-info ink-reaction" target="_blank">View</a>
                        <a href="<?php echo site_url('antrian/group_display/edit/'.$i) ?>" class="btn btn-success ink-reaction">Update</a>
                    </div>

                </div>
            </div>
        </div>
        <?php
            }
        ?>
    </div>
</div> 