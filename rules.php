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
						<strong>Slam Point</strong>
						<ul>
							<li>Is when a player makes contact with the ball, above their shoulders or with more than usual power behind the swing.</li>
						</ul>
					</li>
					<li>
						<strong>Foosball</strong>
						<ul>
							<li>Is when a player misses the ball completely, they might has well be playing foosball.</li>
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