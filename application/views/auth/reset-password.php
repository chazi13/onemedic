<div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-grid--tablet-and-mobile m-grid--hor-tablet-and-mobile m-login m-login--1 m-login--signin" id="m_login">
	<div class="m-grid__item m-grid__item--order-tablet-and-mobile-2 m-login__aside">
		<div class="m-stack m-stack--hor m-stack--desktop">
			<div class="m-stack__item m-stack__item--fluid">
				<div class="m-login__wrapper">
					<div class="m-login__logo">
						<a href="#">
							<!-- <div class="m-brand__logo-wrapper" style="color: #fff; font-size: 36px;"><?php echo $template['base_title'] ?></div> -->
							<img src="<?php echo image_url('logo-pmc.png') ?>" style="max-width: 200px;">
						</a>
					</div>
					<?php echo messages() ?>
					<div>
						<div class="m-login__head">
							<h3 class="m-login__title"><?php echo lang('reset_password') ?></h3>
						</div>
						<?php echo messages() ?>
						<?php if (!empty($token)): ?>
						<form class="m-login__form m-form" action="<?php echo site_url($controller_uri . 'confirm') ?>" method="post">
							<div class="form-group m-form__group">
								<input class="form-control m-input" type="password" placeholder="<?php echo lang('password') ?>" id="password" name="password" autocomplete="new-password">
							</div>
							<div class="form-group m-form__group">
								<input class="form-control m-input m-login__form-input--last" type="password" placeholder="<?php echo lang('confirm_password') ?>" name="rpassword" autocomplete="new-password">
							</div>
							<input type="hidden" name="token" value="<?php echo $token ?>" />
							<div class="m-login__form-action">
								<button id="m_login_signup_submit" class="btn btn-brand m-btn m-btn--pill m-btn--custom m-btn--air"><?php echo lang('reset_password') ?></button>
							</div>
						</form>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="m-grid__item m-grid__item--fluid m-grid m-grid--center m-grid--hor m-grid__item--order-tablet-and-mobile-1	m-login__content m-grid-item--center" style="background-image: url(<?php echo image_url('login-background.jpg') ?>)">
		<div class="m-grid__item">
			<h3 class="m-login__welcome"></h3>
			<p class="m-login__msg"></p>
		</div>
	</div>
</div>

<script>
//== Class Definition
var SnippetLogin = function() {

	var login = $('#m_login');

	var showErrorMsg = function(form, type, msg) {
		var alert = $('<div class="alert alert-' + type + ' alert-dismissible" role="alert">\
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>\
			<span></span>\
		</div>');

		form.find('.alert').remove();
		alert.prependTo(form);
		//alert.animateClass('fadeIn animated');
		mUtil.animateClass(alert[0], 'fadeIn animated');
		alert.find('span').html(msg);
	}

	var handleSignUpFormSubmit = function() {
		$('#m_login_signup_submit').click(function(e) {
			e.preventDefault();

			var btn = $(this);
			var form = $(this).closest('form');

			form.validate({
				rules: {
					password: {
						required: true
					},
					rpassword: {
						required: true,
                        equalTo: "#password"
					}
				},
				messages: {
					password: {
						required: "<?php echo lang('password_validate_required') ?>"
					},
					rpassword: {
						required: "<?php echo lang('confirm_password_validate_required') ?>",
                        equalTo: "<?php echo lang('confirm_password_validate_equalto') ?>"
					}
				}
			});

			if (!form.valid()) {
				return;
			}

			btn.addClass('m-loader m-loader--right m-loader--light').attr('disabled', true);

			form.submit();
		});
	}

	//== Public Functions
	return {
		// public functions
		init: function() {
			handleSignUpFormSubmit();
		}
	};
}();

//== Class Initialization
jQuery(document).ready(function() {
	SnippetLogin.init();
});
</script>