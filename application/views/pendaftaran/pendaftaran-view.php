<?php echo messages(); ?>
<div class="card">
    <div class="card-header header-elements-inline">
        <h5><?php echo $template['title']?></h5>
        <div class="list-icons">
            <button type="button" class="btn btn-sm bg-teal" data-button="dialog-kartu" href="<?php echo site_url('pendaftaran/info/kartu_pasien/'.$pasien->id)?>" ><i class="fa fa-print fa-fw"></i>Kartu Pasien</button>
            <button type="button" class="btn btn-sm bg-pink" data-button="dialog-form-pemeriksaan" href="<?php echo site_url('pendaftaran/info/form_pemeriksaan/'.$pendaftaran->id)?>"><i class="fa fa-print fa-fw"></i>Form Pemeriksaan</button>
        </div>
    </div>
    <div class="card-body">
        <form method="post">
            <div class="row">
                <div class="col-md-6">
                    <fieldset>
                        <legend class="text-uppercase font-size-sm font-weight-bold">Data Pasien</legend>
                        <div class=" row">
                            <label class="col-md-4 control-label">No. MR</label>
                            <div class="col-md-8 ">
                                <p class="form-control-static">: <?php echo $pendaftaran->no_mr; ?></p>
                            </div>
                        </div>
                        <div class=" row">
                            <label class="col-md-4 control-label">Nama Lengkap</label>
                            <div class="col-md-8 ">
                                <p class="form-control-static">: <?php echo $pendaftaran->nama; ?></p>
                            </div>
                        </div>
                        <div class=" row">
                            <label class="col-md-4 control-label">Jenis Kelamin</label>
                            <div class="col-md-8 ">
                                <p class="form-control-static">: <?php echo $pendaftaran->jenis_kelamin; ?></p>
                            </div>
                        </div>
                        <div class=" row">
                            <label class="col-md-4 control-label">Tempat, Tgl. lahir</label>
                            <div class="col-md-8 ">
                                <p class="form-control-static">: <?php echo $pendaftaran->tempat_lahir .', '.$pendaftaran->tanggal_lahir; ?></p>
                            </div>
                        </div>
                        <div class=" row">
                            <label class="col-md-4 control-label">Umur (tahun)</label>
                            <div class="col-md-8 ">
                                <p class="form-control-static">: <?php echo $pendaftaran->umur_tahun; ?> </p>
                            </div>
                        </div>
                        <div class=" row">
                            <label class="col-md-4 control-label">Agama</label>
                            <div class="col-md-8 ">
                                <p class="form-control-static">: <?php echo $pendaftaran->agama; ?></p>
                            </div>
                        </div>
                        <div class=" row">
                            <label class="col-md-4 control-label">No. Identitas</label>
                            <div class="col-md-8 ">
                                <p class="form-control-static">: <?php echo $pendaftaran->no_identitas; ?></p>
                            </div>
                        </div>
                        <div class=" row">
                            <label class="col-md-4 control-label">Alamat</label>
                            <div class="col-md-8 ">
                                <p class="form-control-static">: <?php echo $pendaftaran->alamat; ?></p>
                            </div>
                        </div>
                        <div class=" row">
                            <label class="col-md-4 control-label">Kota/Daerah</label>
                            <div class="col-md-8 ">
                                <p class="form-control-static">: <?php echo $pendaftaran->alamat_daerah; ?></p>
                            </div>
                        </div>
                        <div class=" row">
                            <label class="col-md-4 control-label">Provinsi</label>
                            <div class="col-md-8 ">
                                <p class="form-control-static">: <?php echo $pendaftaran->provinsi_nama; ?></p>
                            </div>
                        </div>
                        <div class=" row">
                            <label class="col-md-4 control-label">Kabupaten/Kota</label>
                            <div class="col-md-8 ">
                                <p class="form-control-static">: <?php echo $pendaftaran->kabupaten_nama; ?></p>
                            </div>
                        </div>
                        <div class=" row">
                            <label class="col-md-4 control-label">Kecamatan</label>
                            <div class="col-md-8 ">
                                <p class="form-control-static">: <?php echo $pendaftaran->kecamatan_nama; ?></p>
                            </div>
                        </div>
                        <div class=" row">
                            <label class="col-md-4 control-label">Kelurahan</label>
                            <div class="col-md-8 ">
                                <p class="form-control-static">: <?php echo $pendaftaran->kelurahan_nama; ?></p>
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="col-md-6">
                    <fieldset>
                        <legend class="text-uppercase font-size-sm font-weight-bold">Data Pendaftaran</legend>
                        <div class=" row">
                            <label class="col-md-4 control-label">No. Antrian</label>
                            <div class="col-md-8 ">
                                <p class="form-control-static">: <?php echo $pendaftaran->no_antrian; ?></p>
                            </div>
                        </div>
                        <div class=" row">
                            <label class="col-md-4 control-label">No. Registrasi</label>
                            <div class="col-md-8 ">
                                <p class="form-control-static">: <?php echo $pendaftaran->no_reg; ?></p>
                            </div>
                        </div>
                        <div class=" row">
                            <label class="col-md-4 control-label">Tipe/Jenis Pasien</label>
                            <div class="col-md-8 ">
                                <p class="form-control-static">: <?php echo $pendaftaran->tipe_pasien_nama; ?></p>
                            </div>
                        </div>
                        <div class=" row">
                            <label  class="col-md-4 control-label">Poliklinik</label>
                            <div class="col-md-8 ">
                                <p class="form-control-static">: <?php echo $pendaftaran->poli_nama; ?></p>
                            </div>
                        </div>
                        <div class=" row">
                            <label  class="col-md-4 control-label">Dokter</label>
                            <div class="col-md-8 ">
                                <p class="form-control-static">: <?php echo $pendaftaran->dokter_nama; ?></p>
                            </div>
                        </div>
                        <div class=" row">
                            <label  class="col-md-4 control-label">Dokter DPJP</label>
                            <div class="col-md-8 ">
                                <p class="form-control-static">: <?php echo $pendaftaran->dokter_dpjp_nama; ?></p>
                            </div>
                        </div>
                        <div class=" row">
                            <label  class="col-md-4 control-label">Rujukan Dari</label>
                            <div class="col-md-8 ">
                                <p class="form-control-static">: <?php echo $pendaftaran->rujukan_dari . ', ' . $pendaftaran->rujukan_nama; ?></p>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
        </form>
    </div>
</div><!--end .row -->
<div id="load-dialog"></div>
<script>
    $(document).ready(function() {

        $('[data-button=dialog-kartu], [data-button=dialog-form-pemeriksaan]').on("click", function(e) {
            e.preventDefault();
            var url = $(this).attr('href');
            $('#load-dialog').load(url);
        });

    });
</script>

