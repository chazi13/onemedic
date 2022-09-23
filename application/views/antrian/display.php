

<div class="row">
			<div class="card-body">
                <div class="row">
                    <div class="col-md-4 text-center">
                        <?php
                        if($rowsDokterDisplay):
                            foreach($rowsDokterDisplay as $row):
                        ?>
                        <div class="card col-md-12 text-center">
                            <span style="font-size:24px;font-weight:800;"><?php echo $row->poli_nama?></span>
                            <span style="font-size:14px;font-weight:800;"><?php echo $row->dokter_nama?></span>
                            <span style="font-size:38px;font-weight:800;">0000</span>
                        </div>
                        <?php 
                            endforeach;
                        else: 
                        ?>
                        <div class="card col-md-12 text-center">
                            <span style="font-size:38px;font-weight:800;">Setting masih kosong</span>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-8 text-center">
                        <div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                <img class="" src="<?php echo base_url('assets/gallery/1.jpg') ?>" alt="">
                                </div>
                                <div class="carousel-item">
                                <img class="" src="<?php echo base_url('assets/gallery/2.jpg') ?>" alt=" ">
                                </div>
                                <div class="carousel-item">
                                <img class="" src="<?php echo base_url('assets/gallery/3.jpg') ?>" alt=" ">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="container bg-dark">
                        <div id="berita" class=" bg-dark" style="font-size:22px;color:#FFF;">
                            Selalu Lakukan 3 M ( Menjaga jarak, Menggunakan masker, Mencuci tangan dengan sabun )
                        </div>
                    </div>
                </div>
            </div>
</div>

<script>
$( document ).ready(function() {
    
    $("#berita").eocjsNewsticker({
        speed: 25,
        timeout: 0.5,
        divider:   '&nbsp;&nbsp;&nbsp; &bull;&nbsp;',
    });
});
</script>