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
	// on wizard field keyup/blur
	$('#wizard').on('keyup blur', '.required', function(e) {
		// steps to pass
		var pass1 = pass2 = pass3 = true;
		// step1 check
		$step1 		  = $('#step1 .required');
		$step1Count = $step1.length;
		// are there required fields in step 1?
		if($step1Count > 1) {
			// parse through the required fields for step 1
			$.each($step1, function(i, input) {
				// is it empty?
				if($(input).val() == '' || $(input).val() === null) {
					pass1 = false;
				}
			});
		}

		// is pass1 good?
		if(pass1 == true) {
			console.log(pass1 + ':: step1 is true')
		}

	});

	// on steppers for wizard clicked
	$('#wizard').on('click', '[href="#step1"], [href="#step2"], [href="#step3"], [href="#step4"]', function(e) {
		e.preventDefault();
		e.stopPropagation();
		console.log('here');
	});


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
