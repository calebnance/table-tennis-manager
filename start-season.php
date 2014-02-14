<?php
	
	include('includes/config.php');
	include_once('includes/database.php');
	
	$db				= new Database($db_host, $db_name, $db_user, $db_pass);
	
	// Display errors on localhost
	$whitelist = array('locathost');
	if(!in_array($_SERVER['SERVER_NAME'], $whitelist)){
		//this is localhost!
		ini_set('display_errors', 1);
		//error_reporting(E_ALL);
		error_reporting(E_ALL ^ E_NOTICE);
	}
	
	// Start season for this year
	$current_start = strtotime($week_start);
	
	// is the date a Monday
	if(date('D', $current_start) === 'Mon'){
		if($weeks > 0){
			
			$season_check	= $db->select('seasons', '*', 'year="' . date('Y') . '"', 'object');
			// if no season set up for this year.. do it
			if(empty($season_check)){
				$season_last	= $db->custom_query('SELECT * FROM seasons ORDER BY id DESC LIMIT 1');

				$current_year		= date('Y-12-31');
				$end_of_year		= strtotime($current_year);
				$day_span			= ($weeks * 7) - 3;
				$current_end		= strtotime('+' . $day_span . ' days', $current_start);
				$next_season_start	= strtotime('+' . $weeks . ' weeks', $current_start); // next start of season
				
				$season_number		= 1;
				$season_number_start= 1;
				if(!empty($season_last)){
					$season_number		= $season_last->season_number + 1;
					$season_number_start= $season_last->season_number + 1;
				}

				for($i=1; $i < 53; $i++){
					if($end_of_year > $next_season_start){
						$end_of_season = date('Y-m-d', $current_end) . ' 23:59:59';
						$season = array(
							'season_number' => $season_number,
							'start'			=> date('Y-m-d', $current_start),
							'end'			=> $end_of_season,
							'year'			=> (int)date('Y')
						);
						$add_season = $db->insert('seasons', $season);
						
						$current_start		= $next_season_start;
						$current_end		= strtotime('+' . $day_span . ' days', $current_start);
						$next_season_start	= strtotime('+' . $weeks . ' weeks', $current_start); // next start of season
						
						$season_number++;
					}
				}
				$season_number--;
				echo 'Seasons ' . $season_number_start . ' - ' . $season_number . ' have been created!';
				exit();
			} else {
				echo 'Seasons are already set for this year.';
				exit();
			}
			
		} else {
			echo 'Season needs to be at least 1 week. In the config.php file, set $weeks = "1"';
			exit();
		}
	} else {
		echo 'Week start is not a Monday.<br />';
		echo 'Please edit the date in the config.php file: $week_start = "' . $week_start . '" - which is a ' . date('l', $current_start) . '.';
		exit();
	}
	
?>