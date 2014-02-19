$(document).ready(function(){
	var circliful_shown = false;
	$('.show-list-graph').on('click', function(e){
		$id = $(this).find('input').attr('id');
		if(!$('#standings-' + $id).is(':visible')){
			$('.list-graph').hide();
			$('#standings-' + $id).fadeIn(400);
		}
		if(circliful_shown == false){
			$('.circliful').circliful();
			circliful_shown = true;
		}
	});	
});