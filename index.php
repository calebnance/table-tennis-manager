<?php	
	include('template/header.php');
?>
	<div class="container">
		<div class="row row-offcanvas row-offcanvas-right">
			
			<div class="col-xs-12 col-sm-9">
				<p class="pull-right visible-xs">
					<button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle</button>
				</p>

				<div class="jumbotron">
					<h1>Welcome</h1>
					<a href="create-account.php" class="btn btn-default btn-lg"><span class="glyphicon glyphicon-pencil"></span> Create Account</a>
					<a href="#" id="login-button" class="btn btn-default btn-lg"><span class="glyphicon glyphicon-user"></span> Login</a>
				</div><!-- /.jumbotron -->
				
			</div><!--/span-->
			
			<?php include('template/sidebar.php'); ?>
			
		</div><!--/.row-->
	</div><!--/.container-->


<?php
	include('template/footer.php');
?>