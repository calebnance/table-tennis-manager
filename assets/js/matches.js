$(document).ready(function(){
	$('.more-stats').on('click', function(e){
		// if not shown, show it
		if($(this).hasClass('fa-plus-square')){
			$(this).removeClass('fa-plus-square').addClass('fa-minus-square').attr('data-original-title', 'View Less Stats');
			$(this).closest('tr').find('.more').slideDown(400);
		} else {
			$(this).removeClass('fa-minus-square').addClass('fa-plus-square').attr('data-original-title', 'View More Stats');
			$(this).closest('tr').find('.more').slideUp(400);
		}
	});
});
