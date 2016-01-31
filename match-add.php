<?php
	if($_POST){
		// should be logged in.. but should check for it here.. ::TODO

		include_once('includes/config.php');
		include_once('includes/database.php');

		$db = new Database($db_host, $db_name, $db_user, $db_pass);

		// start a match, set up everything in database
		if(isset($_POST['type']) && $_POST['type'] == 'start'){

			// are the two players the same person?
			if(isset($_POST['player1']) && isset($_POST['player2']) && ($_POST['player1'] == $_POST['player2'] ) ){
				$res = array(
					'msg'		=> 'You have selected the same person for both, this can\'t be done..',
					'error'	=> 1,
				);
				echo json_encode($res);
				exit();
			}

			// match ref insert data
			$playerserves = 'player' . $_POST['playerserves'];
			$match_start = array(
				'player1'						=> $_POST['player1'],
				'player2'						=> $_POST['player2'],
				'serve_first'				=> $_POST[$playerserves],
				'date_time_started' => date('Y-m-d H:i:s'),
			);
			// insert data into match_ref
			$match_id = $db->insert('match_ref', $match_start);

			// ajax response
			$match_response = array(
				'match_id'			=> (int)$match_id,
				'player1'				=> (int)$_POST['player1'],
				'player2' 			=> (int)$_POST['player2'],
				'serve_first'		=> (int)$_POST[$playerserves],
				'skunk'					=> (int)$skunk,
				'pts_per_turn'	=> (int)$pts_per_turn,
				'pts_to_win'		=> (int)$pts_to_win,
				'type'					=> 'match',
				'error'					=> 0,
				'msg'						=> 'Match has been created!',
			);
			// sleep a little
			sleep(2);
			echo json_encode($match_response);
			exit();
		}

		// after match has been created, now we want to insert into the match_player table
		if(isset($_POST['type']) && $_POST['type'] == 'match'){
			session_start();

			$player1	= $db->select('users', 'username', 'id="' . (int)$_POST['player1'] . '"', 'object');
			$player2	= $db->select('users', 'username', 'id="' . (int)$_POST['player2'] . '"', 'object');

			$player1_create = array(
				'match_id'			=> (int)$_POST['match_id'],
				'player_id'			=> (int)$_POST['player1'],
				'date_created'	=> date('Y-m-d H:i:s'),
				'date_modified'	=> date('Y-m-d H:i:s'),
				'user_created'	=> (int)$_SESSION['uid'],
				'user_modified'	=> (int)$_SESSION['uid'],
			);
			$player2_create = array(
				'match_id'			=> (int)$_POST['match_id'],
				'player_id'			=> (int)$_POST['player2'],
				'date_created'	=> date('Y-m-d H:i:s'),
				'date_modified'	=> date('Y-m-d H:i:s'),
				'user_created'	=> (int)$_SESSION['uid'],
				'user_modified'	=> (int)$_SESSION['uid'],
			);

			$player1_match = $db->insert('match_player', $player1_create);
			$player2_match = $db->insert('match_player', $player2_create);

			$response = array(
				'match_options'	=> $_POST,
				'player1'				=> array(
					'match_player_id'	=> $player1_match,
					'info'						=> $player1_create,
					'username'				=> $player1[0]->username,
				),
				'player2'				=> array(
					'match_player_id'	=> $player2_match,
					'info'						=> $player2_create,
					'username'				=> $player2[0]->username,
				),
			);

			echo json_encode($response);
			exit();
		}

		// now we want to update the match_player table each autosave and final save goes here
		if(isset($_POST['type']) && $_POST['type'] == 'update'){
			//echo json_encode($_POST);
			$player1_update = array(
				'final_score'		=> (int)$_POST['score_1'],
				'aces'					=> (int)$_POST['aces_1'],
				'bad_serves'		=> (int)$_POST['bad_serve_1'],
				'frustration'		=> (int)$_POST['frustration_1'],
				'ones'					=> (int)$_POST['ones_1'],
				'feel_goods'		=> (int)$_POST['feel_goods_1'],
				'slams_missed'	=> (int)$_POST['slams_missed_1'],
				'slams_made'		=> (int)$_POST['slams_made_1'],
				'digs'					=> (int)$_POST['digs_1'],
				'foosball'			=> (int)$_POST['foosball_1'],
				'just_the_tip'	=> (int)$_POST['just_the_tip_1'],
				'fabulous'			=> (int)$_POST['fabulous_1'],
				'date_modified'	=> date('Y-m-d H:i:s')
			);
			$player2_update = array(
				'final_score'		=> (int)$_POST['score_2'],
				'aces'					=> (int)$_POST['aces_2'],
				'bad_serves'		=> (int)$_POST['bad_serve_2'],
				'frustration'		=> (int)$_POST['frustration_2'],
				'ones'					=> (int)$_POST['ones_2'],
				'feel_goods'		=> (int)$_POST['feel_goods_2'],
				'slams_missed'	=> (int)$_POST['slams_missed_2'],
				'slams_made'		=> (int)$_POST['slams_made_2'],
				'digs'					=> (int)$_POST['digs_2'],
				'foosball'			=> (int)$_POST['foosball_2'],
				'just_the_tip'	=> (int)$_POST['just_the_tip_2'],
				'fabulous'			=> (int)$_POST['fabulous_2'],
				'date_modified'	=> date('Y-m-d H:i:s')
			);

			$update_1 = $db->update('match_player', $player1_update, 'match_id="' . (int)$_POST['match_id'] .'" AND player_id="' . (int)$_POST['player1_id'] . '"');
			$update_2 = $db->update('match_player', $player2_update, 'match_id="' . (int)$_POST['match_id'] .'" AND player_id="' . (int)$_POST['player2_id'] . '"');

			$match_info				= $db->select('match_ref', 'date_time_started', 'id="' . (int)$_POST['match_id'] . '"', 'object');
			$match_start_time	= strtotime($match_info[0]->date_time_started);
			$current_time			= strtotime(date('Y-m-d H:i:s'));
			$time_stamp				= ($current_time - $match_start_time);
			$time_played			= date('i:s', $time_stamp);

			$match_update = array(
				'total_time' => '00:' . $time_played
			);
			$update_3 = $db->update('match_ref', $match_update, 'id="' . (int)$_POST['match_id'] .'"');

			$response = array(
				'post'				=> $_POST,
				'player_1'		=> $player1_update,
				'player_2'		=> $player2_update,
				'current'			=> date('Y-m-d H:i:s'),
				'stamp'				=> ($current_time - $match_start_time),
				'time_format'	=> $time_format
			);
			echo json_encode($response);
			exit();
		}
		exit();
	}

	$registered = 1;
	$title = 'Match - Add/Edit';
	include('template/header.php');

	include_once('includes/database.php');

	$db = new Database($db_host, $db_name, $db_user, $db_pass);
	$current_season = getCurrentSeason($db);

	// Include page js
	$scripts[] = $js . 'match-add.js';
?>
	<div class="container">
		<div class="row row-offcanvas row-offcanvas-right">

			<div class="col-xs-12 col-sm-9">
				<p class="pull-right visible-xs">
					<button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle</button>
				</p>
				<?php
				if($show_form){
				?>
				<h1 class="page-header">Add Match</h1>
					<?php
					// no seasons set up?
					if(empty($current_season)){
						include('template/msgs/noSeason.php');
					} else {
						$players = $db->select('users', 'id, username', '1="1"', 'object', '', '', 'username');
						if($players){
						?>
							<div id="match_wrapper">
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
											</div><!-- /.radio -->
										</div>
									</div><!-- /.form-group -->

									<div class="verses pull-left">vs</div>

									<div class="form-group player-area pull-left">
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
											</div><!-- /.radio -->
										</div>
									</div><!-- /.form-group -->

									<div class="clearfix"></div>

									<div class="btm-form">
										<a id="match-add" class="btn btn-lg btn-navy">Start Match</a>
									</div><!-- /.btm-form -->

									<input type="hidden" name="type" value="start" />

								</form>
								<?php
								// TODO: Make this database driven!
								// Extra TODO: have them add, edit attributes..
								?>
								<form id="match_created_form">
									<div id="player1-area" class="form-group player-area pull-left" data-id="1">
										<div id="player1-msg"></div><!-- /#player1-msg -->
										<label id="player1-label" data-player-id="0" class="control-label">Player 1</label>

										<div class="controls">
											<div class="lead pull-left">Score</div>
											<div class="pull-left">
												<input type="text" id="score_1" name="score_1" class="form-control counters scoring" placeholder="" value="0">
											</div><!-- /.pull-left -->
											<div class="btn-group pull-left">
												<div class="btn btn-navy btn-sm plus"><i class="glyphicon glyphicon-plus"></i></div>
												<div class="btn btn-default btn-sm minus"><i class="glyphicon glyphicon-minus"></i></div>
											</div><!-- /.btn-group -->
										</div><!-- /.controls -->

										<div class="clearfix"></div>

										<div class="controls">
											<div class="lead pull-left">Aces</div>
											<div class="pull-left">
												<input type="text" name="aces_1" class="form-control counters" placeholder="" value="0">
											</div><!-- /.pull-left -->
											<div class="btn-group pull-left">
												<div class="btn btn-navy btn-sm plus"><i class="glyphicon glyphicon-plus"></i></div>
												<div class="btn btn-default btn-sm minus"><i class="glyphicon glyphicon-minus"></i></div>
											</div><!-- /.btn-group -->
										</div><!-- /.controls -->

										<div class="clearfix"></div>

										<div class="controls">
											<div class="lead pull-left">Bad Serve</div>
											<div class="pull-left">
												<input type="text" name="bad_serve_1" class="form-control counters" placeholder="" value="0">
											</div><!-- /.pull-left -->
											<div class="btn-group pull-left">
												<div class="btn btn-navy btn-sm plus"><i class="glyphicon glyphicon-plus"></i></div>
												<div class="btn btn-default btn-sm minus"><i class="glyphicon glyphicon-minus"></i></div>
											</div><!-- /.btn-group -->
										</div><!-- /.controls -->

										<div class="clearfix"></div>

										<div class="controls">
											<div class="lead pull-left">Digs</div>
											<div class="pull-left">
												<input type="text" name="digs_1" class="form-control counters" placeholder="" value="0">
											</div><!-- /.pull-left -->
											<div class="btn-group pull-left">
												<div class="btn btn-navy btn-sm plus"><i class="glyphicon glyphicon-plus"></i></div>
												<div class="btn btn-default btn-sm minus"><i class="glyphicon glyphicon-minus"></i></div>
											</div><!-- /.btn-group -->
										</div><!-- /.controls -->

										<div class="clearfix"></div>

										<div class="controls">
											<div class="lead pull-left">Fabulous</div>
											<div class="pull-left">
												<input type="text" name="fabulous_1" class="form-control counters" placeholder="" value="0">
											</div><!-- /.pull-left -->
											<div class="btn-group pull-left">
												<div class="btn btn-navy btn-sm plus"><i class="glyphicon glyphicon-plus"></i></div>
												<div class="btn btn-default btn-sm minus"><i class="glyphicon glyphicon-minus"></i></div>
											</div><!-- /.btn-group -->
										</div><!-- /.controls -->

										<div class="clearfix"></div>

										<div class="controls">
											<div class="lead pull-left">Feel Goods</div>
											<div class="pull-left">
												<input type="text" name="feel_goods_1" class="form-control counters" placeholder="" value="0">
											</div><!-- /.pull-left -->
											<div class="btn-group pull-left">
												<div class="btn btn-navy btn-sm plus"><i class="glyphicon glyphicon-plus"></i></div>
												<div class="btn btn-default btn-sm minus"><i class="glyphicon glyphicon-minus"></i></div>
											</div><!-- /.btn-group -->
										</div><!-- /.controls -->

										<div class="clearfix"></div>

										<div class="controls">
											<div class="lead pull-left">Foosball</div>
											<div class="pull-left">
												<input type="text" name="foosball_1" class="form-control counters" placeholder="" value="0">
											</div>
											<div class="btn-group pull-left">
												<div class="btn btn-navy btn-sm plus"><i class="glyphicon glyphicon-plus"></i></div>
												<div class="btn btn-default btn-sm minus"><i class="glyphicon glyphicon-minus"></i></div>
											</div><!-- /.btn-group -->
										</div><!-- /.controls -->

										<div class="clearfix"></div>

										<div class="controls">
											<div class="lead pull-left">Frustration</div>
											<div class="pull-left">
												<input type="text" name="frustration_1" class="form-control counters" placeholder="" value="0">
											</div><!-- /.pull-left -->
											<div class="btn-group pull-left">
												<div class="btn btn-navy btn-sm plus"><i class="glyphicon glyphicon-plus"></i></div>
												<div class="btn btn-default btn-sm minus"><i class="glyphicon glyphicon-minus"></i></div>
											</div><!-- /.btn-group -->
										</div>

										<div class="clearfix"></div>

										<div class="controls">
											<div class="lead pull-left">Just The Tip</div>
											<div class="pull-left">
												<input type="text" name="just_the_tip_1" class="form-control counters" placeholder="" value="0">
											</div><!-- /.pull-left -->
											<div class="btn-group pull-left">
												<div class="btn btn-navy btn-sm plus"><i class="glyphicon glyphicon-plus"></i></div>
												<div class="btn btn-default btn-sm minus"><i class="glyphicon glyphicon-minus"></i></div>
											</div><!-- /.btn-group -->
										</div><!-- /.controls -->

										<div class="clearfix"></div>

										<div class="controls">
											<div class="lead pull-left">Ones</div>
											<div class="pull-left">
												<input type="text" name="ones_1" class="form-control counters" placeholder="" value="0">
											</div><!-- /.pull-left -->
											<div class="btn-group pull-left">
												<div class="btn btn-navy btn-sm plus"><i class="glyphicon glyphicon-plus"></i></div>
												<div class="btn btn-default btn-sm minus"><i class="glyphicon glyphicon-minus"></i></div>
											</div><!-- /.btn-group -->
										</div><!-- /.controls -->

										<div class="clearfix"></div>

										<div class="controls">
											<div class="lead pull-left">Slams Missed</div>
											<div class="pull-left">
												<input type="text" name="slams_missed_1" class="form-control counters" placeholder="" value="0">
											</div><!-- /.pull-left -->
											<div class="btn-group pull-left">
												<div class="btn btn-navy btn-sm plus"><i class="glyphicon glyphicon-plus"></i></div>
												<div class="btn btn-default btn-sm minus"><i class="glyphicon glyphicon-minus"></i></div>
											</div><!-- /.btn-group -->
										</div><!-- /.controls -->

										<div class="clearfix"></div>

										<div class="controls">
											<div class="lead pull-left">Slams Made</div>
											<div class="pull-left">
												<input type="text" name="slams_made_1" class="form-control counters" placeholder="" value="0">
											</div><!-- /.pull-left -->
											<div class="btn-group pull-left">
												<div class="btn btn-navy btn-sm plus"><i class="glyphicon glyphicon-plus"></i></div>
												<div class="btn btn-default btn-sm minus"><i class="glyphicon glyphicon-minus"></i></div>
											</div><!-- /.btn-group -->
										</div><!-- /.controls -->

										<div class="clearfix"></div>

									</div><!-- /#player1-area -->

									<div class="verses pull-left">vs</div>

									<div id="player2-area" class="form-group player-area pull-left" data-id="2">
										<div id="player2-msg"></div><!-- /#player2-msg -->
										<label id="player2-label" class="control-label">Player 2</label>

										<div class="controls">
											<div class="lead pull-left">Score</div>
											<div class="pull-left">
												<input type="text" id="score_2" name="score_2" class="form-control counters scoring" placeholder="" value="0">
											</div><!-- /.pull-left -->
											<div class="btn-group pull-left">
												<div class="btn btn-navy btn-sm plus"><i class="glyphicon glyphicon-plus"></i></div>
												<div class="btn btn-default btn-sm minus"><i class="glyphicon glyphicon-minus"></i></div>
											</div><!-- /.btn-group -->
										</div><!-- /.controls -->

										<div class="clearfix"></div>

										<div class="controls">
											<div class="lead pull-left">Aces</div>
											<div class="pull-left">
												<input type="text" name="aces_2" class="form-control counters" placeholder="" value="0">
											</div><!-- /.pull-left -->
											<div class="btn-group pull-left">
												<div class="btn btn-navy btn-sm plus"><i class="glyphicon glyphicon-plus"></i></div>
												<div class="btn btn-default btn-sm minus"><i class="glyphicon glyphicon-minus"></i></div>
											</div><!-- /.btn-group -->
										</div><!-- /.controls -->

										<div class="clearfix"></div>

										<div class="controls">
											<div class="lead pull-left">Bad Serve</div>
											<div class="pull-left">
												<input type="text" name="bad_serve_2" class="form-control counters" placeholder="" value="0">
											</div><!-- /.pull-left -->
											<div class="btn-group pull-left">
												<div class="btn btn-navy btn-sm plus"><i class="glyphicon glyphicon-plus"></i></div>
												<div class="btn btn-default btn-sm minus"><i class="glyphicon glyphicon-minus"></i></div>
											</div><!-- /.btn-group -->
										</div><!-- /.controls -->

										<div class="clearfix"></div>

										<div class="controls">
											<div class="lead pull-left">Digs</div>
											<div class="pull-left">
												<input type="text" name="digs_2" class="form-control counters" placeholder="" value="0">
											</div><!-- /.pull-left -->
											<div class="btn-group pull-left">
												<div class="btn btn-navy btn-sm plus"><i class="glyphicon glyphicon-plus"></i></div>
												<div class="btn btn-default btn-sm minus"><i class="glyphicon glyphicon-minus"></i></div>
											</div><!-- /.btn-group -->
										</div><!-- /.controls -->

										<div class="clearfix"></div>

										<div class="controls">
											<div class="lead pull-left">Fabulous</div>
											<div class="pull-left">
												<input type="text" name="fabulous_2" class="form-control counters" placeholder="" value="0">
											</div><!-- /.pull-left -->
											<div class="btn-group pull-left">
												<div class="btn btn-navy btn-sm plus"><i class="glyphicon glyphicon-plus"></i></div>
												<div class="btn btn-default btn-sm minus"><i class="glyphicon glyphicon-minus"></i></div>
											</div><!-- /.btn-group -->
										</div><!-- /.controls -->

										<div class="clearfix"></div>

										<div class="controls">
											<div class="lead pull-left">Feel Goods</div>
											<div class="pull-left">
												<input type="text" name="feel_goods_2" class="form-control counters" placeholder="" value="0">
											</div><!-- /.pull-left -->
											<div class="btn-group pull-left">
												<div class="btn btn-navy btn-sm plus"><i class="glyphicon glyphicon-plus"></i></div>
												<div class="btn btn-default btn-sm minus"><i class="glyphicon glyphicon-minus"></i></div>
											</div><!-- /.btn-group -->
										</div><!-- /.controls -->

										<div class="clearfix"></div>

										<div class="controls">
											<div class="lead pull-left">Foosball</div>
											<div class="pull-left">
												<input type="text" name="foosball_2" class="form-control counters" placeholder="" value="0">
											</div><!-- /.pull-left -->
											<div class="btn-group pull-left">
												<div class="btn btn-navy btn-sm plus"><i class="glyphicon glyphicon-plus"></i></div>
												<div class="btn btn-default btn-sm minus"><i class="glyphicon glyphicon-minus"></i></div>
											</div><!-- /.btn-group -->
										</div><!-- /.controls -->

										<div class="clearfix"></div>

										<div class="controls">
											<div class="lead pull-left">Frustration</div>
											<div class="pull-left">
												<input type="text" name="frustration_2" class="form-control counters" placeholder="" value="0">
											</div><!-- /.pull-left -->
											<div class="btn-group pull-left">
												<div class="btn btn-navy btn-sm plus"><i class="glyphicon glyphicon-plus"></i></div>
												<div class="btn btn-default btn-sm minus"><i class="glyphicon glyphicon-minus"></i></div>
											</div><!-- /.btn-group -->
										</div><!-- /.controls -->

										<div class="clearfix"></div>

										<div class="controls">
											<div class="lead pull-left">Just The Tip</div>
											<div class="pull-left">
												<input type="text" name="just_the_tip_2" class="form-control counters" placeholder="" value="0">
											</div><!-- /.pull-left -->
											<div class="btn-group pull-left">
												<div class="btn btn-navy btn-sm plus"><i class="glyphicon glyphicon-plus"></i></div>
												<div class="btn btn-default btn-sm minus"><i class="glyphicon glyphicon-minus"></i></div>
											</div><!-- /.btn-group -->
										</div><!-- /.controls -->

										<div class="clearfix"></div>

										<div class="controls">
											<div class="lead pull-left">Ones</div>
											<div class="pull-left">
												<input type="text" name="ones_2" class="form-control counters" placeholder="" value="0">
											</div><!-- /.pull-left -->
											<div class="btn-group pull-left">
												<div class="btn btn-navy btn-sm plus"><i class="glyphicon glyphicon-plus"></i></div>
												<div class="btn btn-default btn-sm minus"><i class="glyphicon glyphicon-minus"></i></div>
											</div><!-- /.btn-group -->
										</div><!-- /.controls -->

										<div class="clearfix"></div>

										<div class="controls">
											<div class="lead pull-left">Slams Missed</div>
											<div class="pull-left">
												<input type="text" name="slams_missed_2" class="form-control counters" placeholder="" value="0">
											</div><!-- /.pull-left -->
											<div class="btn-group pull-left">
												<div class="btn btn-navy btn-sm plus"><i class="glyphicon glyphicon-plus"></i></div>
												<div class="btn btn-default btn-sm minus"><i class="glyphicon glyphicon-minus"></i></div>
											</div><!-- /.btn-group -->
										</div><!-- /.controls -->

										<div class="clearfix"></div>

										<div class="controls">
											<div class="lead pull-left">Slams Made</div>
											<div class="pull-left">
												<input type="text" name="slams_made_2" class="form-control counters" placeholder="" value="0">
											</div><!-- /.pull-left -->
											<div class="btn-group pull-left">
												<div class="btn btn-navy btn-sm plus"><i class="glyphicon glyphicon-plus"></i></div>
												<div class="btn btn-default btn-sm minus"><i class="glyphicon glyphicon-minus"></i></div>
											</div><!-- /.btn-group -->
										</div><!-- /.controls -->

									</div><!-- /#player2-area -->

									<div class="clearfix"></div>

									<!-- post needed -->
									<input type="hidden" name="type" value="update" />
									<input type="hidden" id="player1_id" name="player1_id" value="" />
									<input type="hidden" id="player2_id" name="player2_id" value="" />
									<input type="hidden" id="match_id" name="match_id" value="" />
									<input type="hidden" id="serve_first" name="serve_first" value="" />

									<!-- js needed -->
									<input type="hidden" id="pts_per_turn" value="<?php echo $pts_per_turn; ?>" />
									<input type="hidden" id="pts_to_win" value="<?php echo $pts_to_win; ?>" />
									<input type="hidden" id="skunk" value="<?php echo $skunk; ?>" />

									<div id="match-updating" class="alert alert-warning pull-right">waiting</div>

									<div class="btm-form">
										<a id="match-complete" class="btn btn-lg btn-navy">Match Complete</a>
									</div><!-- /.btm-form -->

									<div class="clearfix"></div>
								</form>
							</div><!-- /#match_wrapper -->
						<?php
						} else {
						?>
							<p class="lead">There are no players in the database.</p>
						<?php
						}
					}
				}
				?>
			</div><!-- /.col-xs-12 -->

			<?php
			include('template/sidebar.php');
			?>

		</div><!-- /.row -->
	</div><!-- /.container -->

<?php
	include('template/footer.php');
?>
