<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title><?php echo $template['title']?> | Onemedic</title>

	<!-- Global stylesheets <?php echo base_url('')?> -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url('assets/css/icons/icomoon/styles.min.css')?>" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url('assets/css/icons/samcome/wfmi-style.css')?>" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url('assets/css/bootstrap.min.css')?>" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url('assets/css/bootstrap_limitless.min.css')?>" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url('assets/css/layout.min.css')?>" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url('assets/css/components.min.css')?>" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url('assets/css/colors.min.css')?>" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

	<?php echo $template['css']; ?>

	<!-- Core JS files -->
	<script src="<?php echo base_url('assets/js')?>/main/jquery.min.js"></script>
	<script src="<?php echo base_url('assets/js')?>/main/bootstrap.bundle.min.js"></script>
	<script src="<?php echo base_url('assets/js')?>/plugins/loaders/blockui.min.js"></script>
	<script src="<?php echo base_url('assets/js')?>/plugins/ui/slinky.min.js"></script>
	<!-- /core JS files -->

	<!-- Theme JS files -->
	<script src="<?php echo base_url('assets/js')?>/plugins/visualization/d3/d3.min.js"></script>
	<script src="<?php echo base_url('assets/js')?>/plugins/visualization/d3/d3_tooltip.js"></script>
	<script src="<?php echo base_url('assets/js')?>/plugins/forms/styling/switchery.min.js"></script>
	<script src="<?php echo base_url('assets/js')?>/plugins/forms/selects/bootstrap_multiselect.js"></script>
	<script src="<?php echo base_url('assets/js')?>/plugins/ui/moment/moment.min.js"></script>
	<script src="<?php echo base_url('assets/js')?>/plugins/pickers/daterangepicker.js"></script>

	<?php echo $template['js_header']; ?>

	<script src="<?php echo base_url('assets/js')?>/app.js"></script>
	<!-- /theme JS files -->
	<style>
	.medical-1x	{font-size: 1em;}
	.medical-2x	{font-size: 2em;}
	.medical-3x	{font-size: 3em;}	
	.medical-4x	{font-size: 4em;}	
	.medical-5x	{font-size: 5em;}	
	.medical-6x	{font-size: 6em;}	
	.medical-7x	{font-size: 7em;}	
	.medical-8x	{font-size: 8em;}	
	.medical-9x	{font-size: 9em;}
	.medical-10x {font-size: 10em;};
	</style>
</head>

<body>

	<!-- Main navbar -->
	<div class="navbar navbar-expand-md navbar-dark">
		<div class="navbar-brand">
			<a href="<?php echo site_url(); ?>" class="d-inline-block">
				<img src="<?php echo base_url('assets')?>/img/logo.png" alt="">
			</a>
		</div>

		<div class="d-md-none">
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-mobile">
				<i class="icon-tree5"></i>
			</button>
			<button class="navbar-toggler sidebar-mobile-main-toggle" type="button">
				<i class="icon-paragraph-justify3"></i>
			</button>
		</div>

		<div class="collapse navbar-collapse" id="navbar-mobile">
			<ul class="navbar-nav">
				<li class="nav-item">
					<a href="#" class="navbar-nav-link sidebar-control sidebar-main-toggle d-none d-md-block">
						<i class="icon-paragraph-justify3"></i>
					</a>
				</li>
			</ul> 

			<span class="badge bg-success ml-md-3 mr-md-auto">Online</span>

			<ul class="navbar-nav">
				<li class="nav-item dropdown">
					<a href="#" class="navbar-nav-link dropdown-toggle caret-0" data-toggle="dropdown">
						<i class="icon-people"></i>
						<span class="d-md-none ml-2">Users</span>
					</a>
					
					<div class="dropdown-menu dropdown-menu-right dropdown-content wmin-md-300">
						<div class="dropdown-content-header">
							<span class="font-weight-semibold">Users online</span>
							<a href="#" class="text-default"><i class="icon-search4 font-size-base"></i></a>
						</div>

						<div class="dropdown-content-body dropdown-scrollable">
							<ul class="media-list">
								<li class="media">
									<div class="mr-3">
										<img src="<?php echo base_url('assets')?>/img/placeholders/placeholder.jpg" width="36" height="36" class="rounded-circle" alt="">
									</div>
									<div class="media-body">
										<a href="#" class="media-title font-weight-semibold">Jordana Ansley</a>
										<span class="d-block text-muted font-size-sm">Lead web developer</span>
									</div>
									<div class="ml-3 align-self-center"><span class="badge badge-mark border-success"></span></div>
								</li>

								<li class="media">
									<div class="mr-3">
										<img src="<?php echo base_url('assets')?>/img/placeholders/placeholder.jpg" width="36" height="36" class="rounded-circle" alt="">
									</div>
									<div class="media-body">
										<a href="#" class="media-title font-weight-semibold">Will Brason</a>
										<span class="d-block text-muted font-size-sm">Marketing manager</span>
									</div>
									<div class="ml-3 align-self-center"><span class="badge badge-mark border-danger"></span></div>
								</li>

								<li class="media">
									<div class="mr-3">
										<img src="<?php echo base_url('assets')?>/img/placeholders/placeholder.jpg" width="36" height="36" class="rounded-circle" alt="">
									</div>
									<div class="media-body">
										<a href="#" class="media-title font-weight-semibold">Hanna Walden</a>
										<span class="d-block text-muted font-size-sm">Project manager</span>
									</div>
									<div class="ml-3 align-self-center"><span class="badge badge-mark border-success"></span></div>
								</li>

								<li class="media">
									<div class="mr-3">
										<img src="<?php echo base_url('assets')?>/img/placeholders/placeholder.jpg" width="36" height="36" class="rounded-circle" alt="">
									</div>
									<div class="media-body">
										<a href="#" class="media-title font-weight-semibold">Dori Laperriere</a>
										<span class="d-block text-muted font-size-sm">Business developer</span>
									</div>
									<div class="ml-3 align-self-center"><span class="badge badge-mark border-warning-300"></span></div>
								</li>

								<li class="media">
									<div class="mr-3">
										<img src="<?php echo base_url('assets')?>/img/placeholders/placeholder.jpg" width="36" height="36" class="rounded-circle" alt="">
									</div>
									<div class="media-body">
										<a href="#" class="media-title font-weight-semibold">Vanessa Aurelius</a>
										<span class="d-block text-muted font-size-sm">UX expert</span>
									</div>
									<div class="ml-3 align-self-center"><span class="badge badge-mark border-grey-400"></span></div>
								</li>
							</ul>
						</div>

					</div>
				</li>

				<li class="nav-item dropdown">
					<a href="#" class="navbar-nav-link dropdown-toggle caret-0" data-toggle="dropdown">
						<i class="icon-bubbles4"></i>
						<span class="d-md-none ml-2">Messages</span>
						<span class="badge badge-pill bg-warning-400 ml-auto ml-md-0">2</span>
					</a>
					
					<div class="dropdown-menu dropdown-menu-right dropdown-content wmin-md-350">
						<div class="dropdown-content-header">
							<span class="font-weight-semibold">Messages</span>
							<a href="#" class="text-default"><i class="icon-compose"></i></a>
						</div>

						<div class="dropdown-content-body dropdown-scrollable">
							<ul class="media-list">
								<li class="media">
									<div class="mr-3 position-relative">
										<img src="<?php echo base_url('assets')?>/img/placeholders/placeholder.jpg" width="36" height="36" class="rounded-circle" alt="">
									</div>

									<div class="media-body">
										<div class="media-title">
											<a href="#">
												<span class="font-weight-semibold">James Alexander</span>
												<span class="text-muted float-right font-size-sm">04:58</span>
											</a>
										</div>

										<span class="text-muted">who knows, maybe that would be the best thing for me...</span>
									</div>
								</li>

								<li class="media">
									<div class="mr-3 position-relative">
										<img src="<?php echo base_url('assets')?>/img/placeholders/placeholder.jpg" width="36" height="36" class="rounded-circle" alt="">
									</div>

									<div class="media-body">
										<div class="media-title">
											<a href="#">
												<span class="font-weight-semibold">Margo Baker</span>
												<span class="text-muted float-right font-size-sm">12:16</span>
											</a>
										</div>

										<span class="text-muted">That was something he was unable to do because...</span>
									</div>
								</li>

								<li class="media">
									<div class="mr-3">
										<img src="<?php echo base_url('assets')?>/img/placeholders/placeholder.jpg" width="36" height="36" class="rounded-circle" alt="">
									</div>
									<div class="media-body">
										<div class="media-title">
											<a href="#">
												<span class="font-weight-semibold">Jeremy Victorino</span>
												<span class="text-muted float-right font-size-sm">22:48</span>
											</a>
										</div>

										<span class="text-muted">But that would be extremely strained and suspicious...</span>
									</div>
								</li>

								<li class="media">
									<div class="mr-3">
										<img src="<?php echo base_url('assets')?>/img/placeholders/placeholder.jpg" width="36" height="36" class="rounded-circle" alt="">
									</div>
									<div class="media-body">
										<div class="media-title">
											<a href="#">
												<span class="font-weight-semibold">Beatrix Diaz</span>
												<span class="text-muted float-right font-size-sm">Tue</span>
											</a>
										</div>

										<span class="text-muted">What a strenuous career it is that I've chosen...</span>
									</div>
								</li>

								<li class="media">
									<div class="mr-3">
										<img src="<?php echo base_url('assets')?>/img/placeholders/placeholder.jpg" width="36" height="36" class="rounded-circle" alt="">
									</div>
									<div class="media-body">
										<div class="media-title">
											<a href="#">
												<span class="font-weight-semibold">Richard Vango</span>
												<span class="text-muted float-right font-size-sm">Mon</span>
											</a>
										</div>
										
										<span class="text-muted">Other travelling salesmen live a life of luxury...</span>
									</div>
								</li>
							</ul>
						</div>

						<div class="dropdown-content-footer justify-content-center p-0">
							<a href="#" class="bg-light text-grey w-100 py-2" data-popup="tooltip" title="Load more"><i class="icon-menu7 d-block top-0"></i></a>
						</div>
					</div>
				</li>

				<li class="nav-item dropdown dropdown-user">
					<a href="#" class="navbar-nav-link d-flex align-items-center dropdown-toggle" data-toggle="dropdown">
						<?php if (!empty($picture)): ?>
						<img src="<?php echo $picture ?>" class="rounded-circle mr-2" height="34" alt="">
						<?php else: ?>
						<img src="<?php echo image_url('user.jpg') ?>" class="rounded-circle mr-2" height="34" alt="">
						<?php endif; ?>
						<span><?php echo $this->session->userdata('full_name') ?></span>
					</a>

					<div class="dropdown-menu dropdown-menu-right">
						<a href="#" class="dropdown-item"><i class="icon-user-plus"></i> My profile</a>
						<a href="#" class="dropdown-item"><i class="icon-comment-discussion"></i> Messages <span class="badge badge-pill bg-blue ml-auto">58</span></a>
						<div class="dropdown-divider"></div>
						<a href="#" class="dropdown-item"><i class="icon-cog5"></i> Account settings</a>
						<a href="<?php echo site_url('auth/logout')?>" class="dropdown-item"><i class="icon-switch2"></i> Logout</a>
					</div>
				</li>
			</ul>
		</div>
	</div>
	<!-- /main navbar -->


	<!-- Page content -->
	<div class="page-content">

		<!-- Main sidebar -->
		<div class="sidebar sidebar-dark sidebar-main sidebar-expand-md">

			<!-- Sidebar mobile toggler -->
			<div class="sidebar-mobile-toggler text-center">
				<a href="#" class="sidebar-mobile-main-toggle">
					<i class="icon-arrow-left8"></i>
				</a>
				Navigation
				<a href="#" class="sidebar-mobile-expand">
					<i class="icon-screen-full"></i>
					<i class="icon-screen-normal"></i>
				</a>
			</div>
			<!-- /sidebar mobile toggler -->


			<!-- Sidebar content -->
			<div class="sidebar-content">

				<!-- User menu -->
				<div class="sidebar-user">
					<div class="card-body">
						<div class="media">
							<div class="mr-3">
								<a href="#"><img src="<?php echo base_url('assets')?>/img/placeholders/placeholder.jpg" width="38" height="38" class="rounded-circle" alt=""></a>
							</div>

							<div class="media-body">
								<div class="media-title font-weight-semibold"><?php echo $this->session->userdata('full_name') ?></div>
								<div class="font-size-xs opacity-50">
									<i class="icon-pin font-size-sm"></i> &nbsp;RS. Satu Medika Indonesia
								</div>
							</div>

						</div>
					</div>
				</div>
				<!-- /user menu -->


				<!-- Main navigation -->
				<div class="card card-sidebar-mobile">
					<ul class="nav nav-sidebar" data-nav-type="accordion">

						<?php
							$this->load->config('navigation');
							$navigation = $this->config->item('navigation');

							function isMenuActive($url, $active_uri)
							{
								$is_active = (substr(uri_string(), 0, strlen($url)) == $url);
								if (!$is_active && !empty($active_uri)) {
									$is_active = (substr($active_uri, 0, strlen($url)) == $url);
								}
								return $is_active;
							}

							function traverseMenu(&$menus, $acl, $active_uri)
							{
								$active = FALSE;
								foreach ($menus as $key => $menu)
								{
									if (isset($menu['uri']) && !$acl->is_allowed($menu['uri']))
									{
										unset($menus[$key]);
										continue;
									}
									$children_active = FALSE;
									if (isset($menu['children']))
									{
										$children_active = traverseMenu($menu['children'], $acl, $active_uri);
										if (empty($menu['children']))
										{
											unset($menus[$key]);
											continue;
										}
										else
											$menus[$key]['children'] = $menu['children'];
									}
									if ($children_active || (isset($menu['uri']) && isMenuActive($menu['uri'], $active_uri)))
									{
										$menus[$key]['active'] = TRUE;
										$active = TRUE;
									}
								}
								return $active;
							}

							function createMenuL1($navs)
							{
								foreach($navs as $nav)
								{
									$has_children = isset($nav['children']) && is_array($nav['children']); 
									?>
									<?php if (!$has_children): ?>
									<li class="m-menu__item <?php echo (isset($nav['active']) && $nav['active'] ? 'm-menu__item--active ' : '') ?>" aria-haspopup="true">
										<a href="<?php echo (isset($nav['uri']) ? site_url($nav['uri']) : 'javascript:;') ?>" class="m-menu__link ">
											<?php if (isset($nav['icon'])): ?>
											<i class="m-menu__link-icon  <?php echo $nav['icon'] ?>"></i>
											<?php endif; ?>
											<span class="m-menu__link-title">
												<span class="m-menu__link-wrap"> 
													<span class="m-menu__link-text"><?php echo $nav['title'] ?>XXXX</span>
													</span>
												</span>
											</span>
										</a>
									</li>
									<?php else: ?>
									<li class="nav-item-header"><div class="text-uppercase font-size-xs line-height-xs"><?php echo $nav['title'] ?></div> <i class="icon-menu" title="<?php echo $nav['title'] ?>"></i></li>
									<?php createMenuL2($nav['children']); ?>
									<?php
									endif;
								}
							}

							function createMenuL2 ($navs)
							{
								foreach($navs as $nav)
								{
									$has_children = isset($nav['children']) && is_array($nav['children']); 
									if (!$has_children) {
										?>
										<li class="nav-item">
											<a href="<?php echo (isset($nav['uri']) ? site_url($nav['uri']) : 'javascript:;') ?>" class="nav-link <?php echo (isset($nav['active']) && $nav['active'] ? 'active ' : '') ?>">
												<?php if (isset($nav['icon'])): ?>
												<i class="<?php echo $nav['icon'] ?>"></i>
												<?php endif; ?>
												<span><?php echo $nav['title'] ?></span>
											</a>
										</li>
										<?php
									} else {
										?>
										<li class="nav-item nav-item-submenu">
											<a href="<?php echo (isset($nav['uri']) ? site_url($nav['uri']) : 'javascript:;') ?>" class="nav-link">
												<?php if (isset($nav['icon'])): ?>
												<i class="<?php echo $nav['icon'] ?>"></i>
												<?php endif; ?>
												<span><?php echo $nav['title'] ?></span></a>

											<ul class="nav nav-group-sub" data-submenu-title="<?php echo $nav['title'] ?>">
												<?php createMenuL3($nav['children']); ?>
											</ul>
										</li>
										<?php
									}
								}
							}

							function createMenuL3 ($navs)
							{
								foreach($navs as $nav)
								{
									$has_children = isset($nav['children']) && is_array($nav['children']); 
									if (!$has_children) {
										?>
										<li class="nav-item"><a href="<?php echo (isset($nav['uri']) ? site_url($nav['uri']) : 'javascript:;') ?>" class="nav-link <?php echo (isset($nav['active']) && $nav['active'] ? 'active ' : '') ?>"><?php echo $nav['title'] ?></a></li>

										<?php
									}
								}
							}

							traverseMenu($navigation, $this->acl, (isset($active_uri) ? $active_uri : ''));
							createMenuL1 ($navigation);
							?>
					</ul> 
				</div>
				<!-- /main navigation -->

			</div>
			<!-- /sidebar content -->
			
		</div>
		<!-- /main sidebar -->


		<!-- Main content -->
		<div class="content-wrapper">

			<!-- Page header -->
			<div class="page-header page-header-light">
				<div class="page-header-content header-elements-md-inline">
					<div class="page-title d-flex">
						<h4><i class="icon-arrow-left52 mr-2"></i> <?php echo $template['title']; ?></h4>
						<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
					</div>

					<div class="header-elements d-none">
						<div class="d-flex justify-content-center">
							<a href="#" class="btn btn-link btn-float text-default"><i class="icon-price-tags text-primary"></i><span>Pasien Lama</span></a>
							<a href="#" class="btn btn-link btn-float text-default"><i class="icon-price-tags2 text-primary"></i> <span>Pasien Baru</span></a>
							<a href="#" class="btn btn-link btn-float text-default"><i class="icon-calendar5 text-primary"></i> <span>Jadwal Dokter</span></a>
						</div>
					</div>
				</div>

			</div>
			<!-- /page header -->


			<!-- Content area -->
			<div class="content">

				<?php echo $template['content']?>

			</div>
			<!-- /content area -->


			<!-- Footer -->
			<div class="navbar navbar-expand-lg navbar-light">
				<div class="text-center d-lg-none w-100">
					<button type="button" class="navbar-toggler dropdown-toggle" data-toggle="collapse" data-target="#navbar-footer">
						<i class="icon-unfold mr-2"></i>
						Footer
					</button>
				</div>

				<div class="navbar-collapse collapse" id="navbar-footer">
					<span class="navbar-text">
						&copy; 2004 - <?php echo date('Y') ?>. <a href="https://onemedic.co.id">onemedic.co.id</a>
					</span>

					<ul class="navbar-nav ml-lg-auto">
						<li class="nav-item"><a href="#" class="navbar-nav-link" target="_blank"><i class="icon-lifebuoy mr-2"></i> Support</a></li>
						<li class="nav-item"><a href="#" class="navbar-nav-link" target="_blank"><i class="icon-file-text2 mr-2"></i> Docs</a></li>
					</ul>
				</div>
			</div>
			<!-- /footer -->

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->

	<?php echo $template['js_footer']; ?>
</body>
</html>
