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
		var submit = true;
		$.each($fields, function(f, field){
			if(check_empty){
				if($(field).val() == ''){
					submit = false;
				}
			}
			
			
			if($(field).val() != ''){
					
			}
		});
		
		if(check_empty){
			console.log('Submit form :' + submit);
		}
	}
});