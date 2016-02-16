$(document).ready(function() {

	/**
	 * vars
	 */
	var caTimeout;
	var canSubmitForm = true;

	/**
	 * on functions
	 */

	// on change/blur of required field(s) on page
	$('input.required').on('change blur', function(e) {
		e.preventDefault();
		$blurThis = $(this);
		$.validateForm(false, $blurThis);
	});

	// on input of required field(s) on page, with 2 second delay
	$('input.required').on('input', function(e) {
		e.preventDefault();
		$inputThis = $(this);
		clearTimeout(caTimeout);
		caTimeout = setTimeout(function(e){
			$.validateForm(false, $inputThis);
		}, 2000);
	});

	// on submit, re-run the validation check
	$('#submit-create-account').on('click', function(e) {
		e.preventDefault();
		$.validateForm(true, '');
	});

	/**
	 * functions
	 */

	// set validation function
	$.validateForm = function(check_empty, check_single) {
		$fields = $('#create_account_form .required');
		var email_val = /[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}/igm;

		// single check if empty
		if(check_single !== '') {
			checkIfEmpty(check_single, $(check_single).val());
		} else {
			canSubmitForm = true;
		}

		// parse through all required fields on page
		$.each($fields, function(f, field) {
			var value = $(field).val();
			var name = $(field).attr('name');

			// check if empty
			if(check_empty) {
				checkIfEmpty(field, value);
			}

			if(value !== '' || check_empty == true) {
				if(name == 'acco_email') {
					if(!email_val.test(value)) {
						$(field).prev('label').find('span').html('<small> - Not valid!</small>');
						$(field).closest('.form-group').addClass('has-error').removeClass('has-success');
					} else {
						$(field).prev('label').find('span').html('<small> - Is valid!</small>');
						$(field).closest('.form-group').addClass('has-success').removeClass('has-error');
					}
				} else if(name == 'acco_password') {
					var pass2 = $('#acco_password2').val();
					if(pass2 !== '') {
						if(value !== pass2) {
							passwordsDontMatch();
						} else {
							passwordsDoMatch();
						}
					}
				} else if(name == 'acco_password2') {
					var pass1 = $('#acco_password').val();
					if(pass1 !== '') {
						if(value !== pass1) {
							passwordsDontMatch();
						} else {
							passwordsDoMatch();
						}
					}
				} else {
					if(value == '') {
						$(field).closest('.form-group').addClass('has-error').removeClass('has-success');
						canSubmitForm = false;
					} else {
						$(field).closest('.form-group').removeClass('has-error').addClass('has-success');
					}
				}
			}
		});

		if(check_empty && canSubmitForm) {
			$.ajax({
				url: 'create-account.php',
				type: 'POST',
				dataType: 'json',
				data: $('#create_account_form').serialize()
			}).done(function(data) {
				$('#message-area').hide().html('<div class="alert alert-' + data.type + ' alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' + data.msg + '</div>').slideDown();
			}).fail(function() {
				$('#message-area').hide().html('<div class="alert alert-warning alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Something went wrong, please reload the page and try again.</div>').slideDown();
			});
		}
	}

	// check if empty
	function checkIfEmpty(field, value) {
		if(value == '') {
			$(field).closest('.form-group').addClass('has-error').removeClass('has-success');
			canSubmitForm = false;
		} else {
			$(field).closest('.form-group').removeClass('has-error').addClass('has-success');
		}
	}

	// passwords don't match
	function passwordsDontMatch() {
		$('#acco_password').prev('label').find('span').html('<small> - Passwords do not match</small>');
		$('#acco_password').closest('.form-group').addClass('has-error').removeClass('has-success');
		$('#acco_password2').closest('.form-group').addClass('has-error').removeClass('has-success');
	}

	// passwords do match
	function passwordsDoMatch() {
		$('#acco_password').prev('label').find('span').html('<small> - Passwords match!</small>');
		$('#acco_password').closest('.form-group').removeClass('has-error').addClass('has-success');
		$('#acco_password2').closest('.form-group').removeClass('has-error').addClass('has-success');
	}

});
