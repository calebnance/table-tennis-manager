<?php
	$title 			= 'Installation';
	$root_path  = '../';
	$dir_deep   = 'install';
	include('../template/header.php');
?>
	<div class="container">
		<div class="row row-offcanvas row-offcanvas-right">

			<div class="col-xs-12">
				<p class="pull-right visible-xs">
					<button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle</button>
				</p>
				<h1 class="page-header">Installation Wizard</h1>


			</div><!--/span-->

			<?php include($root_path . 'template/sidebar.php'); ?>

		</div><!--/.row-->
	</div><!--/.container-->

<?php
	include($root_path . 'template/footer.php');
?>
