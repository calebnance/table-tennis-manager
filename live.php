<?php
	$title = 'Live Match';
	include('template/header-live.php');

	// Include page js
	$scripts[] = $js . 'live.js';

?>
	<div class="container">

		<div class="pull-right">
			<a href="<?php echo $base_url; ?>" class="btn btn-default">Return Home</a>
		</div><!-- /.pull-right -->

		<h1 class="page-header">
			Live Match
			<small id="time" class="display-none">
				Match Time:
				<span class="hours">00</span>:<span class="minutes">00</span>:<span class="seconds">00</span>
			</small>
		</h1>

		<div id="live-loader" class="jumbotron margin-b-0">
			<div id="live-checker">
				<i class="fa fa-refresh"></i> Retry
			</div><!-- /#live-checker -->
			<div id="live-loader-text">
				Looking for a live match<div class="loading-dots">...</div>
			</div><!-- /#live-loader-text -->
		</div><!-- /#live-loader -->

		<div id="table-tennis" class="display-none">
			<div id="pong-ball"></div>
			<div id="center-stripe"></div>

			<div id="player1" class="side pull-left">
				<div class="player"></div>
				<div class="score">0</div>
				<div class="player-msg"></div>
			</div><!-- /#player1 -->

			<div id="net" class="pull-left"></div><!-- /#net -->

			<div id="player2" class="side pull-right">
				<div class="player"></div>
				<div class="score">0</div>
				<div class="player-msg"></div>
			</div><!-- /#player2 -->

			<div class="clearfix"></div>
		</div><!-- /#table-tennis -->

	</div><!-- /.container -->

<?php
	include('template/footer.php');
?>
