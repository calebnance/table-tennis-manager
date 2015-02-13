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
		}).fail(function(jqXHR, textStatus, errorThrown){
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
		var pass1 = pass2 = pass3 = pass4 = true;
		// step1 check
		$step1 		  = $('#step1 .required');
		$step1Count = $step1.length;
		// are there required fields in step 1?
		if($step1Count > 1) {
			// if connection button had success already?
			if($('#check-connection').hasClass('btn-success')) {
				$('#check-connection').removeClass('btn-success').addClass('btn-default').html('Check Connection');
				$('#gotoStep2').fadeOut(400);
				$('[href="#step1"]').removeClass('completed').html('Step 1');
				$('#step1').attr('data-complete', 0);
			}
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
			$('#check-connection').slideDown(400);
		} else {
			$('#check-connection').slideUp(400);
		}

	});

	// on steppers for wizard clicked
	$('#wizard').on('click', '[href="#step1"], [href="#step2"], [href="#step3"], [href="#step4"]', function(e) {
		// not completed, no go
		if(!$(this).hasClass('completed')) {
			e.preventDefault();
			e.stopPropagation();
		}
	});

	// on check connection click
	$('#wizard').on('click', '#check-connection', function(e){
			e.preventDefault();
			// working
			if($(this).hasClass('working')) {
				return false;
			}
			$(this).addClass('working').html('<i class="fa fa-spinner fa-spin"></i> Checking..');
			// set args
			var args = {
				host : $('#dbHost').val(),
				table : $('#dbTable').val(),
				user : $('#dbUser').val(),
				pass : $('#dbPass').val(),
				responseType : 'json'
			};

			// clear errorMsg
			$('#errorMsg').html('');

			$.ajax({
				type : 'POST',
				url : '../ajax.php',
				dataType : 'json',
				data : {
					ajax : true,
					function : 'checkConnection',
					args : args
				}
			}).done(function(data){
				// remove class of working
				$('#check-connection').removeClass('working');
				// any errors?
				if(data.error) {
					$('#errorMsg').html('<div class="alert alert-danger bs3-btn-padding margin-b-0" role="alert">' + data.msg + '</div>');
					$('#check-connection').html('Check Connection');
				} else {
					$('#check-connection').removeClass('btn-default').addClass('btn-success').html('Connection Success!');
					$('#step1').attr('data-complete', 1);
					$('#gotoStep2').fadeIn(400);
				}
			}).fail(function( jqXHR, textStatus, errorThrown ){
				// remove class of working
				$('#check-connection').removeClass('working');
				console.log(jqXHR);
				console.log(textStatus);
				console.log(errorThrown);
			});
	});

	// go to step2
	$('#wizard').on('click', '#gotoStep2', function(e){
		$('#tab-wizard li:eq(1) a').tab('show');
		$('[href="#step1"]').addClass('completed').html('<span class="label label-success">Step 1</span>');
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
	// show image passed with url and caption
	function showGravatarOrNah(imgGrava, captionW) {
		// set image
		var proImage = $('<img>').attr({ src: imgGrava, class: 'img-thumbnail' });
		// boom
		$('.gravatar').html(proImage).append('<div class="img-caption">' + captionW + '</div>').css('visibility', 'visible').hide().fadeIn(400);
	}

});
