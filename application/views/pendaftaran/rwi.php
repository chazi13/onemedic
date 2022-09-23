<!-- BEGIN CONTENT-->
<?php echo messages(); ?>
<div class="card">
    <div class="card-header header-elements-inline">
        <h5><?php echo $template['title']?></h5>
    </div>
    <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Tempat, Tgl Lahir</th>
                        <th>Poliklinik</th>
                        <th>Dokter</th>
                    </tr>
                </thead>
                <tbody>
                <?php if($rows): ?>    
                <?php 
                $i=0;
                foreach($rows as $row): 
                    $i++;
                    ?>
                <tr>
                    <td class="text-center"><?php echo $i ?></td>
                    <td><a href="<?php echo site_url('pendaftaran/rwi/add/'.$row->id)?>" ><?php echo $row->nama?></a></td>
                    <td class="text-right"><?php //echo $this->utility->mysql_to_tanggal($row->tanggal_lahir) ?></td>
                    <td><?php echo $row->poli_nama?></td>
                    <td><?php echo $row->dokter_nama?></td>
                </tr>
                <?php endforeach; ?>
                <?php else: ?>
                <tr>
                    <td colspan="5">Data kosong.</td>
                </tr>
                <?php endif; ?>
                </tbody>
            </table>
        
    </div>
</div>