<?php
	// Set page title
	$title = 'Edit Profile';

	// wat
	$root_path = '../';
	$dir_deep = 'edit';

	include('../template/header.php');

	// Include page js
	// are we in dev or prod?
	if(DEBUG) {
		$scripts[] = $js . 'dev/edit.js?v=' . $version;
	} else {
		$scripts[] = $js . 'edit.min.js?v=' . $version;
	}
?>
	<div class="container">
		<div class="row row-offcanvas row-offcanvas-right">

			<div class="col-xs-12 col-sm-9">
				<p class="pull-right visible-xs">
					<button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle</button>
				</p>

				<h1 class="page-header"><?= $title; ?></h1>
				<div class="clearfix"></div>

				<p class="lead">Coming Soon<span class="loading-dots">.</span></p>

				<?php
				/*
				Do a textarea limit, show the limit.
				*/
				?>
				<div class="form-element-wrapper margin-b-20">
					<textarea class="form-control no-resize limit-text" rows="4" data-limit-char="180"></textarea>
					<div class="form-type-count">0</div><!-- /.form-type-count -->
				</div><!-- /.form-element-wrapper -->

				<div class="well">
					<div class="btn-group">
						<button class="btn btn-default">Cancel</button>
						<button class="btn btn-success">Save</button>
					</div><!-- /.btn-group -->
				</div><!-- /.well -->

			</div><!-- /.col-xs-12 -->

			<?php
			include('../template/sidebar.php');
			?>

		</div><!-- /.row -->
	</div><!-- /.container -->

<?php
	include('../template/footer.php');
