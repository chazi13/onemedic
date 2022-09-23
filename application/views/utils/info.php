<?php echo messages(); ?>
<div class="row">
	<div class="col-xl-12">
		<div class="m-portlet m-portlet--mobile m-portlet--rounded">
			<div class="m-portlet__head">
				<div class="m-portlet__head-caption">
					<div class="m-portlet__head-title">
						<span class="m-portlet__head-icon">
							<i class="fa fa-info-circle"></i>
						</span>
						<h3 class="m-portlet__head-text">
							Info
						</h3>
					</div>
				</div>
			</div>
			<div class="m-portlet__body">
				<iframe id="info-frame" src="<?php echo site_url('utils/info/display_info') ?>" style="width: 100%;" frameborder="0"></iframe>
			</div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function() {
		$(window).on('resize', function() {
			var tframe = $('#info-frame');
			var wheight = $(window).height();
			var tframetop = Math.round(tframe.offset().top);
			var footerheight = $('.m-page > .m-footer').height();
			
			tframe.css('height', wheight - tframetop - footerheight - 92);
		}).trigger('resize');
	});
</script>