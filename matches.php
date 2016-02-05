<?php
	$title = 'Matches';
	include('template/header.php');

	// Include page js
	// are we in dev or prod?
	if(DEBUG) {
		$scripts[] = $js . 'dev/matches.js';
	} else {
		$scripts[] = $js . 'matches.min.js';
	}

	include_once('includes/database.php');

	// Display errors on localhost
	$whitelist = array('localhost');
	if(!in_array($_SERVER['SERVER_NAME'], $whitelist)){
		//this is localhost!
		ini_set('display_errors', 1);
		//error_reporting(E_ALL);
		error_reporting(E_ALL ^ E_NOTICE);
	}

	$db	= new Database($db_host, $db_name, $db_user, $db_pass);
	$players = setKeyDBData($db->select('users', 'id, username', '1="1"', 'object', '', '', 'username'), 'id');
	foreach($players as $player_id => $player){
		$players[$player_id]->win			= 0;
		$players[$player_id]->lose			= 0;
		$players[$player_id]->percentage	= 0;
	}
	$set_season = 0;
	if($_GET['season']){
		$set_season = $_GET['season'];
	}

	$seasons = getSeasons($db);
	if($set_season){
		$current_season	= getSeasonByNumYear($set_season, date('Y'), $db);
	} else {
		$current_season	= getCurrentSeason($db);
	}
	$current_season_matches	= getSeasonMatches($current_season->start, $current_season->end, $db);
?>
	<div class="container">
		<div class="row row-offcanvas row-offcanvas-right">

			<div class="col-xs-12 col-sm-9">
				<p class="pull-right visible-xs">
					<button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle</button>
				</p>
				<h1 class="page-header">Matches</h1>

				<?php
				// are there users in the database?
				if($players && $current_season){
				?>

				<form class="filter-area form-inline">
					<select name="season" class="form-control margin-b-10">
						<option>Select Season</option>
						<?php
						foreach($seasons as $select_season){
							$selected = $current_season->season_number == $select_season->season_number ? ' selected' : '';
							?>
							<option value="<?php echo $select_season->season_number; ?>" <?php echo $selected; ?>>
								Season #<?php echo $select_season->season_number; ?> (<?php echo date('m-d-Y', strtotime($select_season->start)); ?> - <?php echo date('m-d-Y', strtotime($select_season->end)); ?>)
							</option>
							<?php
						}
						?>
					</select>
					<button type="submit" class="btn btn-primary margin-b-10">Submit</button>
				</form><!-- /.filter-area -->

				<div class="margin-b-10">
					<i class="fa fa-plus-square fa-lg open-all" data-toggle="tooltip" data-placement="top" data-original-title="Open All Stats"></i>
					<i class="fa fa-minus-square fa-lg close-all" data-toggle="tooltip" data-placement="top" data-original-title="Close All Stats"></i>
					Open / Close
				</div><!-- /.margin-b-10 -->

				<div class="table-responsive">
					<table class="table table-striped">
						<thead>
							<tr>
								<th class="width-20"></th>
								<th class="text-right width-200">Player 1</th>
								<th class="width-20"></th>
								<th class="text-left width-200">Player 2</th>
							</tr>
						</thead>
						<tbody>
						<?php
						//print_r($current_season_matches);
						if($current_season_matches){
							foreach($current_season_matches as $season_match){
								$match_scores	= $db->select('match_player', '*', 'match_id="' . $season_match->id . '"', 'object');
								$match_player1	= $match_scores[0];
								$match_player2	= $match_scores[1];
								$winner_1		= $match_player1->final_score > $match_player2->final_score ? ' success' : '';
								$winner_2		= $match_player2->final_score > $match_player1->final_score ? ' success' : '';

								$winner_1_b	= $match_player1->final_score > $match_player2->final_score ? 'success' : 'default';
								$winner_2_b	= $match_player2->final_score > $match_player1->final_score ? 'success' : 'default';

								$served_1		= $season_match->serve_first == $season_match->player1 ? '<strong>Served First</strong>' : '&nbsp;';
								$served_2		= $season_match->serve_first == $season_match->player2 ? '<strong>Served First</strong>' : '&nbsp;';
								$date				= date('m-d-Y H:i:sa', strtotime($season_match->date_time_started));
								$total_time = explode(':', $season_match->total_time);
								// add ssss
								$addSh = $addSm = $addSs = '';
								if(ltrim($total_time[0], '0') != 1){
									$addSh = 's';
								}
								if(ltrim($total_time[1], '0') != 1){
									$addSm = 's';
								}
								if(ltrim($total_time[2], '0') != 1){
									$addSs = 's';
								}
								// if hours and minutes are empty.
								if ($total_time[0] == 0 && $total_time[1] == 0) {
									$dis_time = ltrim($total_time[2], '0') . ' second' . $addSs;
								} elseif($total_time[0] == 0) {
									$dis_time = ltrim($total_time[1], '0') . ' minute' . $addSm . ', ' . ltrim($total_time[2], '0') . ' second' . $addSs;
								} else {
									$dis_time = ltrim($total_time[0], '0') . 'hour' . $addSh . ', ' . ltrim($total_time[1], '0') . ' minute' . $addSm . ', ' . ltrim($total_time[2], '0') . ' second' . $addSs;
								}
								// wat? why even is this here?
								if(($match_player1->final_score != $match_player2->final_score) && ($match_player1->final_score > 0 || $match_player2->final_score > 0)){
								?>
								<tr>
									<td class="text-center">
										<i class="fa fa-plus-square more-stats" data-toggle="tooltip" data-placement="right" data-original-title="View More Stats"></i>
									</td>
									<td class="text-right<?php echo $winner_1; ?>">
										<?php echo $players[$season_match->player1]->username; ?> <span class="label label-<?php echo $winner_1_b;?>"><?php echo sprintf("%02s", $match_player1->final_score); ?></span>
										<div class="more display-none">
											<p class="margin-b-0 margin-t-5"><?php echo $served_1; ?></p>
											<p>Started At - <strong><?php echo $date; ?></strong></p>
											<p class="margin-b-0">Aces - <?php echo $match_player1->aces; ?></p>
											<p class="margin-b-0">Bad Serves - <?php echo $match_player1->bad_serves; ?></p>
											<p class="margin-b-0">Frustration - <?php echo $match_player1->frustration; ?></p>
											<p class="margin-b-0">Ones - <?php echo $match_player1->ones; ?></p>
											<p class="margin-b-0">Feel Goods - <?php echo $match_player1->feel_goods; ?></p>
											<p class="margin-b-0">Slams Missed - <?php echo $match_player1->slams_missed; ?></p>
											<p class="margin-b-0">Slams Made - <?php echo $match_player1->slams_made; ?></p>
											<p class="margin-b-0">Foosball - <?php echo $match_player1->foosball; ?></p>
											<p class="margin-b-0">Digs - <?php echo $match_player1->digs; ?></p>
											<p class="margin-b-0">Just the Tip - <?php echo $match_player1->just_the_tip; ?></p>
											<p class="margin-b-0">Fabulous - <?php echo $match_player1->fabulous; ?></p>
										</div><!-- /.more -->
									</td>
									<td class="text-center border-left-right">vs</td>
									<td class="text-left<?php echo $winner_2; ?>">
										<span class="label label-<?php echo $winner_2_b;?>"><?php echo sprintf("%02s", $match_player2->final_score); ?></span> <?php echo $players[$season_match->player2]->username; ?>
										<div class="more display-none">
											<p class="margin-b-0 margin-t-5"><?php echo $served_2; ?></p>
											<p>Total Time - <strong><?php echo $dis_time; ?></strong></p>
											<p class="margin-b-0"><?php echo $match_player2->aces; ?> - Aces</p>
											<p class="margin-b-0"><?php echo $match_player2->bad_serves; ?> - Bad Serves</p>
											<p class="margin-b-0"><?php echo $match_player2->frustration; ?> - Frustration</p>
											<p class="margin-b-0"><?php echo $match_player2->ones; ?> - Ones</p>
											<p class="margin-b-0"><?php echo $match_player2->feel_goods; ?> - Feel Goods</p>
											<p class="margin-b-0"><?php echo $match_player2->slams_missed; ?> - Slams Missed</p>
											<p class="margin-b-0"><?php echo $match_player2->slams_made; ?> - Slams Made</p>
											<p class="margin-b-0"><?php echo $match_player2->foosball; ?> - Foosball</p>
											<p class="margin-b-0"><?php echo $match_player2->digs; ?> - Digs</p>
											<p class="margin-b-0"><?php echo $match_player2->just_the_tip; ?> - Just the Tip</p>
											<p class="margin-b-0"><?php echo $match_player2->fabulous; ?> - Fabulous</p>
										</div><!-- /.more -->
									</td>
								</tr>
								<?php
								}
							}
						} else {
						?>
						<tr>
							<td colspan="4">No matches for this season.</td>
						</tr>
						<?php
						}
						?>
						</tbody>
					</table>
				</div><!-- /.table-responsive -->

				<?php
				} else {
					// no users set?
					if(empty($players)){
						include('template/msgs/noUsersSet.php');
					}
					// no seasons set up?
					if(empty($current_season)){
						include('template/msgs/noSeason.php');
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
