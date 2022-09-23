<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title><?php echo $template['title']?></title>
	<title><?php echo $template['metas']?></title>

	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url('assets/css/icons/icomoon/styles.min.css')?>" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url('assets/css/bootstrap.min.css')?>" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url('assets/css/bootstrap_limitless.min.css')?>" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url('assets/css/layout.min.css')?>" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url('assets/css/components.min.css')?>" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url('assets/css/colors.min.css')?>" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

	<!-- Core JS files -->
	<script src="<?php echo base_url('assets/js/main/jquery.min.js')?>"></script>
	<script src="<?php echo base_url('assets/js/main/bootstrap.bundle.min.js')?>"></script>
	<script src="<?php echo base_url('assets/js/plugins/loaders/blockui.min.js')?>"></script>
	<script src="<?php echo base_url('assets/js/plugins/ui/slinky.min.js')?>"></script>
	<script src="<?php echo base_url('assets/js/plugins/ui/ripple.min.js')?>"></script>
	<!-- /core JS files -->

	<script src="<?php echo base_url('assets/js/app.js')?>"></script>
	<!-- /theme JS files -->

</head>

<body>

	<!-- Page content -->
	<div class="page-content">

		<!-- Main content -->
		<div class="content-wrapper">

			<!-- Content area -->
			<div class="content d-flex justify-content-center align-items-center">

                <?php echo $template['content']; ?>

			</div>
			<!-- /content area -->



		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->

</body>
</html>
