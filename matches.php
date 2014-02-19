<?php
	$title = 'Matches';
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
	$set_season = 0;
	if($_GET['season']){
		$set_season = $_GET['season'];
	}
	
	$seasons				= getSeasons($db);
	if($set_season){
		$current_season		= getSeasonByNumYear($set_season, date('Y'), $db);
	} else {
		$current_season		= getCurrentSeason($db);	
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
				
				<form class="filter-area form-inline">
					<select name="season" class="form-control">
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
					<button type="submit" class="btn btn-primary">Submit</button>
				</form><!-- /.filter-area -->
				
				<div class="table-responsive">
					<table class="table table-striped">
						<thead>
							<tr>
								<th class="text-right">
									<?php
									/*
									<a href="#" class="btn btn-default btn-xs pull-left"><span class="glyphicon glyphicon-sort-by-order"></span></a>
									ID
									<span class="clearfix"></span>
									*/
									?>
									ID
								</th>
								<th class="text-right">Player 1</th>
								<th></th>
								<th class="text-left">Player 2</th>
								<th></th>
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
								if(($match_player1->final_score != $match_player2->final_score) && ($match_player1->final_score > 0 || $match_player2->final_score > 0)){
								?>
								<tr>
									<td class="text-right"><?php echo $match_player1->match_id; ?></td>
									<td class="text-right<?php echo $winner_1; ?>"><?php echo $players[$season_match->player1]->username; ?> - <?php echo sprintf("%02s", $match_player1->final_score); ?></td>
									<td class="text-center border-left-right">vs</td>
									<td class="text-left<?php echo $winner_2; ?>"><?php echo sprintf("%02s", $match_player2->final_score); ?> - <?php echo $players[$season_match->player2]->username; ?></td>
									<td><a href="#" class="btn btn-default"><span class="glyphicon glyphicon-wrench"></span></td>
								</tr>
								<?php
								}
							}
						} else {
						?>
						<tr>
							<td colspan="5">No matches for this season.</td>
						</tr>
						<?php
						}
						?>
						</tbody>
					</table>
				</div><!-- /.table-responsive -->
				
			</div><!--/span-->
			
			<?php include('template/sidebar.php'); ?>
			
		</div><!--/.row-->
	</div><!--/.container-->


<?php
	include('template/footer.php');
?>