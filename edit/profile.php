<?php
	// Set page title
	$title = 'Edit Profile';

	// wat
	$root_path = '../';
	$dir_deep = 'edit';

	include('../template/header.php');
?>
	<div class="container">
		<div class="row row-offcanvas row-offcanvas-right">

			<div class="col-xs-12 col-sm-9">
				<p class="pull-right visible-xs">
					<button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle</button>
				</p>

				<h1 class="page-header"><?= $title; ?></h1>

				<?php
				/*
				Do a textarea limit, show the limit.
				*/
				?>

				<div class="clearfix"></div>

				<p class="lead">Coming Soon<span class="loading-dots">.</span></p>

			</div><!-- /.col-xs-12 -->

			<?php
			include('../template/sidebar.php');
			?>

		</div><!-- /.row -->
	</div><!-- /.container -->

<?php
	include('../template/footer.php');
