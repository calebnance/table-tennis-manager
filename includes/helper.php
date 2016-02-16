<?php
// set directory
$directory = __DIR__;

// Include all the things
include_once($directory . '/helpers/install.php');
include_once($directory . '/debug.php');

/**
 *	Helpers
 */
function getFullURL(){
	$full_url = 'http';

	if($_SERVER["HTTPS"] == "on"){
		$full_url .= "s";
	}
	$full_url .= "://";
	if($_SERVER["SERVER_PORT"] != "80"){
		$full_url .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
	} else {
		$full_url .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
	}

	return $full_url;
}

function getBaseUrl($dir_deep = ''){
	$full_url = getFullURL();
	$full_url_explode = explode('/', $full_url);

	array_pop($full_url_explode);

	// now let's check for any directories that need to be removed
	if(in_array($dir_deep, $full_url_explode) && $dir_deep != '') {
		// parse through url parts
		foreach($full_url_explode as $key => $path_string) {
			// if dir_deep and url part match, unset it!
			if($path_string == $dir_deep) {
				unset($full_url_explode[$key]);
			}
		}
	}

	$base_url = implode('/', $full_url_explode) . '/';
	unset($full_url_explode);

	return $base_url;
}

function getCurrentPage(){
	$full_url = getFullURL();
	$full_url_explode = explode('/', $full_url);
	unset($full_url);

	$current_page = array_pop($full_url_explode);
	unset($full_url_explode);

	return $current_page;
}

function isCurrentPage($currentPage, $pageCheck) {
	if($currentPage == $pageCheck) {
		return 'class="active"';
	}

	return '';
}

function md5It($string, $responseType) {
	// md5 string
	$response = md5($string);

	// is response json?
	if($responseType == 'json') {
		jsonIt($response);
	} else {
		return $response;
	}

}

function jsonIt($response) {
	print_r(json_encode($response));
	exit();
}

/**
 *	Login/Session Helpers
 */
function pass_encrypt($text){
	return trim(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $salt, $text, MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND))));
}

function pass_decrypt($text){
	return trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $salt, base64_decode($text), MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND)));
}

function startsession($user_info, $db){
	session_start();

	$_SESSION['loggedin']		= 1;
	$_SESSION['is_admin']		= $user_info[0]['is_admin'];
	$_SESSION['uid']				= $user_info[0]['id'];
	$_SESSION['name']				= $user_info[0]['name'];
	$_SESSION['username']		= $user_info[0]['username'];
	$_SESSION['email']			= $user_info[0]['email'];
	$_SESSION['email_v']		= $user_info[0]['email_validated'];
	$_SESSION['last_login']	= $user_info[0]['last_login'] == '0000-00-00 00:00:00' ? date('Y-m-d H:i:s') : $user_info[0]['last_login']; // first time then just say last login was 2 seconds ago and so on..
	$_SESSION['timeout']		= time();

	// update user table
	$user = [
		'last_login' => date('Y-m-d H:i:s'),
	];
	$db->update('users', $user, 'id='.$user_info[0]['id']);

	timeoutsession();
}

function checksession(){
	session_start();
	if($_SESSION['loggedin'] == 1){
		timeoutsession();
	}
}

function timeoutsession(){
	session_start();
	if($_SESSION['timeout'] + 120 * 60 < time()){ // 2 hours of inactive time
		session_destroy();
		session_start();
		$_SESSION['msg'] = 'You have been logged out due to inactivity.';
		$_SESSION['msg-type'] = 'info';
		header('Location: index.php');
		exit();
	} else {
		$_SESSION['timeout']	= time();
	}
}

function endsession(){
	session_start();
	session_destroy();
	session_start();
	$_SESSION['msg'] = 'You are now logged out!';
	$_SESSION['msg-type'] = 'info';
	header('Location: index.php');
	exit();
}

function hasValidatedEmail() {

	return $_SESSION['email_v'] ? true : false;
}

function isAdmin(){
	checksession();
	if($_SESSION['is_admin'] == 0){
		$_SESSION['msg'] = 'You do not have access to this page.';
		$_SESSION['msg-type'] = 'danger';
		header('Location: index.php');
		exit();
	}
}

/**
 *	Profile Helpers
 */
function checkUsername($username) {
	// connect to datbase
	$db = new Database(tt::DBHOST, tt::DBTABLE, tt::DBUSER, tt::DBPASS);

	$username = $db->sanitize($username);
	$response = $db->custom_query('SELECT id FROM users WHERE username ="' . $username . '" LIMIT 1', true);

	return !empty($response) ? 1 : 0;
}

function getUserByUsername($username) {
	// connect to datbase
	$db = new Database(tt::DBHOST, tt::DBTABLE, tt::DBUSER, tt::DBPASS);

	$username = $db->sanitize($username);
	$response = $db->custom_query('SELECT * FROM users WHERE username ="' . $username . '" LIMIT 1', true);

	return $response;
}

/**
 *	Data Helpers
 */
function setKeyDBData($data, $field){
	$formatted = [];
	if($data && $field && is_array($data)){
		foreach($data as $key => $value){
			if(isset($value->$field)){
				$formatted[$value->$field] = $value;
			}
		}
	}

	return $formatted;
}

/**
 *	Match Helpers
 */

function getSeasons($db){

	return $db->custom_query('SELECT * FROM seasons');
}

function getThisYearSeasons($db){

	return $db->custom_query('SELECT * FROM seasons WHERE year="' . date('Y') . '"');
}

function getCurrentSeason($db){

	return $db->custom_query('SELECT * FROM seasons WHERE start <="' . date('Y-m-d') . ' 00:00:00" AND end >="' . date('Y-m-d') . ' 23:59:59"', true);
}

function getSeasonByNumYear($number, $year, $db){

	return $db->custom_query('SELECT * FROM seasons WHERE season_number="' . (int)$number . '" AND year="' . (int)$year . '"', true);
}

function getSeasonMatches($season_start, $season_end, $db){

	return $db->custom_query('SELECT * FROM match_ref WHERE date_time_started >="' . $season_start . '" AND date_time_started <="' . $season_end . '"');
}

function getUsers() {
	// connect to datbase
	$db = new Database(tt::DBHOST, tt::DBTABLE, tt::DBUSER, tt::DBPASS);
	$response = $db->custom_query('SELECT * FROM users');

	return $response;
}

function getPlayerById($playerId, $db) {

	return $db->custom_query('SELECT username FROM users WHERE id = "' . $playerId . '"', true);
}

function getScoreByPlayerAndMatchId($playerId, $matchId, $db) {

	return $db->custom_query('SELECT * FROM match_player WHERE match_id = "' . $matchId . '" AND player_id = "' . $playerId . '"', true);
}

/**
 *	Live Match Helpers
 */
function checkForLiveMatch($responseType) {
	sleep(1);
	// connect to datbase
	$db = new Database(tt::DBHOST, tt::DBTABLE, tt::DBUSER, tt::DBPASS);
	// first let's check for matches going on right now.. today.
	$sql  = 'SELECT * FROM match_ref ';
	$sql .= 'WHERE date_time_started >="' . date('Y-m-d') . ' 00:00:00" ';
	$sql .= 'AND date_time_started <="' . date('Y-m-d') . ' 23:59:59" ';
	$sql .= 'AND completed = 0 ';
	$sql .= 'ORDER BY date_time_started DESC ';
	$sql .= 'LIMIT 1';
	$currentMatch = $db->custom_query($sql, true);

	// set response
	$response = [
		'currentMatch' => empty($currentMatch) ? (int) 0 : (int) 1,
	];

	// match found?
	if(!empty($currentMatch)) {
		// set time
		$response['totalTime'] = $currentMatch->total_time;
		// get players
		$player1 = getPlayerById($currentMatch->player1, $db);
		$player2 = getPlayerById($currentMatch->player2, $db);
		$response['player1'] = $player1->username;
		$response['player2'] = $player2->username;
		// get player attributes
		$player1Match = getScoreByPlayerAndMatchId($currentMatch->player1, $currentMatch->id, $db);
		$player2Match = getScoreByPlayerAndMatchId($currentMatch->player2, $currentMatch->id, $db);
		$response['player1Score'] = (int) $player1Match->final_score;
		$response['player2Score'] = (int) $player2Match->final_score;
		// TODO: database driven
		$response['ptsToWin'] = (int) 11;
		$response['skunk'] = (int) 5;
	}

	// is response json?
	if($responseType == 'json') {
		jsonIt($response);
	} else {
		return $response;
	}
}

?>
