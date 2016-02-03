$(document).ready(function(){

	/**
	 * init
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
				var captionW = 'From <a href="http://www.gravatar.com" target="_blank">Gravatar</a>';
				// gravatar show
				showGravatarOrNah(imgGrava, captionW);
			}
		}).fail(function(jqXHR, textStatus, errorThrown){
			// something went wrong wif this
			console.log('error with gravatar user look-up');
			var imgGrava = 'http://placekitten.com/g/250/250';
			var captionW = 'You Need A <a href="http://www.gravatar.com" target="_blank">Gravatar</a> Account..';
			// gravatar nah
			showGravatarOrNah(imgGrava, captionW);
		});
	}

	// Bootstrap 3 tooltip
	$('[data-toggle="tooltip"]').tooltip();

	// start dot loader
	dotLoader();

	/**
	 * functions
	 */
	// show image passed with url and caption
	function showGravatarOrNah(imgGrava, captionW) {
		// set image
		var proImage = $('<img>').attr({ src: imgGrava, class: 'img-thumbnail' });
		// boom
		$('.gravatar').html(proImage).append('<div class="img-caption need-hover">' + captionW + '</div>').css('visibility', 'visible').hide().fadeIn(400);
	}

	// do dot loader
	function dotLoader() {
	  $lDots = $('.loading-dots');
	  setInterval(function(){
	    $dots = $lDots.text();
	    if($dots === '...') {
	      $lDots.text('.');
	    } else if($dots === '.') {
	      $lDots.text('..');
	    } else if($dots === '..') {
	      $lDots.text('...');
	    }
	  }, 400);
	}

});
