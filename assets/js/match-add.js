$(document).ready(function(){
	
	var updating, counter;
	var count = 3;
	
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
		
		count = 3;
		clearInterval(counter);
		
		$.autoUpdate();
	});
	
	$('#match-complete').on('click', function(e){
		var update_data = $('#match_created_form').serialize();
			
		console.log(update_data);
		
		$.ajax({
			url: 'match-add.php',
			type: 'POST',
			dataType: 'json',
			data: update_data
		}).done(function(data){
			$('#match-complete').html('Match Saved!');
			$('#player1-area, #player2-area, .verses, #match-updating').fadeOut(400);
			
			setTimeout(function(){
				location.reload();
			}, 2000);
			
		}).fail(function(){
		
			console.log('FAILED UPDATE');
			
		});
	});
	
	$.playerServe = function(){
		$match_created	= $('#match_created_form');
		$total_score	= parseInt($('#score_1').val()) + parseInt($('#score_2').val());
		$serve_turn		= parseInt($('#pts_per_turn').val());
		$serve_first	= parseInt($('#serve_first').val());
		$player_first	= $match_created.find('label[data-player-id="' + $serve_first + '"]').attr('id');
		$player_first	= $player_first == 'player1-label' ? 'player1-label' : 'player2-label';
		$player_second	= $player_first == 'player1-label' ? 'player2-label' : 'player1-label';
		
		if($total_score % $serve_turn === 0){
			console.log('switch');
			if($('#' + $player_first).hasClass('serving')){
				$('#' + $player_second).addClass('serving');
				$('#' + $player_first).removeClass('serving');
			} else {
				$('#' + $player_first).addClass('serving');
				$('#' + $player_second).removeClass('serving');
			}
		}
	}
	
	$.autoUpdate = function(){
	
		$.playerServe();
		
		$match_updating = $('#match-updating');
		$match_updating.addClass('alert-info').removeClass('alert-warning alert-success').html('updating in <span class="secs">' + count + '</span> second<span class="add_s">s</span>');

		counter = setInterval(function(){
			count = count - 1;
			if(count <= 0){
				clearInterval(counter);
				return;
			}
			var add_s = 's';
			if(count == 1){
				add_s = '';
			}
			$('#match-updating').find('span.secs').html(count);
			$('#match-updating').find('span.add_s').html(add_s);
		}, 1000);
	
		clearTimeout(updating);
		updating = setTimeout(function(){
			$match_updating.addClass('alert-success').removeClass('alert-warning alert-info').html('updated!');
			var update_data = $('#match_created_form').serialize();
			
			console.log(update_data);
			
			$.ajax({
				url: 'match-add.php',
				type: 'POST',
				dataType: 'json',
				data: update_data
			}).done(function(data){
			
				console.log(data);
				
			}).fail(function(){
			
				console.log('FAILED UPDATE');
				
			});
			
		}, 3000);
		
		
		console.log('made it to the update page');
	}
	
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
				if(match_start.error){
					$('#message-area').hide().html('<div class="alert alert-warning alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' +  match_start.msg + '</div>').slideDown(400);
					$('#match-add').html('Start Match').removeClass('disabled');
				} else {
					
					$('#match_id').val(match_start.match_id);
					
					$('#player1_id').val(match_start.player1);
					$('#player2_id').val(match_start.player2);
					
					$('#pts_per_turn').val(match_start.pts_per_turn);
					$('#pts_to_win').val(match_start.pts_to_win);
					$('#skunk').val(match_start.skunk);
					$('#serve_first').val(match_start.serve_first);
					
					console.log(match_start);
					$.ajax({
						url: 'match-add.php',
						type: 'POST',
						dataType: 'json',
						data: match_start
					}).done(function(data){
						
						$match_add		= $('#match_add_form');
						$match_created	= $('#match_created_form');
						
						$match_add.fadeOut(400);
						$match_created.delay(400).fadeIn(400);
						
						// Update data
						$match_created.find('#player1-label').html(data.player1.username).attr('data-player-id', match_start.player1);
						$match_created.find('#player2-label').html(data.player2.username).attr('data-player-id', match_start.player2);
						
						$match_created.find('label[data-player-id="' + match_start.serve_first + '"]').addClass('serving');
						
					}).fail(function(){
						$('#message-area').hide().html('<div class="alert alert-warning alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Something went wrong! Please reload the page and try again.</div>').slideDown(400);
					});
				}
			}).fail(function(){
				$('#message-area').hide().html('<div class="alert alert-warning alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Something went wrong! Please reload the page and try again.</div>').slideDown(400);
			});
		}
	}
});