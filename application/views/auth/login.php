<!-- Login form -->
<?php echo messages() ?>
<form class="login-form" method="post" action="<?php echo site_url($controller_uri); ?>">
	<div class="card mb-0">
		<div class="card-body">
			<div class="text-center mb-3">
				<i class="icon-reading icon-2x text-slate-300 border-slate-300 border-3 rounded-round p-3 mb-3 mt-1"></i>
				<h5 class="mb-0"><?php echo lang('login') ?></h5>
				<span class="d-block text-muted">Silahkan masukan email beserta password</span>
			</div>

			<div class="form-group form-group-feedback form-group-feedback-left">
				<input type="text" name="email" class="form-control" placeholder="<?php echo lang('email') ?>" autocomplete="off" value="<?php echo (isset($email) ? $email : '') ?>" >
				<div class="form-control-feedback">
					<i class="icon-mail5 text-muted"></i>
				</div>
			</div>

			<div class="form-group form-group-feedback form-group-feedback-left">
				<input class="form-control" type="password" placeholder="<?php echo lang('password') ?>" name="password" autocomplete="current-password">
				<div class="form-control-feedback">
					<i class="icon-lock2 text-muted"></i>
				</div>
			</div>

			<div class="form-group">
				<button type="submit" class="btn btn-primary btn-block"><?php echo lang('sign_in') ?> <i class="icon-circle-right2 ml-2"></i></button>
			</div>

			<!-- <div class="text-center">
				<a href="login_password_recover.html">Forgot password?</a>
			</div> -->
		</div>
	</div>
</form>
<!-- /login form -->