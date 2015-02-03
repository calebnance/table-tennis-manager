<?php
if($current_page != 'wizard.php') {
?>
<div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar" role="navigation">

	<div class="panel panel-navy">

		<div class="panel-heading">
			<h3 class="panel-title">Matches</h3>
		</div><!-- /.panle-heading -->

		<div class="panel-body">
			<?php
			if($_SESSION && $_SESSION['loggedin'] == 1 && $_SESSION['is_admin'] == 1){
			?>
			<a href="<?php echo $base_url; ?>match-add.php" class="btn btn-primary btn-sm pull-left"><span class="glyphicon glyphicon-plus"></span> Add Match</a>
			<?php
			}
			?>
			<a href="<?php echo $base_url; ?>matches.php" class="btn btn-default btn-sm pull-left"><span class="glyphicon glyphicon-list"></span> View Matches</a>
			<a href="<?php echo $base_url; ?>live.php" class="btn btn-success btn-sm pull-left"><span class="glyphicon glyphicon-play"></span> Watch Live</a>
			<a href="<?php echo $base_url; ?>graphs.php" class="btn btn-warning btn-sm pull-left"><span class="glyphicon glyphicon-signal"></span> View Graphs</a>
			<div class="clearfix"></div>
		</div><!-- /.panel-body -->
		<?php
		/*
		<div class="panel-footer">footer area</div>
		*/
		?>
	</div><!-- /.panel -->
	<?php
	/*
	<div class="list-group">
		<a href="#" class="list-group-item active">User #1 <span class="badge pull-right">42</span></a>
		<a href="#" class="list-group-item">User #2 <span class="badge pull-right">42</span></a>
		<a href="#" class="list-group-item">User #3</a>
	</div><!-- /.list-group -->
	*/
	?>
</div><!-- /#sidebar -->
<?php
}
?>
