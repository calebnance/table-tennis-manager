$(document).ready(function(){

	/**
	 *	vars
	 */
 	var liveNoMatchText = 'No Matches In Progress Currently';
 	var liveLoaderText = 'Looking for a live match<div class="loading-dots">...</div>';
	var totalSeconds = 0;
	var totalScore = 0;

	// TODO
	// short game arrays
	var first_points = [0, 1, 4, 5, 8, 9, 12, 13, 16, 17, 20];
	var secon_points = [2, 3, 6, 7, 10, 11, 14, 15, 18, 19];
	// long game arrays
	// var first_points = [0, 1, 2, 3, 4, 10, 11, 12, 13, 14, 20, 21, 22, 23, 24, 30, 31, 32, 33, 34, 40];
	// var secon_points = [5, 6, 7, 8, 9, 15, 16, 17, 18, 19, 25, 26, 27, 28, 29, 35, 36, 37, 38, 39];

	$pongBall = $('#pong-ball');
	$player1 = $('#player1');
	$player2 = $('#player2');
	$time = $('#time');

	/**
	 *	init
	 */
	setTimeout(function(e){
		//$('#pong-ball').addClass('service-right');
		checkForMatch();
	}, 2000);

	/**
	 *	on clicks
	 */

	// on refresh click
	$('#live-checker').on('click', function(e){
		$('#live-loader-text').html(liveLoaderText);
		checkForMatch();
	});

	/**
	 *	functions
	 */

	// check for match
	function checkForMatch() {
		// set args
		var args = {
			responseType : 'json'
		};
		// le ajax
		$.ajax({
			type : 'POST',
			url : '../ajax.php',
			dataType : 'json',
			data : {
				ajax : true,
				function : 'checkForLiveMatch',
				args : args
			}
		}).done(function(data){
			// is there a current match?
			if(!data.currentMatch) {
				$('#live-checker').fadeIn();
				$('#live-loader-text').html(liveNoMatchText);
			} else {
				// set who is serving
				serving(data.player1Score, data.player2Score, data);
				// set time
				var splitTime = data.totalTime.split(':');
				$time.fadeIn();
				$time.find('.hours').html(splitTime[0]);
				$time.find('.minutes').html(splitTime[1]);
				$time.find('.seconds').html(splitTime[2]);
				// start time
				totalSeconds = (parseInt(splitTime[2]) + (parseInt(splitTime[1]) * 60));
				setInterval(setTime, 1000);
				// okay let's show the table
				$('#live-loader').hide();
				$('#table-tennis').slideDown(400, function(e){
					// fill in the players
					$player1.find('.player').html(data.player1).fadeIn();
					$player2.find('.player').html(data.player2).fadeIn(400, function(e){
						// fill in the scores
						$player1.find('.score').html(data.player1Score).fadeIn();
						$player2.find('.score').html(data.player2Score).fadeIn();
						// now set the timer for checking every 10 seconds
						setInterval(checkForPoints, 10000);
					});
				});
			}
		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log('FAILED');
		});
	}

	// check for points
	function checkForPoints() {
		// set args
		var args = {
			responseType : 'json'
		};
		// le ajax
		$.ajax({
			type : 'POST',
			url : '../ajax.php',
			dataType : 'json',
			data : {
				ajax : true,
				function : 'checkForLiveMatch',
				args : args
			}
		}).done(function(data){
			if(!data.currentMatch) {
				console.log('do winner display!');
			} else {
				console.log(data);
				// fill in the scores
				$player1.find('.score').html(data.player1Score);
				$player2.find('.score').html(data.player2Score);
				// set who is serving
				serving(data.player1Score, data.player2Score, data);
			}
		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log('FAILED');
		});
	}

	// who is serving?
	function serving(player1Score, player2Score, data) {
		totalScore = player1Score + player2Score;
		// if short game (2 points a serve)
		if($.inArray(totalScore, first_points) >= 0 || totalScore == 0) {
			$pongBall.removeClass('service-right');
		} else {
			$pongBall.addClass('service-right');
		}

		// is player at game point?
		if((data.ptsToWin - 1) == player1Score) {
			$pongBall.removeClass('service-right');
		} else if((data.ptsToWin - 1) == player2Score) {
			$pongBall.addClass('service-right');
		}

		// deuce??
		if((data.ptsToWin - 1) == player1Score && (data.ptsToWin - 1) == player2Score) {
			$player1.find('.player-msg').html('<span class="label label-info">Deuce</span>');
			$player2.find('.player-msg').html('<span class="label label-info">Deuce</span>');
			// TODO: don't really know what to do here, maybe middle?
			$pongBall.fadeOut();
		}

		// winner player 1
		if((data.ptsToWin) == player1Score && (data.ptsToWin) != player2Score) {
			$player1.find('.player-msg').html('<span class="label label-success">Winner</span>');
			$player2.find('.player-msg').html('');
		}

		// winner player 2
		if((data.ptsToWin) != player1Score && (data.ptsToWin) == player2Score) {
			$player1.find('.player-msg').html('');
			$player2.find('.player-msg').html('<span class="label label-success">Winner</span>');
		}
	}

	// clock counter
  function setTime() {
    ++totalSeconds;
		var minutes = parseInt($time.find('.minutes').html());
		var seconds = parseInt($time.find('.seconds').html());
    $time.find('.seconds').html(pad(totalSeconds % 60));
    $time.find('.minutes').html(pad(parseInt(totalSeconds / 60)));
  }

	// pad the 0
	function pad(val) {
		var valString = val + '';
    if(valString.length < 2) {
			return '0' + valString;
		} else {
			return valString;
		}
	}

});
