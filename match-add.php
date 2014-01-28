<?php
	$registered = 1;
	$title = 'Match - Add/Edit';
	include('template/header.php');
?>
	<div class="container">
		<div class="row row-offcanvas row-offcanvas-right">
			
			<div class="col-xs-12 col-sm-9">
				<p class="pull-right visible-xs">
					<button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle</button>
				</p>
				<h1 class="page-header">Add Match <small>(not yet working)</small></h1>
				<?php
				if($show_form){
					include_once('includes/database.php');
					$db = new Database($db_host, $db_name, $db_user, $db_pass);
					
					$players = $db->select('users', '*', '1="1"', 'object');
					if($players){
					?>
					<form class="form-add-match" role="form" action="<?php echo $base_url; ?>match-add.php" method="POST">
						<div class="form-group">
							<label class="col-sm-2 control-label">Player (Home)</label>
							<div class="col-sm-10">
								<select id="player1" class="form-control">
									<option>-select-</option>
									<?php foreach($players as $player){ ?>
									<option value="<?php echo $player->id; ?>"><?php echo $player->name; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						
						<p class="lead text-center">vs</p>
						
						<div class="form-group">
							<label class="col-sm-2 control-label">Player (Away)</label>
							<div class="col-sm-10">
								<select id="player2" class="form-control">
									<option>-select-</option>
									<?php foreach($players as $player){ ?>
									<option value="<?php echo $player->id; ?>"><?php echo $player->name; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
					</form>
					<?php
					} else {
					?>
						<p class="lead">There are no players in the database.</p>
					<?php
					}
				}
				?>
				
			</div><!--/span-->
			
			<?php include('template/sidebar.php'); ?>
			
		</div><!--/.row-->
	</div><!--/.container-->


<?php
	include('template/footer.php');
?>