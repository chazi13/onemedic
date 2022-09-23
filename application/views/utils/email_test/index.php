<?php echo messages(); ?>
<div class="row">
	<div class="col-xl-5">
		<div class="m-portlet m-portlet--mobile m-portlet--rounded m-portlet--brand m-portlet--head-solid-bg">
			<div class="m-portlet__head">
				<div class="m-portlet__head-caption">
					<div class="m-portlet__head-title">
						<span class="m-portlet__head-icon">
							<i class="fa fa-envelope"></i>
						</span>
						<h3 class="m-portlet__head-text">
                            Email Test
						</h3>
					</div>
				</div>
			</div>
			<?php echo form_open(site_url('utils/email_test/index'), array('class' => 'm-form m-form--fit m-form--label-align-right', 'id' => 'email-test-form', 'name' => 'email-test-form')) ?>
			<div class="m-portlet__body">
				<div class="form-group m-form__group row">
					<label for="email" class="col-form-label col-md-4">Alamat Email</label>
					<div class="col-md-8">
						<input type="text" id="email" name="email" class="form-control" />
					</div>
				</div>
			</div>
			<div class="m-portlet__foot m-portlet__foot--fit">
				<div class="m-form__actions m-form__actions--solid">
					<button type="submit" class="btn btn-primary" name="run" value="Test Email">Test Email</button>
				</div>
			</div>
			<?php echo form_close() ?>
		</div>
	</div>
	<?php if (isset($message) && !empty($message)): ?>
	<div class="col-xl-7">
		<div class="m-portlet m-portlet--mobile m-portlet--rounded">
			<div class="m-portlet__head">
				<div class="m-portlet__head-caption">
					<div class="m-portlet__head-title">
						<h3 class="m-portlet__head-text">
                            Result
						</h3>
					</div>
				</div>
			</div>
			<div  class="m-portlet__body">
				<pre><?php echo $message ?></pre>
			</div>
		</div>
	</div>
	<?php endif; ?>
</div>
