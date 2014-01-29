<?php
	
	if($_POST){
		include_once('includes/config.php');
		include_once('includes/database.php');
		$db = new Database($db_host, $db_name, $db_user, $db_pass);
		
		echo json_encode($_POST);
		exit();
	}

	$registered = 1;
	$title = 'Match - Add/Edit';
	include('template/header.php');
	
	// Include page js
	$scripts[] = $js . 'match-add.js';
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
					<form id="match_add_form" role="form" action="<?php echo $base_url; ?>match-add.php" method="POST">
					
						<div class="form-group player-area pull-left">
							<label class="control-label">Player 1</label>
							<div>
								<select id="player1" name="player1" class="form-control required">
									<option value="">-select-</option>
									<?php foreach($players as $player){ ?>
									<option value="<?php echo $player->id; ?>"><?php echo $player->name; ?></option>
									<?php } ?>
								</select>
								<div class="radio">
									<label>
										<input type="radio" name="playerserves" id="playerserves1" value="1" checked>
										Serves First
									</label>
								</div>
							</div>
						</div>
						
						<div class="verses pull-left">vs</div>
						
						<div class="form-group player-area pull-left ">
							<label class="control-label">Player 2</label>
							<div>
								<select id="player2" name="player2" class="form-control required">
									<option value="">-select-</option>
									<?php foreach($players as $player){ ?>
									<option value="<?php echo $player->id; ?>"><?php echo $player->name; ?></option>
									<?php } ?>
								</select>
								<div class="radio">
									<label>
										<input type="radio" name="playerserves" id="playerserves2" value="2">
										Serves First
									</label>
								</div>
							</div>
						</div>
						
						<div class="clearfix"></div>
						
						<div class="btm-form">
							<a id="match-add" class="btn btn-lg btn-navy" >Start Match</a>
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