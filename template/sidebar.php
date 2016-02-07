<?php
if($current_page != 'wizard.php') {
?>
<div id="sidebar" class="col-xs-6 col-sm-3 sidebar-offcanvas" role="navigation">

	<?php
	if($_SESSION && $_SESSION['loggedin'] == 1){
	?>
	<div class="panel panel-navy">

		<div class="panel-heading">
			<h3 class="panel-title">Hi <?php echo $_SESSION['name'];?>!</h3>
		</div><!-- /.panel-heading -->

		<div class="panel-body">
			<ul class="nav nav-pills nav-stacked">
				<li <?php echo isCurrentPage($current_page, 'profile.php'); ?>>
					<a href="<?php echo $base_url; ?>profile.php"><i class="fa fa-user"></i> Profile</a>
				</li>
				<li>
					<div class="text-center text-muted">
						Last Login: <?php echo date('m-d-Y g:ha', strtotime($_SESSION['last_login'])); ?>
					</div><!-- /.text-right -->
				</li>
			<?php
			if($_SESSION['is_admin'] == 1){
			?>
			<li>
				<hr />
				<strong>Admin Access</strong>
			</li>
			<li <?php echo isCurrentPage($current_page, 'start-season.php'); ?>>
					<a href="<?php echo $base_url; ?>start-season.php"><span class="fa fa-bolt"></span> Start Seasons</a>
			</li>
			<li <?php echo isCurrentPage($current_page, 'match-add.php'); ?>>
				<a href="<?php echo $base_url; ?>match-add.php"><span class="fa fa-plus"></span> Start Match</a>
			</li>
			<li <?php echo isCurrentPage($current_page, 'users.php'); ?>>
				<a href="<?php echo $base_url; ?>users.php"><span class="fa fa-users"></span> Users List</a>
			</li>
			<?php
			}
			?>
			</ul>
		</div><!-- /.panel-body -->
	</div><!-- /.panel -->
	<?php
	}
	/*
	<div class="list-group">
		<a href="#" class="list-group-item active">User #1 <span class="badge pull-right">42</span></a>
		<a href="#" class="list-group-item">User #2 <span class="badge pull-right">42</span></a>
		<a href="#" class="list-group-item">User #3</a>
	</div><!-- /.list-group -->
	*/
	?>

	<div class="panel panel-navy">
		<div class="panel-heading">
			<h3 class="panel-title">Matches</h3>
		</div><!-- /.panle-heading -->

		<div class="panel-body">
			<ul class="nav nav-pills nav-stacked">
				<li <?php echo isCurrentPage($current_page, 'standings.php'); ?>>
					<a href="<?php echo $base_url; ?>standings.php"><span class="fa fa-signal"></span> Current Standings</a>
				</li>
				<li>
					<a href="<?php echo $base_url; ?>live.php"><span class="fa fa-play"></span> Watch Live</a>
				</li>
				<li <?php echo isCurrentPage($current_page, 'matches.php'); ?>>
					<a href="<?php echo $base_url; ?>matches.php"><span class="fa fa-list"></span> View Matches</a>
				</li>
				<?php
				/*
				<li <?php echo isCurrentPage($current_page, 'graphs.php'); ?>>
					<a href="<?php echo $base_url; ?>graphs.php"><span class="fa fa-bar-chart"></span> View Graphs</a>
				</li>
				*/
				?>
		</div><!-- /.panel-body -->
		<?php
		/*
		<div class="panel-footer">footer area</div>
		*/
		?>
	</div><!-- /.panel -->

</div><!-- /#sidebar -->
<?php
}
?>
