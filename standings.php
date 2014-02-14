<?php
	$title = 'Standings';
	include('template/header.php');
	include_once('includes/database.php');
	
	// Display errors on localhost
	$whitelist = array('locathost');
	if(!in_array($_SERVER['SERVER_NAME'], $whitelist)){
		//this is localhost!
		ini_set('display_errors', 1);
		//error_reporting(E_ALL);
		error_reporting(E_ALL ^ E_NOTICE);
	}
	
	$db		= new Database($db_host, $db_name, $db_user, $db_pass);
	
	$players= setKeyDBData($db->select('users', 'id, username', '1="1"', 'object', '', '', 'username'), 'id');
	foreach($players as $player_id => $player){
		$players[$player_id]->win			= 0;
		$players[$player_id]->lose			= 0;
		$players[$player_id]->percentage	= 0;
	}
	
	$current_season			= getCurrentSeason($db);
	$current_season_matches	= getSeasonMatches($current_season->start, $current_season->end, $db);
	
?>
	<div class="container">
		<div class="row row-offcanvas row-offcanvas-right">
			
			<div class="col-xs-12 col-sm-9">
				<p class="pull-right visible-xs">
					<button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle</button>
				</p>
				<h1 class="page-header">Standings</h1>
				
				<?php
				$standings = array();
				foreach($current_season_matches as $match){
					$match_scores	= $db->select('match_player', '*', 'match_id="' . $match->id . '"', 'object');
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
				?>
					
				<?php
				}
				
				foreach($players as $player_id => $player){
					$players[$player_id]->percentage	= round(($player->win / ($player->win + $player->lose)) * 100, 2);
				}
				
				uasort($players, function($a, $b){
					$a->percentage = str_replace(' ', '', $a->percentage);
					$b->percentage = str_replace(' ', '', $b->percentage);
					return (int)$b->percentage - (int)$a->percentage;
				});
				
				?>
				
				<h3>Season #<?php echo $current_season->season_number; ?>
				<br /><small><?php echo date('m-d-Y', strtotime($current_season->start)); ?> to <?php echo date('m-d-Y', strtotime($current_season->end)); ?></small></h3>
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
				
			</div><!--/span-->
			
			<?php include('template/sidebar.php'); ?>
			
		</div><!--/.row-->
	</div><!--/.container-->


<?php
	include('template/footer.php');
?>