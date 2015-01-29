<?php
	$title = 'My Profile';
	include('template/header.php');
?>
	<div class="container">
		<div class="row row-offcanvas row-offcanvas-right">

			<div class="col-xs-12 col-sm-9">
				<p class="pull-right visible-xs">
					<button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle</button>
				</p>
				<h1 class="page-header">My Profile</h1>

				<div class="gravatar" data-email="<?php echo md5($_SESSION['email']); ?>" data-username="<?php echo $_SESSION['name']; ?>"></div><!-- /.gravatar -->

			</div><!--/span-->

			<?php include('template/sidebar.php'); ?>

		</div><!--/.row-->
	</div><!--/.container-->


<?php
	include('template/footer.php');
?>