$(document).ready(function(){

	/**
	 * init
	 */
	// check for gravatar
	if($('.gravatar').length && $('.gravatar').attr('data-email')){
		// parse through all the gravatars on the page
		$.each($('.gravatar'), function(g, grav){
			// grab user md5 hash from e-mail address
			var emailGra = $(grav).attr('data-email');
			// grab username for no apparent reason
			var usernGra = $(grav).attr('data-username');
			// gravatar json url set
			var gravaUrl = 'https://en.gravatar.com/' + emailGra + '.json';
			// get path
			var pathName = window.location.pathname;
			// are we on users page?
			var smallImg = false;
			if(pathName == '/users.php') {
				smallImg = true;
			}
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
					showGravatarOrNah(grav, imgGrava, captionW, smallImg);
				}
			}).fail(function(jqXHR, textStatus, errorThrown){
				// something went wrong wif this
				//console.log('error with gravatar user look-up');
				var imgGrava = 'http://placekitten.com/g/250/250';
				var captionW = 'You Need A <a href="http://www.gravatar.com" target="_blank">Gravatar</a> Account..';
				// gravatar nah
				showGravatarOrNah(grav, imgGrava, captionW, smallImg);
			});
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
	function showGravatarOrNah(grav, imgGrava, captionW, smallImg) {
		var addClass = '';
		var textToAppend = '<div class="img-caption need-hover">' + captionW + '</div>';
		// if small img
		if(smallImg) {
			addClass = ' width-50';
			textToAppend = '';
		}
		// set image
		var proImage = $('<img>').attr({ src: imgGrava, class: 'img-thumbnail' + addClass });
		// boom
		$(grav).html(proImage).append(textToAppend).css('visibility', 'visible').hide().fadeIn(400);
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
