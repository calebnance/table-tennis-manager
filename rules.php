<?php
	$title = 'Rules';
	include('template/header.php');

	$addS	= $weeks == 1 ? '' : 's';
?>
	<div class="container">
		<div class="row row-offcanvas row-offcanvas-right">

			<div class="col-xs-12 col-sm-9">
				<p class="pull-right visible-xs">
					<button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle</button>
				</p>
				<h1 class="page-header">Rules &amp; Definitions</h1>


				<h3>Rules</h3>
				<ul>
					<li>This is a singles play setup.</li>
					<li>Points to win the match has been set to <span class="label label-primary"><?php echo $pts_to_win; ?> points</span>.</li>
					<li>Service change is every <span class="label label-primary"><?php echo $pts_per_turn; ?> points</span>.</li>
					<li>A player can win a match by skunk, the player must get to <span class="label label-primary"><?php echo $skunk; ?> points</span> before the opponent scores a single point.</li>
					<li>You must win by 2 points.</li>
					<li>Seasons are <span class="label label-primary"><?php echo $weeks; ?> week<?php echo $addS; ?></span> long.</li>
				</ul>

				<h3>Definitions</h3>
				<ul>
					<li>
						<strong>Aces</strong>
						<ul>
							<li>Is when a player gains a point on a serve, where the opponent can not make a valid hit back to the other side of the table.</li>
						</ul>
					</li>
					<li>
						<strong>Bad Serve</strong>
						<ul>
							<li>Is when a player does not hit his side of the table first on a serve, gets the ball over the net without touching it and hits the other side of the table.</li>
						</ul>
					</li>
					<li>
						<strong>Frustration</strong>
						<ul>
							<li>Is when a player hits the ball out of viewable frustration, and does not hit the other side of the table, or make a valid return.</li>
						</ul>
					</li>
					<li>
						<strong>Ones</strong>
						<ul>
							<li>Is when a player makes a valid return (not on a serve), and hits the egde of the table, causing the ball to bounce off the table at a different angle.</li>
						</ul>
					</li>
					<li>
						<strong>Feel Goods</strong>
						<ul>
							<li>Is when a player makes a valid return (not on a serve), and hits the top of the net, resulting in the ball landing on the opponents side, un-returnable.</li>
						</ul>
					</li>
					<li>
						<strong>Slam Points</strong>
						<ul>
							<li><strong>Slam Made</strong></li>
							<li>Is when a player makes contact with the ball, above their shoulders or with more than usual power behind the swing, and makes a valid return of the ball.</li>
							<li><strong>Slam Missed</strong></li>
							<li>Is when a player makes contact with the ball, above their shoulders or with more than usual power behind the swing, and <strong>does not</strong> makes a valid return of the ball.</li>
						</ul>
					</li>
					<li>
						<strong>Foosball</strong>
						<ul>
							<li>Is when a player misses the ball completely, they might has well be playing foosball.</li>
						</ul>
					</li>
					<li>
						<strong>Digs</strong>
						<ul>
							<li>Is when a player makes a valid return, from having to go to an extreme left or right and/or also "digging" the ball up, from underneath the table level.</li>
						</ul>
					</li>
				</ul>

			</div><!--/span-->

			<?php include('template/sidebar.php'); ?>

		</div><!--/.row-->
	</div><!--/.container-->


<?php
	include('template/footer.php');
?>
