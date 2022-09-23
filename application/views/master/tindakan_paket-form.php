<!-- BEGIN CONTENT-->
<?php echo messages(); ?>
<div class="card">
    <div class="card-header header-elements-inline">
        <h5 class="card-title">FORM TINDAKAN PAKET</h5>
        <div class="header-elements">
        </div>
    </div>
    <div class="card-body">            
        <div class="card-body">
            <form class="form-horizontal" novalidate="novalidate" method="post" action="">
                <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <?php echo $form->fields(); ?>   
                    </div>    
                </div>   
                <div class="row">
                    <div class="col-md-12"> 
                        <table class="table no-margin " id="table-tindakan">
                            <thead>
                                <tr>
                                    <th style="">Daftar Tindakan</th>
                                    <th style="width:40px;">Banyaknya</th>
                                    <th style="width:10px;">&nbsp;</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                            $iTindakan = 1;
                            if ($insertedTindakan) {
                                foreach ($insertedTindakan as $rowTindakan):
                                    ?>
                                    <tr>
                                        <td>
                                            <input type="hidden" name="tindakan_id[]" value="<?php echo $rowTindakan->tindakan_id ?>" />
                                            <input type="text" name="tindakan_nama[]" value="<?php echo $rowTindakan->tindakan_nama ?>" class="autocomplete_tindakan form-control"/>
                                        </td>
                                        <td>
                                            <input type="text" name="banyaknya[]" value="<?php echo $rowTindakan->banyaknya ?>" class="form-control text-right" />
                                        </td>
                                        <td class="text-center" >
                                            <a href="#" class=" text-danger" ><i class="fa fa-times"></i></a>
                                        </td>
                                    </tr>
                                    <?php
                                    $iTindakan++;

                                endforeach;
                            }
                                ?>
                                    
                                <?php 
                                for ($i = 0; $i <= 10; $i++) {
                                    ?>
                                    <tr>
                                        <td>
                                            <input type="hidden" name="tindakan_id[]"  value="0" class="tindakan_id" />
                                            <input type="text" name="tindakan_nama[]" value="" class="autocomplete_tindakan form-control"/>
                                        </td>
                                        <td>
                                            <input type="text" name="banyaknya[]" value="" class="form-control text-right"/>
                                        </td>
                                        <td class="text-center" >
                                            <a href="#" class=" text-danger" ><i class="icon-cross3"></i></a>
                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5"><a id="addRowTindakan" class="btn btn-sm btn-primary" >Tambah Baris</a> <br/> </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <?php
                        echo form_actions(array(
                            array(
                                'id' => 'save-button',
                                'type' => 'submit',
                                'value' => lang('save'),
                                'class' => 'btn btn-sm btn-success'
                            ),
                            array(
                                'id' => 'cancel-button',
                                'type' => 'submit',
                                'value' => lang('cancel'),
                                'class' => 'btn btn-sm btn-default'
                            )
                        ));
                        ?>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div><!--end .col -->

<script>
    $(function() {
        search_tindakan();
        del_row();
        function search_tindakan(){
            $(".autocomplete_tindakan").autocomplete({
                source: "<?php echo site_url('master/tindakan/autocomplete/'); ?>",
                minLength: 1,
                select: function(event, ui) {
                    var iSelected = $('.autocomplete_tindakan').index( this );
                    $(".tindakan_id:eq(" + iSelected + ")").val(ui.item.id);
                }
            });
        }

        del_row();
        $("#addRowTindakan").click(function() {
            $('#table-tindakan tbody').append('<tr>' +
                    '<td>' +
                    '<input type="hidden" name="tindakan_id[]" class="tindakan_id" value="" />' +
                    '<input type="text" name="tindakan_nama[] value="" class="autocomplete_tindakan form-control"/></td>' +
                    '</td>' +
                    '<td class="text-center"><a href="#" class=" text-danger" ><i class="fa fa-times"></i></a></td>' +
                    '</tr>');
            search_tindakan()
            $('.text-danger').click(function() {
                del_row();
            });
        });
        
        function del_row(){
            $('.text-danger').click(function(e) {
                var index = $( ".text-danger" ).index( this );
                $("#table-tindakan tbody tr:eq(" + index + ")").remove();
            });
        }
    });
</script>