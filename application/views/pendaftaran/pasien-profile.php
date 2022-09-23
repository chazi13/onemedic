<?php echo messages(); ?>
<!-- Inner container -->
<div class="d-md-flex align-items-md-start">

    <!-- Left sidebar component -->
    <div class="sidebar sidebar-light bg-transparent sidebar-component sidebar-component-left wmin-300 border-0 shadow-0 sidebar-expand-md">

        <!-- Sidebar content -->
        <div class="sidebar-content">

            <!-- Navigation -->
            <div class="card">
                <div class="card-body bg-indigo-400 text-center card-img-top" style="background-image: url(<?php echo base_url('assets/img/backgrounds/panel_bg.png')?>); background-size: contain;">
                    <div class="card-img-actions d-inline-block mb-3">
                        <img class="img-fluid rounded-circle" src="<?php echo base_url('assets/img/placeholders/placeholder.jpg')?>" width="170" height="170" alt="">
                        <div class="card-img-actions-overlay rounded-circle">
                            <a href="#" class="btn btn-outline bg-white text-white border-white border-2 btn-icon rounded-round">
                                <i class="icon-plus3"></i>
                            </a>
                        </div>
                    </div>

                    <h6 class="font-weight-semibold mb-0"><?php echo $pasien->nama; ?></h6>
                </div>

                <div class="card-body p-0">
                    <ul class="nav nav-sidebar mb-2">
                        <li class="nav-item-header">Navigation</li>
                        <li class="nav-item">
                            <a href="#profile" class="nav-link active" data-toggle="tab">
                                <i class="icon-user"></i>
                                    My profile
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#his_kunjungan" class="nav-link" data-toggle="tab">
                                <i class="icon-history"></i>
                                History Kunjungan
                            </a>
                        </li>
                        <li class="nav-item text-center">
                            <a href="<?php echo site_url('pendaftaran/home/index/'.$pasien->no_mr) ?>" class="btn btn-outline-primary">
                                Daftar
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- /navigation -->

        </div>
        <!-- /sidebar content -->

    </div>
    <!-- /left sidebar component -->


    <!-- Right content -->
    <div class="tab-content w-100 overflow-auto">
        <div class="tab-pane fade active show" id="profile">

            <div class="card">
                <div class="card-header header-elements-sm-inline">
                    <h6 class="card-title">My Profile</h6>
                </div>

                <div class="card-body">
                    <form method="post" action="" >
                    <?php echo $form->fields() ?>
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                    </form>
                </div>
            </div>
            
        </div>

        <div class="tab-pane fade" id="his_kunjungan">
            <div class="card">
                <div class="card-header header-elements-inline">
                    <h5 class="card-title">History Kunjungan</h5>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
						<table class="table table-bordered" style="width:100%">
							<thead>
								<tr>
									<th style="width:20;">#</th>
									<th>Tgl. Kunjungan</th>
									<th>Poliklinik</th>
									<th>Dokter</th>
								</tr>
							</thead>
							<tbody>
                                <?php
                                if($history){
                                    $i = 0;
                                    foreach($history as $his){
                                        $i++;
                                ?>
								<tr>
									<td><?php echo $i; ?></td>
									<td><?php echo $his->created; ?></td>
									<td><?php echo $his->poli_nama; ?></td>
									<td><?php echo $his->dokter_nama; ?></td>
								</tr>
                                <?php
                                    }
                                }
                                ?>
							</tbody>
						</table>
					</div>
                </div>
            </div>
        </div>

    </div>
    <!-- /right content -->

</div>
<!-- /inner container -->
