$(document).ready(function(){
	var viewLess = 'View Less Stats';
	var viewMore = 'View More Stats';

	// accordion stuff
	$('.more-stats').on('click', function(e){
		// if not shown, show it
		if($(this).hasClass('fa-plus-square')){
			$(this).removeClass('fa-plus-square').addClass('fa-minus-square').attr('data-original-title', viewLess);
			$(this).closest('tr').find('.more').slideDown();
		} else {
			$(this).removeClass('fa-minus-square').addClass('fa-plus-square').attr('data-original-title', viewMore);
			$(this).closest('tr').find('.more').slideUp();
		}
	});

	// open all stats
	$('.open-all').on('click', function(e){
		$('table .more').slideDown();
		$('table .more-stats').removeClass('fa-plus-square fa-minus-square').addClass('fa-minus-square').attr('data-original-title', viewLess);
	});

	// close all stats
	$('.close-all').on('click', function(e){
		$('table .more').slideUp();
		$('table .more-stats').removeClass('fa-plus-square fa-minus-square').addClass('fa-plus-square').attr('data-original-title', viewMore);
	});
});
