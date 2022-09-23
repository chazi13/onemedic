
<!-- BEGIN CONTENT-->
<?php echo messages(); ?>
<div class="section-header">
    <h3 class="no-margin">Form Edit Pasien</h3>
</div>
<div class="section-body">
    <!-- BEGIN FORM -->
    <div class="row">
        <div class="card">
            <form class="form-horizontal" method="post">
                <div class="card-body">
                    <div class="col-lg-6 col-sm-6 padded">
                        <?php
                        echo $form->fields(
                                array(
                                    'no_mr',
                                    'alternate_mr',
                                    'nama',
                                    'jenis_kelamin',
                                    'tempat_lahir'
                                )
                        );
                        ?>
                        <div class="form-group">
                            <label class="col-md-4 col-sm-4 control-label" for="lahir_tanggal">Tanggal Lahir</label>
                            <div class="col-md-8 col-sm-8">
                                <div class="input-group input-large">
                                    <span class="input-group-addon">Tgl.</span>
                                    <input type="text" class="tanggalLahir form-control dpd1 " value="<?php echo $lahir_tanggal ?>" id="lahir_tanggal" name="lahir_tanggal" maxlength="2">
                                    <span class="input-group-addon">Bln.</span>
                                    <input type="text" class="tanggalLahir form-control dpd2 " value="<?php echo $lahir_bulan ?>" id="lahir_bulan" name="lahir_bulan" maxlength="2">
                                    <span class="input-group-addon">Thn.</span>
                                    <input type="text" class="tanggalLahir form-control dpd3 " value="<?php echo $lahir_tahun ?>" id="lahir_tahun" name="lahir_tahun" maxlength="5">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 col-sm-4 control-label" for="umur">Umur</label>
                            <div class="col-md-8 col-sm-8">
                                <p class="form-control-static"><span id="umur_tahun_text"><?php //echo $umur_tahun ?></span> Tahun, <span id="umur_bulan_text"><?php //echo $umur_bulan ?></span> Bulan, <span id="umur_hari_text"><?php //echo $umur_hari ?></span> Hari</p>
                                <input type="hidden" value="<?php //echo $umur_tahun ?>" id="umur_tahun" name="umur_tahun"  />
                                <input type="hidden" value="<?php //echo $umur_bulan ?>" id="umur_bulan" name="umur_bulan" />
                                <input type="hidden" value="<?php //echo $umur_hari ?>" id="umur_hari" name="umur_hari" />
                            </div>
                        </div>
                        <?php
                        echo $form->fields(
                                array(
                                    'agama',
                                    'kewarganegaraan',
                                    'negara',
                                    'no_identitas',
//                                    'pdf_status_perkawinan',
//                                    'pdf_pendidikan_terakhir',
                                    'pekerjaan',
                                    'pekerjaan_nama_tempat',
                                    'pekerjaan_nip',
                                    'pekerjaan_golongan',
                                    'email',
                                    'alamat',
                                    'provinsi_id',
                                    'kabupaten_id',
                                    'kecamatan_id',
                                    'kelurahan_id',
                                    'telepon',
                                    'telepon_kantor'
                                )
                        );
                        ?>
                    </div>
                    <p/>
                    <div class="col-lg-6 col-sm-6 padded">
                        <?php
                        echo $form->fields(
                                array(
                                    'golongan_darah',
                                    'resus_faktor',
                                    'pendidikan_terakhir',
                                    'pekerjaan',
                                    'agama',
                                    'kewarganegaraan',
                                    'negara',
                                    'status_perkawinan',
                                    'nama_pasangan',
                                    'nama_ayah',
                                    'nama_ibu',
                                    'pekerjaan_orang_tua'
                                    
                                )
                        );
                        ?>
                        <br/>
                        <fieldset>
                            <legend>Keluarga Dekat<hr></legend>
                            
                        <?php
                        echo $form->fields(
                                array(
                                    'keluarga_dekat_nama',
                                    'keluarga_dekat_alamat',
                                    'keluarga_dekat_kota',
                                    'keluarga_dekat_kode_pos',
                                    'keluarga_dekat_telepon',
                                    
                                )
                        );
                        
                        ?>
                        </fieldset>
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
                                'class' => 'btn ink-reaction btn-raised btn-sm btn-success'
                            ),
                            array(
                                'id' => 'cancel-button',
                                'type' => 'submit',
                                'value' => lang('cancel'),
                                'class' => 'btn ink-reaction btn-raised btn-sm btn-default'
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
            
    hitungUmur();
    $('.tanggalLahir').bind('keyup change', function(e) {
        hitungUmur();
    });
    function hitungUmur() {
            var tglLahir = $('input[name="lahir_tanggal"]').val();
            var blnLahir = $('input[name="lahir_bulan"]').val();
            var thnLahir = $('input[name="lahir_tahun"]').val();
            if (tglLahir.length == 2 && blnLahir.length == 2 && thnLahir.length == 4) {

                $('input[name="tanggal_lahir"]').val(thnLahir + '-' + blnLahir + '-' + tglLahir);

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
                $('#umur_tahun').val(umurTahun);
                $('#umur_bulan').val(umurBulan);
                $('#umur_hari').val(umurHari + 1);
                $('#umur_tahun_text').text(umurTahun);
                $('#umur_bulan_text').text(umurBulan);
                $('#umur_hari_text').text(umurHari + 1);
            }
        }
        
        $('select[name="provinsi_id"]').removeClass('form-control').addClass('wilayah form-control');
        $('select[name="kabupaten_id"]').removeClass('form-control').addClass('wilayah form-control');
        $('select[name="kecamatan_id"]').removeClass('form-control').addClass('wilayah form-control');
        $('select[name="kelurahan_id"]').removeClass('form-control').addClass('wilayah form-control');
        
        $('.wilayah').on('change', function(){
            var id = this.name;
            switch (id) {
                case 'provinsi_id':
                  var action = 'get_kabupaten';
                  var next_dd = 'kabupaten_id';
                  break;
                case 'kabupaten_id':
                  var action = 'get_kecamatan';
                  var next_dd = 'kecamatan_id';
                  break;
                case 'kecamatan_id':
                  var action = 'get_kelurahan';
                  var next_dd = 'kelurahan_id';
                  break;
              default:
                  var next_dd = '';
            }
            var value_id = this.value;
            
            $.ajax({
                url: '<?php echo site_url("pendaftaran")?>/'+action,
                type: "POST",
                data: {id: value_id},
                async: false,
                success: function (response) {
                    if(next_dd !== ''){
                        var listitems;
                        var $select = $('select[name="'+next_dd+'"]');
                            $select.find('option').remove();  
                            $.each(response, function(keyOpt, valueOpt) {   
                                if(valueOpt !== undefined){
                                    listitems += '<option value=' + keyOpt + '>' + valueOpt + '</option>';
                                }
                            });
                            $('select[name="'+next_dd+'"]').append(listitems);
                    }
                },
                error: function () {}
            }); 
        });
</script>
    