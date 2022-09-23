<?php echo messages(); ?>
<div class="card">
    <div class="card-header header-elements-inline">
        <h5>SURAT PENGANTAR PASIEN RAWAT INAP</h5>
        <div class="list-icons">
        </div>
    </div>
    <div class="card-body">
        <table>
            <tbody>
                <tr>
                    <td style="width:120px;">Nomor RM</td>
                    <td> :  <?php echo $pendaftaranRWI->no_mr; ?></td>
                </tr>
                <tr>
                    <td>Nama</td>
                    <td> :  <?php echo $pendaftaranRWI->nama; ?></td>
                </tr>
                <tr>
                    <td>Umur</td>
                    <td> :  <?php echo $pendaftaranRWI->umur_tahun; ?></td>
                </tr>
                <tr>
                    <td>Jenis Kelamin</td>
                    <td> :  <?php echo $pasien->jenis_kelamin; ?></td>
                </tr>
                <tr>
                    <td>Masuk Melalui</td>
                    <td> :  <?php echo $pendaftaranRWI->poli_nama_asal; ?></td>
                </tr>
                <tr>
                    <td>Diagnosis</td>
                    <td> :  <?php //echo $pendaftaranRWI->jenis_kelamin; ?></td>
                </tr>
                <tr>
                    <td>Jenis Pasien</td>
                    <td> :  <?php //echo $pendaftaranRWI->jenis_kelamin; ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div><!--end .row -->
<div id="load-dialog"></div>
<script>
    $(document).ready(function() {


    });
</script>

