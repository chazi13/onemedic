<!-- BEGIN CONTENT-->
<?php echo messages(); ?>
<div class="card">
    <div class="card-header header-elements-inline">
        <h5 class="card-title">PENDAFTARAN PASIEN RAWAT INAP</h5>
        <div class="header-elements">
        </div>
    </div>
    <div class="card-body">
        <form  id="pasien_rwi" method="post" action="">
            <div class="row">
                <?php echo $form->fields( array('id', 'pasien_id', 'pendaftaran_rwj_id') ); ?>
                <div class="col-md-12">
                    <fieldset >
                        <legend class="text-uppercase font-size-lg font-weight-bold">Data Pasien</legend>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <div class="col-md-4 font-weight-semibold">Nomor MR</div>
                                        <div class="col-md-8">: <?php echo $pasien->no_mr; ?></div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4 font-weight-semibold">No. KTP/KTA/SIM</div>
                                        <div class="col-md-8">: <?php echo $pasien->no_identitas; ?></div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4 font-weight-semibold">Nama</div>
                                        <div class="col-md-8">: <?php echo $pasien->nama; ?></div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4 font-weight-semibold">Tempat, Tgl Lahir</div>
                                        <div class="col-md-8">: <?php echo $pasien->tempat_lahir.', '.$pasien->tanggal_lahir; ?></div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4 font-weight-semibold">Jenis Kelamin</div>
                                        <div class="col-md-8">: <?php echo $pasien->jenis_kelamin; ?></div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4 font-weight-semibold">Agama</div>
                                        <div class="col-md-8">: <?php echo $pasien->agama; ?></div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4 font-weight-semibold">Status Perkawinan</div>
                                        <div class="col-md-8">: <?php echo $pasien->status_perkawinan; ?></div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4 font-weight-semibold">Pekerjaan</div>
                                        <div class="col-md-8">: <?php echo $pasien->pekerjaan; ?></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <div class="col-md-3 font-weight-semibold">Alamat</div>
                                        <div class="col-md-9">: <?php echo $pasien->alamat; ?></div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 font-weight-semibold">Daerah</div>
                                        <div class="col-md-9">: <?php echo $pasien->alamat_daerah; ?></div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 font-weight-semibold">Provinsi</div>
                                        <div class="col-md-9">: <?php echo $pasien->provinsi_nama; ?></div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 font-weight-semibold">Kab./Kota</div>
                                        <div class="col-md-9">: <?php echo $pasien->kabupaten_nama; ?></div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 font-weight-semibold">Kecamatan</div>
                                        <div class="col-md-9">: <?php echo $pasien->kecamatan_nama; ?></div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 font-weight-semibold">Kelurahan</div>
                                        <div class="col-md-9">: <?php echo $pasien->kelurahan_nama; ?></div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 font-weight-semibold">Email</div>
                                        <div class="col-md-9">: <?php echo $pasien->email; ?></div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 font-weight-semibold">Telepon</div>
                                        <div class="col-md-9">: <?php echo $pasien->telepon; ?></div>
                                    </div>
                                </div>
                            </div>
                    </fieldset>
                    <fieldset>
                        <legend class="text-uppercase font-size-lg font-weight-bold">Penanggung Jawab</legend>
                            <div class="row">
                                <div class="col-md-6">
                                    <?php
                                    echo $form->fields(
                                            array(
                                                'penanggung_id',
                                                'kontak_nama',
                                                'kontak_alamat',
                                                'kontak_kota'
                                            )
                                    );
                                    ?>
                                </div>
                                <div class="col-md-6">
                                    <?php
                                    echo $form->fields(
                                            array(
                                                'kontak_telepon',
                                                'kontak_jenis_identitas',
                                                'kontak_no_identitas'
                                            )
                                    );
                                    ?>
                                </div>
                            </div>
                    </fieldset>
                    <fieldset >
                        <legend class="text-uppercase font-size-lg font-weight-bold">Kelas/Ruang Perawatan</legend>
                            <div class="row">
                                <div class="col-md-4">
                                    <?php echo $form->fields(array('ruangan_id')); ?>
                                </div>
                                <div class="col-md-4">
                                    <?php echo $form->fields(array('kamar_id')); ?>
                                </div>
                                <div class="col-md-4">
                                    <?php echo $form->fields(array('bed_id')); ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <?php echo $form->fields(array('tanggal_masuk')); ?>
                                </div>
                                <div class="col-md-4">
                                    <?php echo $form->fields(array('jam_masuk')); ?>
                                </div>
                                <div class="col-md-4">
                                    <?php echo $form->fields(array('dokter_dpjp_id')); ?>
                                </div>
                            </div>
                    </fieldset>
                    <fieldset >
                        <legend class="text-uppercase font-size-lg font-weight-bold">Asuransi/Jaminan Kesehatan</legend>
                            <div class="row">
                                <div class="col-md-6">
                                    <?php echo $form->fields(array('asuransi_id')); ?>
                                </div>
                                <div class="col-md-6">
                                    <?php echo $form->fields(array('no_kartu')); ?>
                                </div>
                            </div>
                    </fieldset>
                </div>
            </div>
            <div class="text-right">
                <button type="submit" class="btn btn-primary"> <?php echo lang('save') ?> <i class="icon-paperplane ml-2"></i></button>
            </div>
        </form>
    </div>
</div>



<script>
    $( document ).ready(function() {
        $('input[name="jam_masuk"]').mask('00:00:00');
        $('select[name="ruangan_id"]').on('change', function() {
            get_kamar();
        });
        $('select[name="kamar_id"]').on('change', function() {
            get_bed();
        });

        get_kamar();
        get_bed();
        function get_kamar() {
            var ruanganId = $('select[name="ruangan_id"]').val() || 0;
            $.ajax({
                url: '<?php echo site_url("pendaftaran/rwi") ?>/get_kamar',
                type: "POST",
                data: {ruangan_id: ruanganId},
                success: function(response) {
                    var listitems;
                    var $select = $('select[name="kamar_id"]');
                    $select.find('option').remove();
                    $.each(response, function(keyOpt, valueOpt) {
                        if (valueOpt !== undefined) {
                            listitems += '<option value=' + keyOpt + '>' + valueOpt + '</option>';
                        }
                    });
                    $('select[name="kamar_id"]').append(listitems);
                },
                error: function() {
                }
            });
        }
        function get_bed() {
            var kamarId = $('select[name="kamar_id"]').val() || 0;
            $.ajax({
                url: '<?php echo site_url("pendaftaran/rwi") ?>/get_bed',
                type: "POST",
                data: {kamar_id: kamarId},
                success: function(response) {
                    var listitems;
                    var $select = $('select[name="bed_id"]');
                    $select.find('option').remove();
                    $.each(response, function(keyOpt, valueOpt) {
                        if (valueOpt !== undefined) {
                            listitems += '<option value=' + keyOpt + '>' + valueOpt + '</option>';
                        }
                    });
                    $('select[name="bed_id"]').append(listitems);
                },
                error: function() {
                }
            });
        }


        $('#tanggal_masuk').datepicker({
            format: 'dd-mm-yyyy',
            formatSubmit: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true
        });
    });
</script>