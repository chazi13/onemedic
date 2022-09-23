<div class="row">
	<div class="col-xl-3 col-lg-4">
		<div class="m-portlet m-portlet--full-height   m-portlet--rounded">
			<div class="m-portlet__body">
				<div class="m-card-profile">
					<div class="m-card-profile__title m--hide">
						Your Profile
					</div>
					<div class="m-card-profile__details">
						<span class="m-card-profile__name"><?php echo $fullname ?></span>
						<a href="mailto:<?php echo $email ?>" class="m-card-profile__email m-link"><?php echo $email ?></a>
					</div>
					<div class="m-card-profile__pic">
						<div class="m-card-profile__pic-wrapper">
							<img src="<?php echo image_url('user.jpg') ?>" alt="">
						</div>
					</div>
					<a href="#" class="m-card-profile__pic-link" data-toggle="modal" data-target="#avatar-modal">Change Avatar</a>
				</div>	
				<ul class="m-nav m-nav--hover-bg m-portlet-fit--sides">
					<li class="m-nav__separator m-nav__separator--fit"></li>
					<li class="m-nav__section m--hide">
						<span class="m-nav__section-text">Section</span>
					</li>
					<li class="m-nav__item">
						<a href="?page=header/profile&amp;demo=default" class="m-nav__link">
							<i class="m-nav__link-icon flaticon-profile-1"></i>
							<span class="m-nav__link-title">  
								<span class="m-nav__link-wrap">      
									<span class="m-nav__link-text">My Profile</span>      
								</span>
							</span>
						</a>
					</li>
					<li class="m-nav__item">
						<a href="?page=header/profile&amp;demo=default" class="m-nav__link">
						<i class="m-nav__link-icon flaticon-share"></i>
							<span class="m-nav__link-text">Activity</span>
						</a>
					</li>
					<li class="m-nav__item">
						<a href="?page=header/profile&amp;demo=default" class="m-nav__link">
							<i class="m-nav__link-icon flaticon-chat-1"></i>
							<span class="m-nav__link-text">Messages</span>
						</a>
					</li>
					<li class="m-nav__item">
						<a href="?page=header/profile&amp;demo=default" class="m-nav__link">
							<i class="m-nav__link-icon flaticon-graphic-2"></i>
							<span class="m-nav__link-text">Sales</span>
						</a>
					</li>
					<li class="m-nav__item">
						<a href="?page=header/profile&amp;demo=default" class="m-nav__link">
							<i class="m-nav__link-icon flaticon-time-3"></i>
							<span class="m-nav__link-text">Events</span>
						</a>
					</li>
					<li class="m-nav__item">
						<a href="?page=header/profile&amp;demo=default" class="m-nav__link">
							<i class="m-nav__link-icon flaticon-lifebuoy"></i>
							<span class="m-nav__link-text">Support</span>
						</a>
					</li>
				</ul>

			</div>			
		</div>	
	</div>
	<div class="col-xl-9 col-lg-8">
		<div class="m-portlet m-portlet--full-height m-portlet--tabs   m-portlet--rounded">
			<div class="m-portlet__head">
				<div class="m-portlet__head-tools">
					<ul class="nav nav-tabs m-tabs m-tabs-line   m-tabs-line--left m-tabs-line--primary" role="tablist">
						<li class="nav-item m-tabs__item">
							<a class="nav-link m-tabs__link active show" data-toggle="tab" href="#m_user_profile_tab_1" role="tab" aria-selected="true">
								<i class="flaticon-share m--hide"></i>
								Update Profile
							</a>
						</li>
						<li class="nav-item m-tabs__item">
							<a class="nav-link m-tabs__link" data-toggle="tab" href="#m_user_profile_tab_2" role="tab" aria-selected="false">
								Messages
							</a>
						</li>
						<li class="nav-item m-tabs__item">
							<a class="nav-link m-tabs__link" data-toggle="tab" href="#m_user_profile_tab_3" role="tab" aria-selected="false">
								Settings
							</a>
						</li>
					</ul>
				</div>
			</div>
			<div class="tab-content">
				<div class="tab-pane active show" id="m_user_profile_tab_1">
					<form method="post" class="m-form m-form--fit m-form--label-align-right" enctype="multipart/form-data">
						<div class="m-portlet__body">
							<div class="form-group m-form__group row">
								<?php echo messages() ?>
							</div>
							<?php echo $form->fields() ?>
						</div>
						<div class="m-portlet__foot m-portlet__foot--fit">
							<div class="m-form__actions text-right">
								<button type="submit" class="btn btn-primary" name="save" value="save" title="Simpan">
									<i class="fa fa-save"></i>
									<?php echo lang('save'); ?>
								</button>
							</div>
						</div>
					</form>
				</div>
				<div class="tab-pane" id="m_user_profile_tab_2">
					
				</div>
				<div class="tab-pane" id="m_user_profile_tab_3">
					
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="avatar-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body">
				<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type
					specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages,
					and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary">Save changes</button>
			</div>
		</div>
	</div>
</div>

<script>
$(document).ready(function() {
});
</script>