<?php

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
		$full_url .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	} else {
		$full_url .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
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
*	Installed Helpers
*/
function isInstalled(){
		// check if class is available first
		$directory = __DIR__;
		$tt 			 = $directory . '/tt.php';
		// check if file exists
		if(file_exists($tt)){
			// include tt installer class
			include($tt);
			// has installation happened?
			if(class_exists('tt')) {
				return false;
			}
			// are we at the wizard?
			if(getCurrentPage() != 'wizard.php') {
				// go to wizard!
				goToWizard();
				exit();
			}
		} else { // if file doesn't exist, create it, go to installation wizard, to create full file
			// create file
			fclose(fopen($tt, 'w'));
			// go to wizard!
			goToWizard();
		}
}

function goToWizard() {
	// go to wizard!
	header('Location: install/wizard.php');
	exit();
}

function checkConnection($host, $table, $user, $pass, $responseType) {
	// sleep just for the ajax call
	sleep(3);
	// response
	$response = array(
		'error' => false,
		'msg'   => '',
	);
	$mysqli = mysqli_init();
	if (!$mysqli) {
		$response['msg'] = 'mysqli_init failed';
		$response['error'] =  true;
	}

	if (!$mysqli->options(MYSQLI_INIT_COMMAND, 'SET AUTOCOMMIT = 0')) {
		$response['msg'] = 'Setting MYSQLI_INIT_COMMAND failed';
		$response['error'] =  true;
	}

	if (!$mysqli->options(MYSQLI_OPT_CONNECT_TIMEOUT, 5)) {
		$response['msg'] = 'Setting MYSQLI_OPT_CONNECT_TIMEOUT failed';
		$response['error'] =  true;
	}

	if (!$mysqli->real_connect($host, $user, $pass, $table)) {
		$response['msg'] = 'Connect Error: ' . mysqli_connect_error();
		$response['error'] =  true;
	} else {
		$response['msg'] = 'success';
		$mysqli->close();
	}

	// is response json?
	if($responseType == 'json') {
		jsonIt($response);
	} else {
		return $response;
	}
}

function install($host, $table, $user, $pass, $username, $password, $responseType) {
	// check if class is available first
	$directory = __DIR__;
	$tt 			 = $directory . '/tt.php';
	$file 		 = fopen($tt, 'w');

	$contents  = '<?php' . "\n";
	$contents .= '/**' . "\n";
	$contents .= ' *	Table Tennis installer class' . "\n";
	$contents .= ' *' . "\n";
	$contents .= ' */' . "\n";
	$contents .= '  class tt {' . "\n";
	$contents .= "\n";
	$contents .= '		// database stuff' . "\n";
	$contents .= '    const DBHOST  = \'' . $host . '\';' . "\n";
	$contents .= '    const DBTABLE = \'' . $table . '\';' . "\n";
	$contents .= '    const DBUSER  = \'' . $user . '\';' . "\n";
	$contents .= '    const DBPASS  = \'' . $pass . '\';' . "\n";
	$contents .= "\n";
	$contents .= '  }' . "\n";
	$contents .= '?>' . "\n";

	fwrite($file, $contents);
	fclose($file);

	// sleep for a bit
	sleep(5);

	// response
	$response = array(
		'error' 	 => false,
		'msg'   	 => 'Installing Database Tables',
		'progress' => '30',
	);

	// is response json?
	if($responseType == 'json') {
		jsonIt($response);
	} else {
		return $response;
	}
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
	$_SESSION['last_login']	= $user_info[0]['last_login'] == '0000-00-00 00:00:00' ? date('Y-m-d H:i:s') : $user_info[0]['last_login']; // first time then just say last login was 2 seconds ago and so on..
	$_SESSION['timeout']		= time();

	// update user table
	$user = array(
		'last_login' => date('Y-m-d H:i:s'),
	);
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
		header('Location: index.php?msg=2');
		exit();
	} else {
		$_SESSION['timeout']	= time();
	}
}

function endsession(){
	session_start();
	session_destroy();
	header('Location: index.php?msg=3');
	exit();
}

function isAdmin(){
	checksession();
	if($_SESSION['is_admin'] == 0){
		header('Location: index.php?msg=4');
		exit();
	}
}

/**
 *	Data Helpers
 */
function setKeyDBData($data, $field){
	$formatted = array();
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

?>
