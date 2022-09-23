<!-- BEGIN CONTENT-->
<?php echo messages();

$arrPoliReservasi = array();
if (!empty($rowsPoliReservasi)) {
    foreach ($rowsPoliReservasi as $rowPoliReservasi):
        $arrPoliReservasi[$rowPoliReservasi->poli_id] = '';
    endforeach;
}
?>
<div class="card">
    <div class="col-lg-12">
        <div class="card-header">
            <h5 class="card-title"><?php echo $template['title']; ?></h5>
        </div>
        <div class="card-body">
            <form method="post" action="">
                <div class="row">
                    <?php
                    $i = 0;
                    $checked = '';
                    foreach ($rowsPoli as $poli):
                        $i++;
                        $checked = '';
                        $maxReg = '';
                        if (array_key_exists($poli->id, $arrPoliReservasi)) {
                            $checked = 'checked="checked"';
                            $maxReg = $arrPoliReservasi[$poli->id];
                        }
                        echo '<div class="col-lg-4 col-md-6">';
                        echo '<div class="checkbox checkbox-styled">';
                        echo '<label><input type="checkbox" name="poli_id[]" value="' . $poli->id . '"  ' . $checked . '/></label>';
                        echo '<span style="padding-left:5px;">' . $poli->nama . '</span>';
                        echo '</div>';
                        echo '</div>';
                    endforeach;
                    ?>
                </div>
                <div class="text-right">
                    <button type="submit" name="save-button" class="btn btn-sm btn-primary">Simpan <i class="icon-paperplane ml-2"></i></button>
                </div>
            </form>
            <hr/>
        </div>
    </div>
</div>