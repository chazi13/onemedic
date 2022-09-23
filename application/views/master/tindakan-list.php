<style>
.dd { position: relative; display: block; margin: 0; padding: 0; width: 450px; list-style: none; font-size: 13px; line-height: 20px; }

.dd-list { display: block; position: relative; margin: 0; padding: 0; list-style: none; }
.dd-list .dd-list { padding-left: 30px; }
.dd-collapsed .dd-list { display: none; }

.dd-item,
.dd-empty,
.dd-placeholder { display: block; position: relative; margin: 0; padding: 0; min-height: 20px; font-size: 13px; line-height: 20px; }

.dd-handle { display: block; height: 30px; margin: 5px 0; padding: 5px 10px; color: #333; text-decoration: none; font-weight: bold; border: 1px solid #ccc;
    background: none;
    background: -webkit-linear-gradient(top, none 0%, #eee 100%);
    background:    -moz-linear-gradient(top, none 0%, #eee 100%);
    background:         linear-gradient(top, none 0%, #eee 100%);
    -webkit-border-radius: 3px;
            border-radius: 3px;
    box-sizing: border-box; -moz-box-sizing: border-box;
}
.dd-handle:hover { color: #2ea8e5; background: #fff; }

.dd-item > button { display: block; position: relative; cursor: pointer; float: left; width: 25px; height: 20px; margin: 5px 0; padding: 0; text-indent: 100%; white-space: nowrap; overflow: hidden; border: 0; background: transparent; font-size: 12px; line-height: 1; text-align: center; font-weight: bold; }
.dd-item > button:before { content: '+'; display: block; position: absolute; width: 100%; text-align: center; text-indent: 0; }
.dd-item > button[data-action="collapse"]:before { content: '-'; }

.dd-placeholder,
.dd-empty { margin: 5px 0; padding: 0; min-height: 30px; background: #f2fbff; border: 1px dashed #b6bcbf; box-sizing: border-box; -moz-box-sizing: border-box; }
.dd-empty { border: 1px dashed #bbb; min-height: 100px; background-color: #e5e5e5;
    background-image: -webkit-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),
                      -webkit-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
    background-image:    -moz-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),
                         -moz-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
    background-image:         linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),
                              linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
    background-size: 60px 60px;
    background-position: 0 0, 30px 30px;
}

.dd-dragel { position: absolute; pointer-events: none; z-index: 9999; }
.dd-dragel > .dd-item .dd-handle { margin-top: 0; }
.dd-dragel .dd-handle {
    -webkit-box-shadow: 2px 4px 6px 0 rgba(0,0,0,.1);
            box-shadow: 2px 4px 6px 0 rgba(0,0,0,.1);
}
</style>
<!-- BEGIN CONTENT-->
<?php echo messages(); ?>
<div class="card">
    <div class="card-header header-elements-inline">
        <h5 class="card-title">DAFTAR LAYANAN / TINDAKAN</h5>
        <div class="header-elements">
            <a href="<?php echo site_url('master/tindakan/add') ?>"  class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Tambah</a>
        </div>
    </div>
    <div class="card-body">        
        <div class="card-body">

            <div class="d-md-flex">
                <ul class="nav nav-tabs nav-tabs-vertical flex-column mr-md-3 wmin-md-200 mb-md-0 border-bottom-0">
                    <?php
                    $i=0;
                    $isActive = '';
                    foreach ($rowsRoot as $rowRoot):
                        $i++;
                        ($i == 1) ? $isActive = 'active show' : $isActive = '';
                        echo '<li  class="nav-item"><a href="#t'.$i.'"  class="nav-link '.$isActive.' " data-toggle="tab" >'.$rowRoot->nama.'</a></li>';
                        
                    endforeach;
                    ?>
                    </li>
                </ul>

                <div class="tab-content">
                    <?php 
                    $i=0;
                    foreach ($rowsRoot as $rowRoot):
                        $i++;
                        ($i == 1) ? $isActive = 'active show' : $isActive = '';
                        $rowsChild = $this->db->query("SELECT kode, nama FROM mst_tindakan WHERE kode LIKE '".substr($rowRoot->kode,0,3)."%' AND SUBSTRING(kode, 7,9) = '000000000' AND kode != '".$rowRoot->kode."' AND status = 1 ORDER BY kode ASC")->result();
                        ?>
                        <div class="tab-pane <?php echo $isActive ?>" id="t<?php echo $i?>">
                            <div class="dd">
                                <ol class="dd-list">
                                    <?php foreach ($rowsChild as $rowChild): ?>
                                    <li class="dd-item" data-id="<?php echo substr($rowChild->kode,0,6)?>">
                                        <div id="<?php echo substr($rowChild->kode,0,6)?>" class="dd-handle"><?php echo $rowChild->kode.' - '.$rowChild->nama;?></div>
                                        <ol class="dd-list">
                                            
                                        </ol>
                                    </li>
                                    <?php endforeach;?>
                                </ol>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div id="treeTindakan" class=""></div>
        </div>
    </div>
</div>
<!-- END CONTENT -->
<?php $this->load->view('delete-modal'); ?>

<script type="text/javascript">
    $(document).ready(function() {
        $('.dd').nestable('destroy');
        $(".dd-item").click(function(e){
            var kode = $(this).attr('data-id');
            var rowLevel = 0;
            get_tindakan(rowLevel,kode);
        });

        function get_tindakan(rowLevel, parentKode) {
            $.ajax({
                url: '<?php echo site_url("master/tindakan/get_by_parent/") ?>' + parentKode,
                type: "GET",
                success: function(response) {
                        var listitems = '<ol class="dd-list">';
                        $.each(response, function(keyOpt, valueOpt) {
                            listitems += '<li class="dd-item" data-id="4"><div class="dd-handle">'+valueOpt+'</div></li>';
                        });
                        listitems += '</ol>';
                        $('#'+parentKode).after(listitems);
                        $('#nestable').nestable();
                },
                error: function() {
                }
            });
        }
        

    });
</script>