<?php
	$title = 'Live Match';
	include('template/header-live.php');
?>
	<div class="container">
		
		<div class="pull-right">
			<a href="<?php echo $base_url; ?>" class="btn btn-default">Return Home</a>
		</div>
		
		<h1 class="page-header">Live Match <small>(not yet working)</small></h1>
		
		<div id="table-tennis">
			<div id="center-stripe"></div>
			<div class="side pull-left">
				<div class="player">Bob Weston</div>
			</div>
			
			<div id="net" class="pull-left"></div><!-- /#net -->
			
			<div class="side pull-right">
				<div class="player">Ryan Andrews</div>
			</div>
			<div class="clearfix"></div>
		</div><!-- /#table-tennis -->
				
	</div><!--/.container-->


<?php
	include('template/footer.php');
?>