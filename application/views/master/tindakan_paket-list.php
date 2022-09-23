
<!-- BEGIN CONTENT-->
<?php echo messages(); ?>
<div class="card">
    <div class="card-header header-elements-inline">
        <h5 class="card-title">DAFTAR TINDAKAN PAKET</h5>
        <div class="header-elements">
            <a href="<?php echo site_url('master/tindakan_paket/add') ?>"  class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Tambah</a>
        </div>
    </div>
    <div class="card-body">            
        <div class="table-responsive">
            <table class="table no-margin" id="dynamic-table-ajax-source">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Nama Paket</th>
                        <th>Tarif / Harga</th>
                        <th style="width:80px;">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="7"></td>
                    </tr>
                </tbody>
            </table>
        </div><!--end .table-responsive -->
    </div>
</div>
<!-- END CONTENT -->
<?php $this->load->view('delete-modal'); ?>
<script type="text/javascript">
	$(document).ready(function() {
        var dataTables = $("#dynamic-table-ajax-source").DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "<?php echo site_url('master/tindakan_paket/datatables_sourcedata') ?>",
                "type": "POST"
            },
            "columns": [
                {"data": "id", "searchable": false, "bVisible": false},
                {"data": "nama"},
                {"data": "tarif"},
                {"data": "link"}
            ]

        });

    });
</script>