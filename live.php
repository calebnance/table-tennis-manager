<?php
	$title = 'Live Match';
	include('template/header-live.php');

	// Include page js
	$scripts[] = $js . 'live.js';

?>
	<div class="container">

		<div class="pull-right">
			<a href="<?php echo $base_url; ?>" class="btn btn-default">Return Home</a>
		</div>

		<h1 class="page-header">Live Match</h1>

		<div id="live-loader" class="jumbotron margin-b-0">
			Looking for a live match<div class="loading-dots">...</div>
		</div><!-- /#live-loader -->

		<div id="table-tennis" class="display-none">
			<div id="pong-ball"></div>
			<div id="center-stripe"></div>

			<div class="side pull-left">
				<div class="player">Player 1</div>
				<div class="score">9</div>
			</div><!-- /.side -->

			<div id="net" class="pull-left"></div><!-- /#net -->

			<div class="side pull-right">
				<div class="player">Player 2</div>
				<div class="score">4</div>
			</div><!-- /.side -->

			<div class="clearfix"></div>
		</div><!-- /#table-tennis -->

	</div><!-- /.container -->

<?php
	include('template/footer.php');
?>
