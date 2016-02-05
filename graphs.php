<?php
	$title = 'Graphs';

	// Include page css
	// are we in dev or prod?
	if(DEBUG) {
		$page_styles[] = $css . 'dev/jquery.circliful.css';
	} else {
		$page_styles[] = $css . 'jquery.circliful.min.css';
	}

	include('template/header.php');

	// Include page js
	$scripts[] = $js . 'jquery.circliful.min.js';
	// are we in dev or prod?
	if(DEBUG) {
		$scripts[] = $js . 'dev/graphs.js';
	} else {
		$scripts[] = $js . 'graphs.min.js';
	}
?>
	<div class="container">
		<div class="row row-offcanvas row-offcanvas-right">

			<div class="col-xs-12 col-sm-9">
				<p class="pull-right visible-xs">
					<button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle</button>
				</p>
				<h1 class="page-header">Graphs <small>(not yet working)</small></h1>
				<div id="myStat" class="circliful" data-dimension="250" data-text="35%" data-info="Something" data-width="30" data-fontsize="38" data-percent="35" data-fgcolor="#61A9DC" data-bgcolor="#EEEEEE" data-fill="#DDDDDD"></div>
			</div><!-- /.col-xs-12 -->

			<?php
			include('template/sidebar.php');
			?>

		</div><!-- /.row -->
	</div><!-- /.container -->

<?php
	include('template/footer.php');
?>
