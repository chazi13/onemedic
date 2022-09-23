<!-- BEGIN CONTENT-->
<?php echo messages(); ?>
<div class="card">
    <div class="card-body">
        <?php if($rows): ?>
            <table class="table">
                <?php foreach($rows as $row): ?>
                <tr>
                    <td><a href="<?php echo site_url('pendaftaran/home/index/'.$row->no_mr)?>" ><?php echo $row->nama?></a></td>
                    <td class="text-right"><?php echo $this->utility->mysql_to_tanggal($row->tanggal_lahir) ?></td>
                    <td><?php echo $row->alamat?></td>
                </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    </div>
</div>