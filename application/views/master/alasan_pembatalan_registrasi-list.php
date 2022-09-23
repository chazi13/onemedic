<?php echo messages(); ?>
<div class="card">
    <div class="card-header header-elements-inline">
        <h5 class="card-title">Alasan Pembatalan Registrasi</h5>
        <div class="header-elements">
			<a href="<?php echo site_url('master/alasan_pembatalan_registrasi/add') ?>"  class="btn btn-sm btn-primary">Tambah</a>
		</div>
    </div>			
	<div class="card-body">
		<div class="table-responsive">
            <table id="datatable" class="table">
                <thead>
                    <tr>
                        <th style="text-align: left; font-weight: bold;">Uraian</th>
                        <th style="text-align: center; font-weight: bold; width: 170px;">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $i = 0;
                if ($rowsData):
                foreach ($rowsData as $row):
                    if($row->status != 0){
                    $i++;
                    ?>
                    <tr>
                        <td><?php echo $row->uraian ?></td>
                        <td class="text-center">
                            <a class="text-success" data-toggle="tooltip" data-placement="top" title="" data-button="edit" href="<?php echo site_url('master/alasan_pembatalan_registrasi/edit/'.$row->id)?>" style="margin-left: 5px;" data-original-title="Edit"><i class="icon-pencil5"></i></a>
                            <a class="text-danger" data-toggle="tooltip" data-placement="top" title="" data-button="delete" href="<?php echo site_url('master/alasan_pembatalan_registrasi/delete/'.$row->id)?>" style="margin-left: 5px;" data-original-title="Delete"><i class="icon-trash"></i></a>
                        </td>
                    </tr>
                    <?php }
                endforeach; 
                endif; 
                ?>
                </tbody>
            </table>
		</div>
	</div>
</div>

<?php $this->load->view('delete-modal'); ?>