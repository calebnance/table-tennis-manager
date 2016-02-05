$(document).ready(function(){
	$('.datepicker').datepicker({
		format: 'mm-dd-yyyy',
		onRender: function(date) {
			return date.getDay() == 1 ? '' : 'disabled';
		}
	});
});
