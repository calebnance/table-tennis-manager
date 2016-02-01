$(document).ready(function(){
	console.log('here');
	setTimeout(function(e){
		$('#pong-ball').addClass('service-right');
		checkForMatch();
	}, 2000);

	/**
	 * functions
	 */
	// check for match
	function checkForMatch() {
		// set args
		var args = {
			responseType : 'json'
		};
		// grab gravatar or use placekitten... for le kittens.
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
			$('#live-loader').hide();
			$('#table-tennis').slideDown(400);

			console.log(data);

		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log('FAILED');
		});
	}

});
