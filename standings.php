<?php
	$title = 'Standings';

	// Include page css
	$page_styles[] = $css . 'jquery.circliful.css';

	include('template/header.php');

	// Include page js
	$scripts[] = $js . 'jquery.circliful.min.js';
	$scripts[] = $js . 'standings.js';

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
		$players[$player_id]->win					= 0;
		$players[$player_id]->lose				= 0;
		$players[$player_id]->percentage	= 0;
	}

	$current_season = getCurrentSeason($db);
	$current_season_matches	= getSeasonMatches($current_season->start, $current_season->end, $db);

	$standings = [];
	foreach($current_season_matches as $match){
		$match_scores	= $db->select('match_player', '*', 'match_id="' . $match->id . '"', 'object');
		if($match_scores){
			if(count($match_scores) == 2){
				$player1 = $match_scores[0];
				$player2 = $match_scores[1];
			} else {
				continue;
			}
			if(($player1->final_score != $player2->final_score) && ($player1->final_score > 0 || $player2->final_score > 0)){

				if($player1->final_score > $player2->final_score){
					$players[$player1->player_id]->win ++;
					$players[$player2->player_id]->lose ++;
				} else {
					$players[$player1->player_id]->lose ++;
					$players[$player2->player_id]->win ++;
				}
			}
		}
	}

	foreach($players as $player_id => $player){
		if($player->win > 0 || $player->lose > 0){
			$players[$player_id]->percentage	= round(($player->win / ($player->win + $player->lose)) * 100, 2);
		}
	}

	uasort($players, function($a, $b){
		$a->percentage = str_replace(' ', '', $a->percentage);
		$b->percentage = str_replace(' ', '', $b->percentage);
		return (int)$b->percentage - (int)$a->percentage;
	});

	$users_check = $db->select('users', '*', '1=1', 'object', '', '', '', '1');
	?>

	<div class="container">
		<div class="row row-offcanvas row-offcanvas-right">

			<div class="col-xs-12 col-sm-9">
				<p class="pull-right visible-xs">
					<button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle</button>
				</p>
				<h1 class="page-header">Standings</h1>

				<?php
				// are there users in the database?
				if($users_check && $current_season){
				?>
					<div class="btn-group pull-right" data-toggle="buttons">
						<label class="btn btn-default show-list-graph active">
							<input type="radio" name="options" id="listings"> <i class="fa fa-th-list"></i>
						</label>
						<label class="btn btn-default show-list-graph">
							<input type="radio" name="options" id="graphs"> <i class="fa fa-th-large"></i>
						</label>
					</div><!-- /.btn-group -->

					<h3 class="margin-b-20">
						Season #<?php echo $current_season->season_number; ?>
						<small><?php echo date('M d, Y', strtotime($current_season->start)); ?> to <?php echo date('M d, Y', strtotime($current_season->end)); ?></small>
					</h3>

					<div class="clearfix"></div>

					<div id="standings-listings" class="list-graph">
						<table class="table table-striped">
							<thead>
								<tr>
									<td class="text-center">Place</td>
									<td>Player</td>
									<td class="text-center">Win</td>
									<td class="text-center">Lose</td>
									<td class="text-right">Winning Percentage</td>
								</tr>
							</thead>
							<tbody>
							<?php
							$place = 1;
							foreach($players as $player){
								$tr_class = '';
								if($_SESSION && isset($_SESSION['uid']) && $player->id == $_SESSION['uid']){
									$tr_class = 'success';
								}
							?>
							<tr class="<?php echo $tr_class; ?>">
								<td class="text-center"><?php echo $place; ?></td>
								<td><?php echo $player->username; ?></td>
								<td class="text-center"><?php echo $player->win; ?></td>
								<td class="text-center"><?php echo $player->lose; ?></td>
								<td class="text-right"><?php echo number_format($player->percentage, 2); ?>%</td>
							</tr>
						<?php
							$place++;
						}
						?>
							</tbody>
						</table>
					</div><!-- /#standings-listings -->

					<div id="standings-graphs" class="list-graph display-none">
						<?php
						$place = 1;
						foreach($players as $player){
							$tr_class = '';
							if($_SESSION && isset($_SESSION['uid']) && $player->id == $_SESSION['uid']){
								$tr_class = 'success';
							}
						?>
							<div id="graph-<?php echo $place; ?>" class="circliful circliful-standings-block pull-left" data-dimension="250" data-text="<?php echo number_format($player->percentage, 2); ?>%" data-info="<?php echo $player->username; ?>" data-width="30" data-fontsize="30" data-percent="<?php echo $player->percentage; ?>" data-fgcolor="#61A9DC" data-icon="fa-users" data-bgcolor="#EEEEEE" data-fill="#DDDDDD"></div>
						<?php
							$place++;
						}
						?>
					</div><!-- /#standings-graphs -->

					<div class="clearfix"></div>
				<?php
				} else {
					// no users set?
					if(empty($users_check)){
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

		</div><!-- /.row-->
	</div><!-- /.container-->

<?php
	include('template/footer.php');
?>
