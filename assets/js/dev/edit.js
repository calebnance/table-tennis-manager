$(document).ready(function(e){

	// limit text
	$('.limit-text').on('input', function(e){
		// get element
		$limitText = $(this);
		$formTypeCount = $limitText.next('div.form-type-count');
		// grab character limit
		var limitChar = parseInt($limitText.attr('data-limit-char'));
		// make sure it's an integer
		if(limitChar === parseInt(limitChar, 10)) {
			// what limit the input has
			limitChar = parseInt(limitChar);
		} else {
			// default limit here!
			limitChar = parseInt(24);
		}

		// is there a placeholder?
		if($formTypeCount.length) {
			limitChar = limitChar - $limitText.val().length;
			$formTypeCount.html(limitChar);
		}
	});

});
