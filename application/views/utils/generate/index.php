<?php echo messages(); ?>
<div class="row">
	<div class="col-xl-5">
		<div class="m-portlet m-portlet--mobile m-portlet--rounded m-portlet--brand m-portlet--head-solid-bg">
			<div class="m-portlet__head">
				<div class="m-portlet__head-caption">
					<div class="m-portlet__head-title">
						<span class="m-portlet__head-icon">
							<i class="fa fa-shipping-fast"></i>
						</span>
						<h3 class="m-portlet__head-text">
                            Generate Delivery Orders
						</h3>
					</div>
				</div>
			</div>
			<?php echo form_open(site_url('utils/generate/delivery_order'), array('class' => 'm-form m-form--fit m-form--label-align-right', 'id' => 'generate-do-form', 'name' => 'generate-do-form')) ?>
			<div class="m-portlet__body">
				<div class="form-group m-form__group row">
					<label for="client_uid" class="col-form-label col-md-4">Client UID <span class="required">*</span></label>
					<div class="col-md-8">
						<input type="text" id="client_uid" name="client_uid" class="form-control" />
					</div>
				</div>
				<div class="form-group m-form__group row">
					<label for="order_date" class="col-form-label col-md-4">Order Date <span class="required">*</span></label>
					<div class="col-lg-4 col-md-8 col-sm-12">
						<input type="text" class="form-control text-right" id="order_date" name="order_date" placeholder="Select date" value="<?php echo date('d/m/Y') ?>" />
					</div>
				</div>
				<div class="form-group m-form__group row">
					<label for="num_of_orders" class="col-form-label col-md-4">Number of Orders <span class="required">*</span></label>
					<div class="col-lg-8 col-xl-3">
						<input type="text" id="num_of_orders" name="num_of_orders" class="form-control text-right" value="20" />
					</div>
				</div>
			</div>
			<div class="m-portlet__foot m-portlet__foot--fit">
				<div class="m-form__actions m-form__actions--solid">
					<button type="submit" class="btn btn-primary" name="run" value="Generate">Generate</button>
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

<script>
$(document).ready(function() {
	$('#order_date').datepicker({
		autoclose: true, 
		orientation: 'bottom left',
		todayHighlight: true,
		language: '<?php echo $lang ?>',
		format: {
			toDisplay: function (date, format, language) {
				var d = moment(date);
				return d.format('DD/MM/YYYY');
			},
			toValue: function(date, format, language) {
				var d = moment(date, 'DD/MM/YYYY');
				return new Date(d.valueOf());
			}
		}
	});
});
</script>