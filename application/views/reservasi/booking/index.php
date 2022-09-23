<div class="row">
	<div class="card">
		<div class="card-header bg-white header-elements-inline">
			<h6 class="card-title">FORM RESERVASI ONLINE</h6>
		</div>

		<form class="wizard-form steps-validation" action="#" data-fouc>
			<h6>Selamat Datang</h6>
			<fieldset>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label>Nomor MR: </label>
							<input type="text" name="p_no_mr" class="form-control" placeholder="0011223">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<label>Tanggal lahir:</label>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<select name="birth-month" data-placeholder="Month" class="form-control form-control-select2" data-fouc>
										<option></option>
										<option value="1">January</option>
										<option value="2">February</option>
										<option value="3">March</option>
										<option value="4">April</option>
										<option value="5">May</option>
										<option value="6">June</option>
										<option value="7">July</option>
										<option value="8">August</option>
										<option value="9">September</option>
										<option value="10">October</option>
										<option value="11">November</option>
										<option value="12">December</option>
									</select>
								</div>
							</div>

							<div class="col-md-4">
								<div class="form-group">
									<select name="birth-day" data-placeholder="Day" class="form-control form-control-select2" data-fouc>
										<option></option>
										<option value="1">1</option>
										<option value="2">2</option>
										<option value="3">3</option>
										<option value="4">4</option>
										<option value="5">5</option>
										<option value="6">6</option>
										<option value="7">7</option>
										<option value="8">8</option>
										<option value="9">9</option>
										<option value="...">...</option>
										<option value="31">31</option>
									</select>
								</div>
							</div>

							<div class="col-md-4">
								<div class="form-group">
									<select name="birth-year" data-placeholder="Year" class="form-control form-control-select2" data-fouc>
										<option></option>
										<option value="1">1980</option>
										<option value="2">1981</option>
										<option value="3">1982</option>
										<option value="4">1983</option>
										<option value="5">1984</option>
										<option value="6">1985</option>
										<option value="7">1986</option>
										<option value="8">1987</option>
										<option value="9">1988</option>
										<option value="10">1989</option>
										<option value="11">1990</option>
									</select>
								</div>
							</div>
						</div>
					</div>
				</div>
			</fieldset>

			<h6>Pilih Dokter</h6>
			<fieldset>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label>Polikklinik:</label>
							<select name="university-country" data-placeholder="Pilih Poliklinik" class="form-control form-control-select2" data-fouc>
								<option></option> 
								<option value="1">Poliklinik Umum</option> 
								<option value="2">Poliklinik Gigi dan Mulut</option> 
								<option value="3">Poliklinik Mata</option> 
								<option value="4">Poliklinik Kulit</option> 
							</select>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xl-3 col-sm-6">
				    	<div class="card card-body text-center">
							<div class="mb-3">
								<h6 class="font-weight-semibold mb-0 mt-1">Hanna Dorman</h6>
								<span class="d-block text-muted">Dokter Umum</span>
							</div>

							<a href="#" class="d-inline-block mb-3">
								<img src="<?php echo base_url('assets/img/placeholders/placeholder.jpg')?>" class="rounded-round" width="150" height="150" alt="">
							</a>

							<ul class="list-inline list-inline-condensed mb-0">
								<li class="list-inline-item"><a href="#" class="btn btn-outline bg-success btn-icon text-success border-success border-2 rounded-round">
									<i class="icon-user-check"></i></a>
								</li>
							</ul>
						</div>
					</div>

					<div class="col-xl-3 col-sm-6">
				    	<div class="card card-body text-center">
							<div class="mb-3">
								<h6 class="font-weight-semibold mb-0 mt-1">Dokter Spesialis Mata</h6>
								<span class="d-block text-muted">Network engineer</span>
							</div>

							<a href="#" class="d-inline-block mb-3">
								<img src="<?php echo base_url('assets/img/placeholders/placeholder.jpg')?>" class="rounded-round" width="150" height="150" alt="">
							</a>

							<ul class="list-inline list-inline-condensed mb-0">
								<li class="list-inline-item"><a href="#" class="btn btn-outline bg-info btn-icon text-info border-info border-2 rounded-round">
									<i class="icon-user-check"></i></a>
								</li>
							</ul>
						</div>
					</div>

				</div>

			</fieldset>

			<h6>Sukses</h6>
			<fieldset>
				<div class="row text-center">
					<div class="col-md-12">

						Terimakasih telah melakukan reservasi secara online<br/>
						Anda telah terdaftar didalam sistem kami, Silahkan melakukan kunjungan dengan memperlihatkan bukti reservasi anda.
					</div>

					<div class="col-md-12 text-center">
						<span style="font-weight:800; font-size: 24px;">GS12H87</span>
					</div>
				</div>
			</fieldset>

		</form>
	</div>
</div>	
<script>
/* ------------------------------------------------------------------------------
 *
 *  # Steps wizard
 *
 *  Demo JS code for form_wizard.html page
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

var FormWizard = function() {


    //
    // Setup module components
    //

    // Wizard
    var _componentWizard = function() {
        if (!$().steps) {
            console.warn('Warning - steps.min.js is not loaded.');
            return;
        }

        // Basic wizard setup
        $('.steps-basic').steps({
            headerTag: 'h6',
            bodyTag: 'fieldset',
            transitionEffect: 'fade',
            titleTemplate: '<span class="number">#index#</span> #title#',
            labels: {
                previous: '<i class="icon-arrow-left13 mr-2" /> Previous',
                next: 'Next <i class="icon-arrow-right14 ml-2" />',
                finish: 'Submit form <i class="icon-arrow-right14 ml-2" />'
            },
            onFinished: function (event, currentIndex) {
                alert('Form submitted.');
            }
        });

        // Async content loading
        $('.steps-async').steps({
            headerTag: 'h6',
            bodyTag: 'fieldset',
            transitionEffect: 'fade',
            titleTemplate: '<span class="number">#index#</span> #title#',
            loadingTemplate: '<div class="card-body text-center"><i class="icon-spinner2 spinner mr-2"></i>  #text#</div>',
            labels: {
                previous: '<i class="icon-arrow-left13 mr-2" /> Previous',
                next: 'Next <i class="icon-arrow-right14 ml-2" />',
                finish: 'Submit form <i class="icon-arrow-right14 ml-2" />'
            },
            onContentLoaded: function (event, currentIndex) {
                $(this).find('.card-body').addClass('hide');

                // Re-initialize components
                _componentSelect2();
                _componentUniform();
            },
            onFinished: function (event, currentIndex) {
                alert('Form submitted.');
            }
        });

        // Saving wizard state
        $('.steps-state-saving').steps({
            headerTag: 'h6',
            bodyTag: 'fieldset',
            titleTemplate: '<span class="number">#index#</span> #title#',
            labels: {
                previous: '<i class="icon-arrow-left13 mr-2" /> Previous',
                next: 'Next <i class="icon-arrow-right14 ml-2" />',
                finish: 'Submit form <i class="icon-arrow-right14 ml-2" />'
            },
            transitionEffect: 'fade',
            saveState: true,
            autoFocus: true,
            onFinished: function (event, currentIndex) {
                alert('Form submitted.');
            }
        });

        // Specify custom starting step
        $('.steps-starting-step').steps({
            headerTag: 'h6',
            bodyTag: 'fieldset',
            titleTemplate: '<span class="number">#index#</span> #title#',
            labels: {
                previous: '<i class="icon-arrow-left13 mr-2" /> Previous',
                next: 'Next <i class="icon-arrow-right14 ml-2" />',
                finish: 'Submit form <i class="icon-arrow-right14 ml-2" />'
            },
            transitionEffect: 'fade',
            startIndex: 2,
            autoFocus: true,
            onFinished: function (event, currentIndex) {
                alert('Form submitted.');
            }
        });

        // Enable all steps and make them clickable
        $('.steps-enable-all').steps({
            headerTag: 'h6',
            bodyTag: 'fieldset',
            transitionEffect: 'fade',
            enableAllSteps: true,
            titleTemplate: '<span class="number">#index#</span> #title#',
            labels: {
                previous: '<i class="icon-arrow-left13 mr-2" /> Previous',
                next: 'Next <i class="icon-arrow-right14 ml-2" />',
                finish: 'Submit form <i class="icon-arrow-right14 ml-2" />'
            },
            onFinished: function (event, currentIndex) {
                alert('Form submitted.');
            }
        });


        //
        // Wizard with validation
        //

        // Stop function if validation is missing
        if (!$().validate) {
            console.warn('Warning - validate.min.js is not loaded.');
            return;
        }

        // Show form
        var form = $('.steps-validation').show();


        // Initialize wizard
        $('.steps-validation').steps({
            headerTag: 'h6',
            bodyTag: 'fieldset',
            titleTemplate: '<span class="number">#index#</span> #title#',
            labels: {
                previous: '<i class="icon-arrow-left13 mr-2" /> Previous',
                next: 'Next <i class="icon-arrow-right14 ml-2" />',
                finish: 'Submit form <i class="icon-arrow-right14 ml-2" />'
            },
            transitionEffect: 'fade',
            autoFocus: true,
            onStepChanging: function (event, currentIndex, newIndex) {

                // Allways allow previous action even if the current form is not valid!
                if (currentIndex > newIndex) {
                    return true;
                }

                // Needed in some cases if the user went back (clean up)
                if (currentIndex < newIndex) {

                    // To remove error styles
                    form.find('.body:eq(' + newIndex + ') label.error').remove();
                    form.find('.body:eq(' + newIndex + ') .error').removeClass('error');
                }

                form.validate().settings.ignore = ':disabled,:hidden';
                return form.valid();
            },
            onFinishing: function (event, currentIndex) {
                form.validate().settings.ignore = ':disabled';
                return form.valid();
            },
            onFinished: function (event, currentIndex) {
                alert('Submitted!');
            }
        });


        // Initialize validation
        $('.steps-validation').validate({
            ignore: 'input[type=hidden], .select2-search__field', // ignore hidden fields
            errorClass: 'validation-invalid-label',
            highlight: function(element, errorClass) {
                $(element).removeClass(errorClass);
            },
            unhighlight: function(element, errorClass) {
                $(element).removeClass(errorClass);
            },

            // Different components require proper error label placement
            errorPlacement: function(error, element) {

                // Unstyled checkboxes, radios
                if (element.parents().hasClass('form-check')) {
                    error.appendTo( element.parents('.form-check').parent() );
                }

                // Input with icons and Select2
                else if (element.parents().hasClass('form-group-feedback') || element.hasClass('select2-hidden-accessible')) {
                    error.appendTo( element.parent() );
                }

                // Input group, styled file input
                else if (element.parent().is('.uniform-uploader, .uniform-select') || element.parents().hasClass('input-group')) {
                    error.appendTo( element.parent().parent() );
                }

                // Other elements
                else {
                    error.insertAfter(element);
                }
            },
            rules: {
                email: {
                    email: true
                }
            }
        });
    };

    // Uniform
    var _componentUniform = function() {
        if (!$().uniform) {
            console.warn('Warning - uniform.min.js is not loaded.');
            return;
        }

        // Initialize
        $('.form-input-styled').uniform({
            fileButtonClass: 'action btn bg-blue'
        });
    };

    // Select2 select
    var _componentSelect2 = function() {
        if (!$().select2) {
            console.warn('Warning - select2.min.js is not loaded.');
            return;
        }

        // Initialize
        var $select = $('.form-control-select2').select2({
            minimumResultsForSearch: Infinity,
            width: '100%'
        });

        // Trigger value change when selection is made
        $select.on('change', function() {
            $(this).trigger('blur');
        });
    };


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _componentWizard();
            _componentUniform();
            _componentSelect2();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    FormWizard.init();
});
</script>