<!-- BEGIN CONTENT-->
<?php echo messages(); ?>
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="display table table-bordered table-striped" id="dynamic-table-ajax-source">
                <thead>
                    <tr>
                        <td class="font-weight-bold">JENIS BARANG</td>
                        <?php
                        unset($optionsKondisiBarang['']);
                        foreach($optionsKondisiBarang as $keyKondisi => $valKondisi){
                            echo '<td class="text-center font-weight-bold" >'.$valKondisi.'</td>';
                        }
                        ?>
                        <td class="font-weight-bold">JUMLAH</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    unset($optionsJenisBarang['']);
                    foreach($optionsJenisBarang as $key => $val):
                        $rowCountBarang = $this->db->query('SELECT COUNT(id) as jumlah FROM asset_inventarisasi WHERE jenis_barang_id = '.$key)->row();
                        $jumlah = ($rowCountBarang) ? $rowCountBarang->jumlah : 0;
                    ?>
                    <tr>
                        <td><?php echo $val?></td>
                        <?php
                        $jumlahPerKondisi = 0;
                        foreach($optionsKondisiBarang as $keyKondisi => $valKondisi){
                            $getJumlahBarangPerKondisi = $this->db->query('SELECT COUNT(id) as jumlah FROM asset_inventarisasi WHERE jenis_barang_id = '.$key.' AND kondisi_id = '.$keyKondisi)->row();
                            $jumlahPerKondisi = ($getJumlahBarangPerKondisi) ? $getJumlahBarangPerKondisi->jumlah : 0;
                            echo '<td class="text-right" style="width:80px;">'.$jumlahPerKondisi.'</td>';
                        }
                        ?>
                        <td class="text-right" style="width:40px;"><?php echo $jumlah; ?></td>
                    </tr>
                    <?php
                    endforeach;
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
