$(document).ready(function(){

	// check for gravatar
	if($('.gravatar').length && $('.gravatar').attr('data-email')){
		var emailGra = $('.gravatar').attr('data-email');
		var usernGra = $('.gravatar').attr('data-username');
		var checkImg = 'http://www.gravatar.com/avatar/' + emailGra + '?s=250';
		var hasImage = imageExists(checkImg);
		
		if(!hasImage){
			var checkImg = 'http://placekitten.com/g/250/250';
		}

		var proImage = $('<img>').attr({ src: checkImg, class: 'img-thumbnail' });
		$('.gravatar').html(proImage);
	}

});

function imageExists(image_url){
	var http = new XMLHttpRequest();
	http.open('HEAD', image_url, false);
	http.send();
	return http.status != 404;
}
