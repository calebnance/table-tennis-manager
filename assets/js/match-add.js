$(document).ready(function(){
	
	$('#match-add').on('click', function(e){
		e.preventDefault();
		if($(this).hasClass('disabled')){
			return false;
		}
		$.validateForm(true);
	});
	
	$('#match_created_form').on('click', '.plus, .minus', function(e){
		e.preventDefault();
		$value = $(this).closest('.controls').find('input').val();
		if($(this).hasClass('minus')){
			if($value == 0) return false;
			$value--;
		} else if($(this).hasClass('plus')){
			$value++;
		}
		$(this).closest('.controls').find('input').val($value);
	});
	
	$.validateForm = function(check_empty){
		$fields = $('#match_add_form .required');
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
					
					$match_add		= $('#match_add_form');
					$match_created	= $('#match_created_form');
					
					$match_add.fadeOut(400);
					$match_created.delay(400).fadeIn(400);
					
					// Update data
					$match_created.find('#player1').html(data.player1.username);
					$match_created.find('#player2').html(data.player2.username);
					
					
				}).fail(function(){
					$('#message-area').hide().html('<div class="alert alert-warning alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Something went wrong! Please reload the page and try again.</div>').slideDown(400);
				});
			}).fail(function(){
				$('#message-area').hide().html('<div class="alert alert-warning alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Something went wrong! Please reload the page and try again.</div>').slideDown(400);
			});
		}
	}
});