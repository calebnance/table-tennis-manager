$(document).ready(function(){
	
	$('#match-add').on('click', function(e){
		e.preventDefault();
		if($(this).hasClass('disabled')){
			return false;
		}
		$.validateForm(true);
	});
	
	$.validateForm = function(check_empty){
		$fields = $('form .required');
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
		});
		
		if(check_empty && submit){
			$('#match-add').html('Creating Match..').addClass('disabled');
			$.ajax({
				url: 'match-add.php',
				type: 'POST',
				dataType: 'json',
				data: $('#match_add_form').serialize()
			}).done(function(match_start){
				console.log(match_start);
				$.ajax({
					url: 'match-add.php',
					type: 'POST',
					dataType: 'json',
					data: match_start
				}).done(function(data){
					console.log(data);
				}).fail(function(){
					$('#message-area').hide().html('<div class="alert alert-warning alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Something went wrong! Please reload the page and try again.</div>').slideDown(400);
				});
			}).fail(function(){
				$('#message-area').hide().html('<div class="alert alert-warning alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Something went wrong! Please reload the page and try again.</div>').slideDown(400);
			});
		}
	}
});