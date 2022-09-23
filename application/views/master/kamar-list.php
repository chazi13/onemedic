<?php echo messages(); ?>
<div class="card">
    <div class="card-header header-elements-inline">
        <h5 class="card-title">DAFTAR KAMAR RUANGAN <?php echo $ruangan->nama; ?></h5>
        <div class="header-elements">
			<a href="<?php echo site_url('master/kamar/add/'.$ruangan->id) ?>"  class="btn btn-sm btn-primary">Tambah</a>
			&nbsp;&nbsp;
			<a href="<?php echo site_url('master/ruangan') ?>"  class="btn btn-sm btn-info">Kembali</a>
		</div>
    </div>			
	<div class="card-body">
		<div class="table-responsive">
			<table id="datatable" class="table">
				<thead>
					<tr>
						<th style="text-align: left; font-weight: bold;">Nama</th>
						<th style="text-align: left; font-weight: bold; width: 200px;">Klasifikasi Tarif</th>
						<th style="text-align: right; font-weight: bold; width: 150px;">Tarif&nbsp;&nbsp;&nbsp;</th>
						<th style="text-align: left; font-weight: bold; width: 230px;">Apotek</th>
						<th style="text-align: center; font-weight: bold; width: 170px;">&nbsp;</th>
					</tr>
				</thead>
				<tbody>
					<?php
				$i = 0;
				if($rowsData):
				foreach ($rowsData as $row):
					$i++;
						$klasifikasi = $this->klasifikasi_tarif_model->get_by_id($row->klasifikasi_tarif_id);
						$apotek = $this->apotek_model->get_by_id($row->apotek_id);
						$apotekNama = ($apotek) ? $apotek->nama : '';
					?>
					<tr>
						<td><?php echo $row->nama ?></td>
						<td><?php echo $klasifikasi->nama ?></td>
						<td class="text-right"><?php echo $this->utility->format_rupiah($row->tarif) ?></td>
						<td><?php echo $apotekNama; ?></td>
						<td class="text-center">
							<a class="text-info" data-toggle="tooltip" data-placement="top" title="" data-button="bed" href="<?php echo site_url('master/bed/index/'. $row->id)?>" style="margin-left: 5px;" data-original-title="Bed"><i class="icon-printer4"></i></a>
							<a class="text-success" data-toggle="tooltip" data-placement="top" title="" data-button="edit" href="<?php echo site_url('master/kamar/edit/'. $row->ruangan_id.'/'.$row->id)?>" style="margin-left: 5px;" data-original-title="Edit"><i class="icon-pencil5"></i></a>
							<a class="text-danger" data-toggle="tooltip" data-placement="top" title="" data-button="delete" href="<?php echo site_url('master/kamar/delete/'. $row->id)?>" style="margin-left: 5px;" data-original-title="Delete"><i class="icon-trash"></i></a>
						</td>
					</tr>
				<?php endforeach; ?>
				<?php endif; ?>
				</tbody>
			</table>
		</div><!--end .table-responsive -->
	</div>
</div><!--end .section-body -->

<?php $this->load->view('delete-modal'); ?>