<?php
	
	if($_POST){
		// should be logged in.. but should check for it here.. ::TODO
		
		include_once('includes/config.php');
		include_once('includes/database.php');
		$db = new Database($db_host, $db_name, $db_user, $db_pass);
		
		// start a match, set up everything in database
		if(isset($_POST['type']) && $_POST['type'] == 'start'){
			$playerserves = 'player' . $_POST['playerserves'];
			$match_start = array(
				'player1' => $_POST['player1'],
				'player2' => $_POST['player2'],
				'serve_first' => $_POST[$playerserves],
				'date_time_started' => date('Y-m-d H:i:s')
			);
			
			$match_id = $db->insert('match_ref', $match_start);
			
			$match_response = array(
				'match_id'		=> (int)$match_id,
				'player1'		=> (int)$_POST['player1'],
				'player2' 		=> (int)$_POST['player2'],
				'serve_first'	=> (int)$_POST[$playerserves],
				'skunk'			=> (int)$skunk,
				'pts_per_turn'	=> (int)$pts_per_turn,
				'pts_to_win'	=> (int)$pts_to_win,
				'type'			=> 'match'
			);
			
			sleep(2);
			
			echo json_encode($match_response);
		}
		if(isset($_POST['type']) && $_POST['type'] == 'match'){
			session_start();
			
			sleep(2);
			
			$player1_create = array(
				'match_id'		=> (int)$_POST['match_id'],
				'player_id'		=> (int)$_POST['player1'],
				'date_created'	=> date('Y-m-d H:i:s'),
				'date_modified'	=> date('Y-m-d H:i:s'),
				'user_created'	=> (int)$_SESSION['uid'],
				'user_modified'	=> (int)$_SESSION['uid']
			);
			$player2_create = array(
				'match_id'		=> (int)$_POST['match_id'],
				'player_id'		=> (int)$_POST['player2'],
				'date_created'	=> date('Y-m-d H:i:s'),
				'date_modified'	=> date('Y-m-d H:i:s'),
				'user_created'	=> (int)$_SESSION['uid'],
				'user_modified'	=> (int)$_SESSION['uid']
			);
			
			$player1_match = $db->insert('match_player', $player1_create);
			$player2_match = $db->insert('match_player', $player2_create);
			
			$response = array(
				'match_options'	=> $_POST,
				'player1'		=> array(
					'match_player_id'	=> $player1_match,
					'info'				=> $player1_create
				),
				'player2'		=> array(
					'match_player_id'	=> $player2_match,
					'info'				=> $player2_create
				)
			);
			
			echo json_encode($response);
		}
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
					
					$players = $db->select('users', 'id, username', '1="1"', 'object', '', '', 'username');
					if($players){
					?>
					<form id="match_add_form" role="form" action="<?php echo $base_url; ?>match-add.php" method="POST">
					
						<div class="form-group player-area pull-left">
							<label class="control-label">Player 1</label>
							<div>
								<select id="player1" name="player1" class="form-control required">
									<option value="">-select-</option>
									<?php foreach($players as $player){ ?>
									<option value="<?php echo $player->id; ?>"><?php echo $player->username; ?></option>
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
									<option value="<?php echo $player->id; ?>"><?php echo $player->username; ?></option>
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
						
						<input type="hidden" name="type" value="start" />
						
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