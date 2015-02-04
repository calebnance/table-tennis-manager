$(document).ready(function(){

	/**
	 * init stuff
	 */

	// check for gravatar
	if($('.gravatar').length && $('.gravatar').attr('data-email')){
		// grab user md5 hash from e-mail address
		var emailGra = $('.gravatar').attr('data-email');
		// grab username for no apparent reason
		var usernGra = $('.gravatar').attr('data-username');
		// gravatar json url set
		var gravaUrl = 'https://en.gravatar.com/' + emailGra + '.json';
		// grab gravatar or use placekitten... for le kittens.
		$.ajax({
			type : 'GET',
			url : gravaUrl,
			async : false,
			dataType : 'jsonp'
		}).done(function(data){
			// only if returned good data
			if(data) {
					// if we need this later or something maybe
					var userGrav = data.entry[0];
					var imgGrava = 'http://www.gravatar.com/avatar/' + emailGra + '?s=250';
					var captionW = 'You Have A Gravatar Account';
					// gravatar show
					showGravatarOrNah(imgGrava, captionW);
			}
		}).fail(function( jqXHR, textStatus, errorThrown ){
			// something went wrong wif this
			console.log('error with gravatar user look-up');
			var imgGrava = 'http://placekitten.com/g/250/250';
			var captionW = 'You Need A Gravatar Account..';
			// gravatar nah
			showGravatarOrNah(imgGrava, captionW);
		});
	}

	// Bootstrap 3 tooltip
	$('[data-toggle="tooltip"]').tooltip();

	/**
	 * on stuff
	 */

	/**
	 * ajax stuff
	 */

	// get e-mail hash for gravatar
	// $.ajax({
	// 	type : 'POST',
	// 	url : 'ajax.php',
	// 	dataType : 'json',
	// 	data : {
	// 		ajax : true,
	// 		function : 'md5It',
	// 		args : {
	// 			'email' : 'calebnance@gmail.com',
	// 			'responseType' : 'json'
	// 		}
	// 	}
	// }).done(function(data){
	// 	console.log(data);
	// }).fail(function( jqXHR, textStatus, errorThrown ){
	// 	console.log(jqXHR);
	// 	console.log(textStatus);
	// 	console.log(errorThrown);
	// });

	/**
	 * function stuff
	 */
	function showGravatarOrNah(imgGrava, captionW) {
		// set image
		var proImage = $('<img>').attr({ src: imgGrava, class: 'img-thumbnail' });
		// boom
		$('.gravatar').html(proImage).append('<div class="img-caption">' + captionW + '</div>').css('visibility', 'visible').hide().fadeIn(400);
	}

});
