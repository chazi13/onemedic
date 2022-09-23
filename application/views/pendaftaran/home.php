<!-- BEGIN CONTENT-->
<?php echo messages(); ?>
<div class="card">
    <div class="card-header header-elements-inline">
        <h5 class="card-title"><?php echo $template['title']?></h5>
        <div class="header-elements">
        </div>
    </div>
    <div class="card-body">
        <form class="" id="pdf_pasien" method="post" action="">
            <div class="row">
                <?php echo $form->fields( array('id', 'pasien_id', 'pasien_tanggal_lahir') ); ?>
                <div class="col-md-6">
                    <fieldset class="">
                        <legend class="text-uppercase font-size-sm font-weight-bold">Data Pasien</legend>
                        <?php
                        echo $form->fields(
                                array(
                                    'pasien_no_mr',
                                    'pasien_nama',
                                    'pasien_jenis_kelamin',
                                    'pasien_tempat_lahir'
                                )
                        );
                        ?>
                        <div class="form-group row">
                            <label class="col-md-4 control-label" for="pasien_lahir_tanggal">Tanggal Lahir <i class="fa fa-asterisk text-warning"></i></label>
                            <div class="col-md-8">
                                <div class="input-group">
                                <input type="text" class="tanggalLahir form-control dpd1 " value="<?php echo $pasien_lahir_tanggal ?>" id="pasien_lahir_tanggal" name="pasien_lahir_tanggal" maxlength="2" placeholder="Tgl" />
                                    <span class="input-group-prepend">
                                        <span class="input-group-text">/</span>
                                    </span>
                                    <input type="text" class="tanggalLahir form-control dpd2 " value="<?php echo $pasien_lahir_bulan ?>" id="pasien_lahir_bulan" name="pasien_lahir_bulan" maxlength="2" placeholder="Bln" />
                                    <span class="input-group-prepend">
                                        <span class="input-group-text">/</span>
                                    </span>
                                    <input type="text" class="tanggalLahir form-control dpd3 " value="<?php echo $pasien_lahir_tahun ?>" id="pasien_lahir_tahun" name="pasien_lahir_tahun" maxlength="4" placeholder="Thn" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4  control-label" for="umur">Umur</label>
                            <div class="col-md-8 ">
                                <p class="form-control-static"><span id="pasien_umur_tahun_text"><?php echo $pasien_umur_tahun ?></span> Tahun, <span id="pasien_umur_bulan_text"><?php echo $pasien_umur_bulan ?></span> Bulan, <span id="pasien_umur_hari_text"><?php echo $pasien_umur_hari ?></span> Hari</p>
                                <input type="hidden" value="<?php echo $pasien_umur_tahun ?>" id="pasien_umur_tahun" name="pasien_umur_tahun"  />
                                <input type="hidden" value="<?php echo $pasien_umur_bulan ?>" id="pasien_umur_bulan" name="pasien_umur_bulan" />
                                <input type="hidden" value="<?php echo $pasien_umur_hari ?>" id="pasien_umur_hari" name="pasien_umur_hari" />
                            </div>
                        </div>
                        <?php
                        echo $form->fields(
                                array(
                                    'pasien_agama',
                                    'pasien_no_identitas',
                                    'pasien_alamat',
                                    'pasien_alamat_daerah',
                                    'pasien_golongan_darah',
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
                    </fieldset>
                </div>
                <div class="col-md-6">
                    <fieldset class="">
                        <legend class="text-uppercase font-size-sm font-weight-bold">Data Pendaftaran</legend>
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
                    </fieldset>
                </div>
            </div>
            <div class="text-right">
                <button type="submit" class="btn btn-primary"> <?php echo lang('save') ?> <i class="icon-paperplane ml-2"></i></button>
            </div>
        </form>
    </div>
</div>


<div id="modal-form-bpjs" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 id="modal-formLabel">Data Peserta BPJS </h4>
            </div>
            <div class="modal-body">
                <form role="search" class="navbar-for" id="">
                    <fieldset>
                        <div class="bpjs-alert alert alert-warning ">
                            <span class="alert-icon"><i class="fa fa-bell-o"></i></span>
                            <div class="notification-info">
                                <ul class="clearfix notification-meta">
                                    <li class="pull-left notification-sender">Peserta BPJS tidak ditemukan.</li>
                                </ul>
                                <p>
                                    Silahkan lakukan kembali pencarian data peserta.
                                </p>
                            </div>
                        </div>
                        <table class="table table-responsive" id='bpjs-details'>
                            <tr>
                                <td class="col-lg-3">Status</td>
                                <td >: <span id='bpjs-data-status'style="color:green;font-size: 16px; font-weight: bold;"></span></td>
                            </tr>
                            <tr>
                                <td class="col-lg-3">No. Kartu</td>
                                <td >: <span id='bpjs-data-nokartu'>-</span></td>
                            </tr>
                            <tr>
                                <td>NIK</td>
                                <td>: <span id='bpjs-data-nik'>-</span></td>
                            </tr>
                            <tr>
                                <td>Nama</td>
                                <td>: <span id='bpjs-data-nama'>-</span></td>
                            </tr>
                            <tr>
                                <td>Tgl. Lahir</td>
                                <td>: <span id='bpjs-data-tgllahir'>-</span></td>
                            </tr>
                            <tr>
                                <td>Fakses</td>
                                <td>: <span id='bpjs-data-faskes'>-</span></td>
                            </tr>
                        </table>
                    </fieldset>
                </form>
            </div>
            <div id="search-result-bpjs"></div>
            <div class="modal-footer">
                <button class="btn btn-default" data-dismiss="modal"><?php echo lang('close') ?></button>
            </div>
        </div>
    </div>
</div>

<script>
    $( document ).ready(function() {
            
        $('#pdf_pasien').submit(function(event) {

            event.preventDefault(); 
            var tglLahir = $('input[name="pasien_lahir_tanggal"]').val();
            var blnLahir = $('input[name="pasien_lahir_bulan"]').val();
            var thnLahir = $('input[name="pasien_lahir_tahun"]').val();
            var strTgl = thnLahir + '-' + blnLahir + '-' + tglLahir;
            var date = moment(strTgl);
            var umur = $('#pasien_umur_tahun_text').text();
            if (date.isValid() !== true) {
                $.notify({
                    message: 'Format tanggal lahir tidak sesuai.' 
                },{
                    type: 'danger'
                });
            } else {
                if(parseFloat(umur) < 0){
                    $.notify({
                        message: 'Umur kurang dari 0 tahun.' 
                    },{
                        type: 'danger'
                    });
                }else{
                    $(this).unbind('submit').submit(); // continue the submit unbind preventDefault
                }
            }
        })


        $('#pasien_no_mr').attr("readonly", "readonly");

//        $('select[name="pdf_poli_id"], select[name="pdf_dokter_id"], select[name="pdf_perusahaan_id"], select[name="pdf_asuransi_id"]').select2();

        $('select[name="pasien_provinsi_id"]').removeClass('form-control').addClass('wilayah form-control');
        $('select[name="pasien_kabupaten_id"]').removeClass('form-control').addClass('wilayah form-control');
        $('select[name="pasien_kecamatan_id"]').removeClass('form-control').addClass('wilayah form-control');
        $('select[name="pasien_kelurahan_id"]').removeClass('form-control').addClass('wilayah form-control');


        // Filter Dokter yang tampil sesuai dengan poli
        $('select[name="pdf_poli_id"]').on('change', function() {
            get_dokter_poli();
        });

        get_dokter_poli();
        function get_dokter_poli() {
            var poliId = $('select[name="pdf_poli_id"]').val() || 0;
            $.ajax({
                url: '<?php echo site_url("pendaftaran/home") ?>/get_dokter_poli',
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

        // Pemilihan Kewarganegaraan
        $('select[name="pasien_kewarganegaraan"]').on('change', function() {
            var kewarganegaraan = this.value;
            if (kewarganegaraan == 'WNA') {
                $('input[name="pasien_negara"]').val('');
            } else {
                $('input[name="pasien_negara"]').val('INDONESIA');
            }
        });

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

        $('.tanggalLahir').bind('keyup change', function(e) {
            hitungUmur();
        });

        hitungUmur();
        function hitungUmur() {

            var tglLahir = $('input[name="pasien_lahir_tanggal"]').val();
            var blnLahir = $('input[name="pasien_lahir_bulan"]').val();
            var thnLahir = $('input[name="pasien_lahir_tahun"]').val();

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