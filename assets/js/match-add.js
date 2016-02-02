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
		// points to win
		$pts_to_win = parseInt($('#pts_to_win').val());
		// value of input
		$value = $(this).closest('.controls').find('input').val();
		// get player
		$player_num = $(this).closest('.player-area').attr('data-id');
		// player check
		if($player_num == 1) {
			$other_player_score = parseInt($('#score_2').val());
		} else {
			$other_player_score = parseInt($('#score_1').val());
		}
		// are we taking away or adding?
		if($(this).hasClass('minus')){
			// would it be 0?
			if($value == 0) return false;
			$value--;
		} else if($(this).hasClass('plus')){
			// win value
			if($value == $pts_to_win) return false;
			// make sure other player can't go to win value
			if($other_player_score == $pts_to_win && $(this).closest('.controls').find('input').hasClass('scoring')) {
				return false;
			}
			$value++;
		}
		$(this).closest('.controls').find('input').val($value);

		count = 3;
		clearInterval(counter);

		$.autoUpdate();
	});

	$('#match-complete').on('click', function(e){
		var update_data = $('#match_created_form').serialize();
		update_data += '&completed=1';

		$.ajax({
			url: 'match-add.php',
			type: 'POST',
			dataType: 'json',
			data: update_data
		}).done(function(data){
			$('#match-complete').addClass('btn-success').removeClass('btn-navy').html('<i class="fa fa-check"></i> Match Saved!');
			$('#player1-area, #player2-area, .verses, #match-updating').fadeOut(400);

			setTimeout(function(){
				location.reload();
			}, 2000);

		}).fail(function(){

			console.log('FAILED UPDATE: #match-complete click');

		});
	});

	$.playerServe = function(){
		// players stuff
		$match_created	= $('#match_created_form');
		$p1_score				= parseInt($('#score_1').val());
		$p2_score				= parseInt($('#score_2').val());
		$total_score		= $p1_score + $p2_score;
		$serve_first		= parseInt($('#serve_first').val());
		$player_first		= $match_created.find('label[data-player-id="' + $serve_first + '"]').attr('id');
		$player_first		= $player_first == 'player1-label' ? 'player1-label' : 'player2-label';
		$player_second	= $player_first == 'player1-label' ? 'player2-label' : 'player1-label';

		// game stuff
		$pts_per_turn = parseInt($('#pts_per_turn').val());
		$skunk				= parseInt($('#skunk').val());
		$pts_to_win		= parseInt($('#pts_to_win').val());

		// TODO
		// short game arrays
		var first_points = [0, 1, 4, 5, 8, 9, 12, 13, 16, 17, 20];
		var secon_points = [2, 3, 6, 7, 10, 11, 14, 15, 18, 19];
		// long game arrays
		// var first_points = [0, 1, 2, 3, 4, 10, 11, 12, 13, 14, 20, 21, 22, 23, 24, 30, 31, 32, 33, 34, 40];
		// var secon_points = [5, 6, 7, 8, 9, 15, 16, 17, 18, 19, 25, 26, 27, 28, 29, 35, 36, 37, 38, 39];

		// clear player messages
		$('#player1-msg').html('');
		$('#player2-msg').html('');

		// is it a possible skunk coming up?!
		if(parseInt($('#score_2').val()) == 0 && parseInt($('#score_1').val()) == ($skunk - 1)) {
			// player 1 is about to have a skunk!
			$('#player2-msg').html('<span class="label label-info">A skunk is close...</span>');
		} else if(parseInt($('#score_1').val()) == 0 && parseInt($('#score_2').val()) == ($skunk - 1)) {
			// player 2 is about to have a skunk!
			$('#player1-msg').html('<span class="label label-info">A skunk is close...</span>');
		}

		// is it skunk?!
		if(parseInt($('#score_2').val()) == 0 && parseInt($('#score_1').val()) == $skunk) {
			// player 1 has a skunk!
			$('#player1-msg').html('<span class="label label-success">Winner</span>');
			$('#player2-msg').html('<span class="label label-danger">You have been skunked!</span>');
		} else if(parseInt($('#score_1').val()) == 0 && parseInt($('#score_2').val()) == $skunk) {
			// player 2 has a skunk!
			$('#player2-msg').html('<span class="label label-success">Winner</span>');
			$('#player1-msg').html('<span class="label label-danger">You have been skunked!</span>');
		}

		// if short game (2 points a serve)
		if($.inArray($total_score, first_points) >= 0 || $total_score == 0) {
			// even, so it's who served first
			$('#' + $player_first).addClass('serving');
			$('#' + $player_second).removeClass('serving');
		} else {
			// else it's the other person, cool
			$('#' + $player_second).addClass('serving');
			$('#' + $player_first).removeClass('serving');
		}

		// is player at game point?
		if(($pts_to_win - 1) == $p1_score) {
			$('#' + $player_second).addClass('serving');
			$('#' + $player_first).removeClass('serving');
		} else if(($pts_to_win - 1) == $p2_score) {
			$('#' + $player_first).addClass('serving');
			$('#' + $player_second).removeClass('serving');
		}

		// deuce??
		if(($pts_to_win - 1) == $p1_score && ($pts_to_win - 1) == $p2_score) {
			$('#player1-msg').html('<span class="label label-info">Deuce</span>');
			$('#player2-msg').html('<span class="label label-info">Deuce</span>');
			$('.serving').removeClass('serving');
		}

		// winner player 1
		if(($pts_to_win) == $p1_score && ($pts_to_win) != $p2_score) {
			$('#player1-msg').html('<span class="label label-success">Winner</span>');
			$('#player2-msg').html('');
			$('.serving').removeClass('serving');
		}

		// winner player 2
		if(($pts_to_win) != $p1_score && ($pts_to_win) == $p2_score) {
			$('#player1-msg').html('');
			$('#player2-msg').html('<span class="label label-success">Winner</span>');
			$('.serving').removeClass('serving');
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
			var add_s = (count == 1) ? '' : 's';
			$('#match-updating').find('span.secs').html(count);
			$('#match-updating').find('span.add_s').html(add_s);
		}, 1000);

		clearTimeout(updating);
		updating = setTimeout(function(){
			$match_updating.addClass('alert-success').removeClass('alert-warning alert-info').html('updated!');
			var update_data = $('#match_created_form').serialize();
			$.ajax({
				url: 'match-add.php',
				type: 'POST',
				dataType: 'json',
				data: update_data
			}).done(function(data){

					//console.log('Updated');
					//console.log(data);

			}).fail(function(){

				console.log('FAILED UPDATE: $.autoUpdate');

			});

		}, 3000);
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

					//console.log(match_start);

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
