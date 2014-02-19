$(document).ready(function(){
	$('.show-list-graph').on('click', function(e){
		$id = $(this).find('input').attr('id');
		if(!$('#standings-' + $id).is(':visible')){
			$('.list-graph').hide();
			$('#standings-' + $id).fadeIn(400);
		}
	});
	
	$('.circliful').circliful();	
});