<!-- BEGIN CONTENT-->
<?php echo messages(); ?>
<?php echo validation_errors(); ?>
<div class="section-header">
    <h3 class="no-margin">PENDAFTARAN PASIEN LAMA
        <div class="pull-right">
            <a class="btn ink-reaction btn-raised btn-sm btn-success" href="<?php echo site_url('pendaftaran/baru') ?>" id=""><i class="fa fa-refresh"></i> Input Pasien Baru</a>&nbsp;&nbsp;&nbsp;
        </div>
    </h3>
</div>
<div class="section-body">    
    <div class="row">
        <div class="card">
            <div class="col-lg-offset-1 col-lg-8 ">
                <p/>
                <div class="form-horizontal" >
                    <div class="form-group">
                        <label class="col-md-4 col-sm-4 control-label">No. MR / Nama / Alamat</label>
                        <div class="col-md-8 col-sm-8">
                            <input type="text" class="form-control" id="search_key" value="" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="section-body">    
    <div class="row">
        <div class="card">
            
        <form class="form-horizontal" id="pdf_pasien" method="post">
                <div class="card-body">
                    <?php
                    echo $form->fields(
                            array('id', 'pasien_id')
                    );
                    ?>
                    <div class="col-lg-6 col-md-6">
                        <h3>Data Pasien</h3>
                        <div class="form-group">
                            <label class="col-md-4 col-sm-4 control-label">Nomor MR</label>
                            <div class="col-md-8 col-sm-8">
                                <p class="form-control-static"><?php echo !empty($pasien->no_mr) ? $pasien->no_mr : '' ?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 col-sm-4 control-label">Nama</label>
                            <div class="col-md-8 col-sm-8">
                                <p class="form-control-static"><?php echo !empty($pasien->nama) ? $pasien->nama : '' ?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 col-sm-4 control-label">Jenis Kelamin</label>
                            <div class="col-md-8 col-sm-8">
                                <p class="form-control-static"><?php echo !empty($pasien->jenis_kelamin) ? $pasien->jenis_kelamin : '' ?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 col-sm-4 control-label">Tempat, Tgl. Lahir</label>
                            <div class="col-md-8 col-sm-8">
                                <p class="form-control-static">
                                <?php echo !empty($pasien->tempat_lahir) ? $pasien->tempat_lahir : '' ?>,
                                <?php echo !empty($pasien->tanggal_lahir) ? $this->utility->mysql_to_tanggal($pasien->tanggal_lahir) : '' ?>
                                </p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 col-sm-4 control-label" for="umur">Umur</label>
                            <div class="col-md-8 col-sm-8">
                                <p class="form-control-static"><span id="pasien_umur_tahun_text"></span> Tahun, <span id="pasien_umur_bulan_text"></span> Bulan, <span id="pasien_umur_hari_text"></span> Hari</p>
                                <input type="hidden" value="" id="pasien_umur_tahun" name="pasien_umur_tahun"  />
                                <input type="hidden" value="" id="pasien_umur_bulan" name="pasien_umur_bulan" />
                                <input type="hidden" value="" id="pasien_umur_hari" name="pasien_umur_hari" />
                            </div>
                        </div>
                        <?php
                        echo $form->fields(
                                array(
                                    'pasien_agama',
                                    'pasien_no_identitas',
                                    'pasien_alamat',
                                    'pasien_alamat_daerah',
                                    'pasien_kewarganegaraan',
                                    'pasien_negara',
                                    'pdf_status_perkawinan',
                                    'pdf_pendidikan_terakhir',
                                    'pdf_pekerjaan',
                                    'pdf_pekerjaan_nama_tempat',
                                    'pdf_pekerjaan_nip',
                                    'pdf_pekerjaan_golongan',
                                    'pasien_email',
                                    'pasien_provinsi_id',
                                    'pasien_kabupaten_id',
                                    'pasien_kecamatan_id',
                                    'pasien_kelurahan_id',
                                    'pasien_telepon',
                                    'pasien_nama_ayah',
                                    'pasien_nama_ibu',
                                    'pasien_pekerjaan_orang_tua',
                                )
                        );
                        ?>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <h3>Data Registrasi</h3>
                        <?php
                        echo $form->fields(
                                array(
                                    'pdf_poli_id',
                                    'pdf_dokter_id',
                                    'pdf_dokter_dpjp_id',
                                    'pdf_jenis_kedatangan',
                                    'pdf_rujukan_dari_id',
                                    'pdf_rujukan_nama',
                                    'pdf_rujukan_tanggal',
                                    'pasien_tipe_pasien_id',
                                    'pdf_perusahaan_id'
                                )
                        );
                        ?>
                        <p/>
                        <h3>Penjamin / Asuransi</h3>
                        <?php
                        echo $form->fields(
                                array(
                                    'pdf_asuransi_id',
                                    'pdf_no_surat_jaminan',
                                    'pdf_no_kartu',
                                    'pdf_tanggal_surat_jaminan',
                                )
                        );
                        ?>
                        <p/>
                        <h3>Penanggung Pasien</h3>
                        <?php
                        echo $form->fields(
                                array(
                                    'pdf_penanggung_id',
                                    'pdf_kontak_nama',
                                    'pdf_kontak_alamat',
                                    'pdf_kontak_kota',
                                    'pdf_kontak_telepon',
                                    'pdf_kontak_jenis_identitas',
                                    'pdf_kontak_no_identitas'
                                )
                        );
                        ?>
                        <p/>
                    </div>
                </div>
                <div class="card-actionbar">
                    <div class="card-actionbar-row">
                        <?php
                        echo form_actions(array(
                            array(
                                'id' => 'save-button',
                                'type' => 'submit',
                                'value' => lang('save'),
                                'class' => 'btn ink-reaction btn-raised btn-md btn-success'
                            )
                        ));
                        ?>
                    </div>
                </div>
            </form>

        </div>
    </div><!--end .row -->
    <!-- END FORM -->
</div><!--end .section-body -->
<!-- END CONTENT -->

<script>
    $(window).load(function() {
        // Pencarian pasien lama
        $("#search_key").autocomplete({
                source: "<?php echo site_url('autocomplete/pasien'); ?>",
                minLength: 1,
                html: true,
                select: function(event, ui) {
                    event.preventDefault();
                    $('input[name="pasien_id"]').val(ui.item.id);
                    window.location = '<?php echo site_url("pendaftaran/lama/index/")?>'+ui.item.value;
                }
            }).autocomplete( "instance" )._renderItem = function( ul, item ) {
                return $( "<li>" )
                  .append( "<div>" + item.label + "<br>" + item.alamat + "</div>" )
                  .appendTo( ul );
        };

        hitungUmur();
        function hitungUmur() {
            <?php
            if(!empty($pasien->tanggal_lahir)):
            ?>
            var tglLahir = '<?php echo substr($pasien->tanggal_lahir,8,4) ?>';
            var blnLahir = '<?php echo substr($pasien->tanggal_lahir,5,2) ?>';
            var thnLahir = '<?php echo substr($pasien->tanggal_lahir,0,4) ?>';
            <?php
            else:
            ?>
            var tglLahir = '<?php echo date('d') ?>';
            var blnLahir = '<?php echo date('m') ?>';
            var thnLahir = '<?php echo date('Y') ?>';
            <?php
            endif;
            ?>
            if (tglLahir.length == 2 && blnLahir.length == 2 && thnLahir.length == 4) {

                $('input[name="pasien_tanggal_lahir"]').val(thnLahir + '-' + blnLahir + '-' + tglLahir);

                var now = new Date();

                var dayBD = parseInt(tglLahir);
                var monthBD = parseInt(blnLahir);
                var yearBD = parseInt(thnLahir);

                var dayNow = now.getDate();
                var monthNow = now.getMonth() + 1;
                var yearNow = now.getFullYear();

                umurTahun = yearNow - yearBD;
                umurBulan = monthNow - monthBD;
                umurHari = dayNow - dayBD;
                if (monthNow < monthBD) {
                    umurBulan = umurBulan + 12;
                    umurTahun = umurTahun - 1;
                }
                if (dayNow < dayBD) {
                    umurHari = umurHari + 30;
                    umurBulan = umurBulan - 1;
                    if (umurBulan < 0) {
                        umurBulan = 0;
                        umurTahun = umurTahun = (yearNow - yearBD) - 1;
                    }
                }
                $('#pasien_umur_tahun').val(umurTahun);
                $('#pasien_umur_bulan').val(umurBulan);
                $('#pasien_umur_hari').val(umurHari + 1);
                $('#pasien_umur_tahun_text').text(umurTahun);
                $('#pasien_umur_bulan_text').text(umurBulan);
                $('#pasien_umur_hari_text').text(umurHari + 1);
            }
        }
            
        // Filter Dokter yang tampil sesuai dengan poli
        $('select[name="pdf_poli_id"]').on('change', function() {
            get_dokter_poli();
        });
        

        get_dokter_poli();
        function get_dokter_poli() {
            var poliId = $('select[name="pdf_poli_id"]').val() || 0;
            $.ajax({
                url: '<?php echo site_url("pendaftaran/lama/") ?>/get_dokter_poli',
                type: "POST",
                data: {poli_id: poliId},
                success: function(response) {
                    var listitems;
                    var dokterId = <?php echo!empty($dokter_id) ? $dokter_id : 0; ?>;
                    var $select = $('select[name="pdf_dokter_id"]');
                    $select.find('option').remove();
                    $.each(response, function(keyOpt, valueOpt) {
                        if (valueOpt !== undefined) {
                            listitems += '<option value=' + keyOpt + '>' + valueOpt + '</option>';
                        }
                    });
                    $('select[name="pdf_dokter_id"]').append(listitems);
                    $('select[name="pdf_dokter_id"]').val(dokterId);
                },
                error: function() {
                }
            });
        }

        $('select[name="pasien_provinsi_id"]').removeClass('form-control').addClass('wilayah form-control');
        $('select[name="pasien_kabupaten_id"]').removeClass('form-control').addClass('wilayah form-control');
        $('select[name="pasien_kecamatan_id"]').removeClass('form-control').addClass('wilayah form-control');
        $('select[name="pasien_kelurahan_id"]').removeClass('form-control').addClass('wilayah form-control');

        // Pemilihan Wilayah
        $('.wilayah').on('change', function() {
            var id = this.name;
            switch (id) {
                case 'pasien_provinsi_id':
                    var action = 'kabupaten';
                    var next_dd = 'pasien_kabupaten_id';
                    break;
                case 'pasien_kabupaten_id':
                    var action = 'kecamatan';
                    var next_dd = 'pasien_kecamatan_id';
                    break;
                case 'pasien_kecamatan_id':
                    var action = 'kelurahan';
                    var next_dd = 'pasien_kelurahan_id';
                    break;
                default:
                    var next_dd = '';
            }
            var value_id = this.value;

            get_wilayah(value_id, action, next_dd, 0);
        });

        get_wilayah(<?php echo $provinsi_id . ",'kabupaten','pasien_kabupaten_id'," . $kabupaten_id ?>);
        get_wilayah(<?php echo $kabupaten_id . ",'kecamatan','pasien_kecamatan_id'," . $kecamatan_id ?>);
        get_wilayah(<?php echo $kecamatan_id . ",'kelurahan','pasien_kelurahan_id'," . $kelurahan_id ?>);

        function get_wilayah(value_id, action, next_dd, selectedVal) {
            if(next_dd !== ''){
                $.ajax({
                    url: '<?php echo site_url("api/wilayah") ?>/' + action,
                    type: "GET",
                    data: {pid: value_id},
                    success: function(response) {
                        if (next_dd !== '') {
                            var listitems;
                            var $select = $('select[name="' + next_dd + '"]');
                            $select.find('option').remove();
                            $.each(response.data, function(keyOpt, valueOpt) {
                                if (valueOpt.id !== undefined) {
                                    listitems += '<option value=' + valueOpt.id + '>' + valueOpt.nama + '</option>';
                                }
                            });
                            $('select[name="' + next_dd + '"]').append(listitems);
                            $('select[name="' + next_dd + '"]').val(selectedVal);
                        }
                    },
                    error: function() {
                    }
                });
            }
        }


        $('#pdf_tanggal_surat_jaminan, #pdf_rujukan_tanggal').datepicker({
            format: 'dd-mm-yyyy',
            formatSubmit: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true
        });

        // set disabled/enambled perusahaan
        var tipePasien = $('select[name="pasien_tipe_pasien_id"]').val() || 0;
        if (tipePasien == 6) {
            $('select[name="pdf_perusahaan_id"]').removeAttr("disabled");
        }

        $('select[name="pasien_tipe_pasien_id"]').change(function() {
            $('select[name="pdf_perusahaan_id"]').attr("disabled", "disabled");
            if ($('select[name="pasien_tipe_pasien_id"]').val() == 6) { // perusahaan
                $('select[name="pdf_perusahaan_id"]').removeAttr("disabled");
            }
        });

        // set disabled/enambled penjamin
        $('select[name="pdf_asuransi_id"]').change(function() {
            $val = $(this).val() || 0;
            $('input[name="pdf_no_surat_jaminan"], input[name="pdf_no_kartu"], input[name="pdf_tanggal_surat_jaminan"]').attr("disabled", "disabled");
            if ($val > 0) { // perusahaan
                $('input[name="pdf_no_surat_jaminan"], input[name="pdf_no_kartu"], input[name="pdf_tanggal_surat_jaminan"]').removeAttr("disabled");
            }
        });

        // set disabled/enambled rujukan
        $('select[name="pdf_jenis_kedatangan"]').change(function() {
            if ($(this).val() == 'Rujukan') {
                $('select[name="pdf_rujukan_dari_id"], #pdf_rujukan_nama, #pdf_rujukan_tanggal').removeAttr("disabled");
            }
            else {
                $('select[name="pdf_rujukan_dari_id"], #pdf_rujukan_nama, #pdf_rujukan_tanggal').val('');
                $('select[name="pdf_rujukan_dari_id"], #pdf_rujukan_nama, #pdf_rujukan_tanggal').attr("disabled", "disabled");
            }
        });

        $('.box-content').find('label').each(function(i, ojb) {
            if ($(this).hasClass('control-label col-lg-2')) {
                $(this).removeClass('control-label col-lg-2').addClass('control-label col-lg-4');
            }
        });

        $('.box-content').find('div').each(function(i, ojb) {
            if ($(this).hasClass('col-lg-10')) {
                $(this).removeClass('col-lg-10').addClass('col-lg-8');
            }
        });

    });
</script>