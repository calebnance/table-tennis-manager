<?php
	$title = 'Login';
	include('template/header.php');
	
	if($_POST){
		print_r($_POST);
	}
?>
	<div class="container">
		<div class="row row-offcanvas row-offcanvas-right">
			
			<div class="col-xs-12 col-sm-9">
				<p class="pull-right visible-xs">
					<button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle</button>
				</p>
				<h1 class="page-header">Login</h1>
				
				
			</div><!--/span-->
			
			<?php include('template/sidebar.php'); ?>
			
		</div><!--/.row-->
	</div><!--/.container-->


<?php
	include('template/footer.php');
?>