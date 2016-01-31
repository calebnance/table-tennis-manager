<?php


	include_once('includes/config.php');
	include_once('includes/database.php');

	$post_styles[] = $dp_css . 'datepicker.css';
	$scripts[] = $dp_js . 'bootstrap-datepicker.js';
	$scripts[] = $js . 'datepicker.js';

	// do they have access to ths page?
	isAdmin();

	$db = new Database($db_host, $db_name, $db_user, $db_pass);

	// Start season for this year
	$current_start = strtotime($week_start);
	$addS	= $weeks == 1 ? '' : 's';
	if($_POST){
		// check post for start seasons
		if(isset($_POST['start_seasons'])){
			$start_seasons_arr = explode('-', $_POST['start_seasons']);
			$date_formatted = $start_seasons_arr[2] . '-' . $start_seasons_arr[0] . '-' . $start_seasons_arr[1];
			$current_start = strtotime($date_formatted);
		}
		// Display errors on localhost
		$whitelist = array('localhost');
		if(!in_array($_SERVER['SERVER_NAME'], $whitelist)){
			//this is localhost!
			ini_set('display_errors', 1);
			//error_reporting(E_ALL);
			error_reporting(E_ALL ^ E_NOTICE);
		}

		// is the date a Monday
		if(date('D', $current_start) === 'Mon'){
			if($weeks > 0){

				$season_check	= $db->select('seasons', '*', 'year="' . date('Y') . '"', 'object');
				// if no season set up for this year.. do it
				if(empty($season_check)){
					$season_last = $db->custom_query('SELECT * FROM seasons ORDER BY id DESC LIMIT 1');
					$current_year	= date('Y-12-31');
					$end_of_year = strtotime($current_year);
					$day_span = ($weeks * 7) - 3;
					$current_end = strtotime('+' . $day_span . ' days', $current_start);
					$next_season_start = strtotime('+' . $weeks . ' weeks', $current_start); // next start of season

					$season_number = 1;
					$season_number_start = 1;

					if(!empty($season_last)){
						$season_number = $season_last->season_number + 1;
						$season_number_start = $season_last->season_number + 1;
					}

					for($i=1; $i < 53; $i++){
						if($end_of_year > $next_season_start){
							$end_of_season = date('Y-m-d', $current_end) . ' 23:59:59';
							$season = [
								'season_number' => $season_number,
								'start' => date('Y-m-d', $current_start),
								'end' => $end_of_season,
								'year' => (int)date('Y'),
							];
							$add_season = $db->insert('seasons', $season);

							$current_start = $next_season_start;
							$current_end = strtotime('+' . $day_span . ' days', $current_start);
							$next_season_start = strtotime('+' . $weeks . ' weeks', $current_start); // next start of season

							$season_number++;
						}
					}
					$season_number--;
					$_SESSION['msg'] = 'Seasons ' . $season_number_start . ' - ' . $season_number . ' have been created!';
					$_SESSION['msg-type'] = 'info';
				} else {
					$_SESSION['msg'] = 'Seasons are already set for this year.';
					$_SESSION['msg-type'] = 'info';
				}
			} else {
				$_SESSION['msg'] = 'Season needs to be at least 1 week. In the config.php file, set $weeks = "1"';
				$_SESSION['msg-type'] = 'info';
			}
		} else {
			$_SESSION['msg'] = 'Season start is not a Monday.';
			$_SESSION['msg-type'] = 'info';
		}
	}

	$title = 'Start Seasons';

	include('template/header.php');
?>
	<div class="container">
		<div class="row row-offcanvas row-offcanvas-right">

			<div class="col-xs-12 col-sm-9">
				<p class="pull-right visible-xs">
					<button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle</button>
				</p>
				<h1 class="page-header">Start Seasons for <?php echo date('Y'); ?></h1>

				<form id="start_seasons_form" role="form" action="start-season.php" method="POST">
					<div class="form-group">
						<label class="control-label" for="start_seasons">Season Start Day</label>
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
							<input type="text" class="form-control datepicker" id="start_seasons" name="start_seasons" value="<?php echo date('m-d-Y', strtotime($week_start)); ?>">
						</div><!-- /.input-group -->
					</div><!-- /.form-group -->
					<p class="lead">Each season will be <span class="label label-primary"><?php echo $weeks;?> week<?php echo $addS; ?></span>. (You can edit the season length inside of the config file)</p>
					<button id="submit_start_seasons" type="submit" class="btn btn-navy">Start Seasons</button>
				</form>

			</div><!-- /.col-xs-12 -->

			<?php
			include('template/sidebar.php');
			?>

		</div><!-- /.row -->
	</div><!-- /.container -->

<?php
	include('template/footer.php');
?>
