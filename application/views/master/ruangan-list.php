<!-- BEGIN CONTENT-->
<?php echo messages(); ?>
<div class="card">
    <div class="card-header header-elements-inline">
        <h5 class="card-title">DAFTAR RUANGAN</h5>
        <div class="header-elements">
			<a href="<?php echo site_url('master/ruangan/add') ?>"  class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Tambah</a>
		</div>
    </div>
    <div class="card-body">
		<div class="table-responsive">
			<table id="datatable" class="table">
				<thead>
					<tr>
						<th style="text-align: left; font-weight: bold;">Nama</th>
						<th style="text-align: left; font-weight: bold; width: 130px;">Jumlah Bed</th>
						<th style="text-align: left; font-weight: bold; width: 100px;">Status</th>
						<th style="text-align: center; font-weight: bold; width: 120px;">&nbsp;</th>
					</tr>
				</thead>
				<tbody>
					<?php
				$i = 0;
				foreach ($rowsData as $row):
					$i++;
					$status = 'Aktif';
					if($row->status == '0'){
						$status = 'Non Aktif';
					}
					?>
					<tr>
						<td><?php echo $row->nama ?></td>
						<td class="text-center">0</td>
						<td><?php echo $status ?></td>
						<td class="text-center">
							<a class="text-info" data-toggle="tooltip" data-placement="top" title="" data-button="kamar" href="<?php echo site_url('master/kamar/index/'. $row->id)?>" style="margin-left: 5px;" data-original-title="Kamar"><i class="icon-printer4"></i></a>
							<a class="text-success" data-toggle="tooltip" data-placement="top" title="" data-button="edit" href="<?php echo site_url('master/ruangan/edit/'. $row->id)?>" style="margin-left: 5px;" data-original-title="Edit"><i class="icon-pencil5"></i></a>
							<a class="text-danger" data-toggle="tooltip" data-placement="top" title="" data-button="delete" href="<?php echo site_url('master/ruangan/delete/'. $row->id)?>" style="margin-left: 5px;" data-original-title="Non Aktif"><i class="icon-eye-blocked"></i></a>
						</td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
		</div><!--end .table-responsive -->
	</div>
</div>

<?php $this->load->view('delete-modal'); ?>