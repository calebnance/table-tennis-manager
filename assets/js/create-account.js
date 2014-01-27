$(document).ready(function(){
	
	$('input').on('change', function(e){
		e.preventDefault();
		$.validateForm(false);
	});
	
	$('#submit-create-account').on('click', function(e){
		e.preventDefault();
		console.log('Submit form clicked');
		$.validateForm(true);
	});
	
	$.validateForm = function(check_empty){
		$fields = $('form .required');
		var email_val = /[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}/igm;
		var submit = true;
		$.each($fields, function(f, field){
			var value = $(field).val();
			var name = $(field).attr('name'); 
			if(check_empty){
				if(value == ''){
					$(field).closest('.form-group').addClass('has-error').removeClass('has-success');
					submit = false;
				} else {
					$(field).closest('.form-group').removeClass('has-error').addClass('has-success');
				}
			}
			
			if(value != '' || check_empty == true){
				if(name == 'acco_email'){
					if(!email_val.test(value)){
						$(field).prev('label').find('span').html('<small> - Not valid!</small>');
						$(field).closest('.form-group').addClass('has-error').removeClass('has-success');
					} else {
						$(field).prev('label').find('span').html('<small> - Is valid!</small>');
						$(field).closest('.form-group').addClass('has-success').removeClass('has-error');
					}
				} else if(name == 'acco_password'){
					var pass2 = $('#acco_password2').val();
					if(pass2 != ''){
						if(value != pass2){
							$('#acco_password').prev('label').find('span').html('<small> - Passwords do not match</small>');
							$('#acco_password').closest('.form-group').addClass('has-error').removeClass('has-success');
							$('#acco_password2').closest('.form-group').addClass('has-error').removeClass('has-success');
						} else {
							$('#acco_password').prev('label').find('span').html('<small> - Passwords match!</small>');
							$('#acco_password').closest('.form-group').removeClass('has-error').addClass('has-success');
							$('#acco_password2').closest('.form-group').removeClass('has-error').addClass('has-success');
						}
					}
				} else {
					if(value == ''){
						$(field).closest('.form-group').addClass('has-error').removeClass('has-success');
						submit = false;
					} else {
						$(field).closest('.form-group').removeClass('has-error').addClass('has-success');
					}
				}
			}
		});
		
		if(check_empty && submit){
			console.log('Submit form');
			$.ajax({
				url: 'create-account.php',
				type: 'POST',
				dataType: 'json',
				data: $('#create_account_form').serialize()
			}).done(function(data){
				$('#message-area').hide().html('<div class="alert alert-' + data.type + ' alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' + data.msg + '</div>').slideDown(400);
				console.log('success');
				console.log(data);
			}).fail(function(){
				console.log('Ajax fail');
			});
		}
	}
});