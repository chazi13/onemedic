<div class="content">
	<div class="row">
		<div class="col-lg-12 text-center" >
			<span style="font-weight:600; font-size:22px;">PENGAMBILAN NOMOR ANTRIAN PENDAFTARAN</span><br/>
			<span style="font-weight:600; font-size:18px;">RST. SATU MEDIKA INDONESIA</span>
		</div>
	</div>
	<div class="row">
		<?php
			foreach($rowsDokter as $row):
		?>
		<div class="col-xl-6 col-sm-6">
			<div class="card">
				<div class="card-body text-center">
					<h6 class="font-weight-semibold mb-0"><?php echo $row->poli_nama;?></h6>
					<span class="d-block text-muted"><?php echo $row->dokter_nama;?></span>
<br>
<br>
					<span style="font-size:16px;" class="btn btn-primary btn-get-nomor" dokter="<?php echo $row->dokter_id; ?>" poli="<?php echo $row->poli_id; ?>">Ambil Nomor</span>

				</div>
			</div>
		</div>
		<?php
			endforeach;
		?>
	</div>	
</div>	


<script>
$( document ).ready(function() {

	$('.btn-get-nomor').click(function() {
        $.blockUI({ message: 'Selamat Datang' });
		var grup = $(this).attr('grup');
		var dokterId = $(this).attr('dokter');
		var poliId = $(this).attr('poli');
		getNomor(grup, dokterId, poliId);
    });

	function getNomor(grup, dokterId, poliId){
		$.ajax({
			url : '<?php echo site_url("antrian/get_nomor/create") ?>',
			type : 'post',
			data : {
				'grup' : grup,
				'dokter_id' : dokterId,
				'poli_id' : poliId
			},
			dataType:'json',
			complete : function(request,error) {    
				setTimeout($.unblockUI, 1000);
			}
		});
	};
});
</script>
