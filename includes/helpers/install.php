<?php

/**
*	Installed Helpers
*/

// check if ttm is installed
function isInstalled(){
	// check if class is available first
	$directory = __DIR__;
	$directory = str_replace('helpers', '', $directory);
	$tt = $directory . 'tt.php';
	// check if file exists
	if(file_exists($tt)){
		// include tt installer class
		include($tt);
		// has installation happened?
		if(class_exists('tt')) {
			return false;
		}
		$checkCurrentPage = getCurrentPage();
		// are we at the wizard?
		if($checkCurrentPage != 'wizard.php' && $checkCurrentPage != 'wizard-ajax.php' && $checkCurrentPage != 'ajax.php') {
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

// redirect to wizard page if ttm is not installed
function goToWizard() {
	// go to wizard!
	header('Location: /install/wizard.php');
	exit();
}

// check database connection
function checkConnection($host, $table, $user, $pass, $responseType = 'return') {
	if($responseType == 'json') {
		// sleep just for the ajax call
		sleep(3);
	}
	// turn off error reporting
	error_reporting(0);

	// response
	$response = [
		'error' => false,
		'msg' => '',
		'extra' => '',
	];

	$mysqli = mysqli_init();

	if (!$mysqli) {
		$response['msg'] = 'mysqli_init failed';
		$response['error'] = true;
	}

	if (!$mysqli->options(MYSQLI_INIT_COMMAND, 'SET AUTOCOMMIT = 0')) {
		$response['msg'] = 'Setting MYSQLI_INIT_COMMAND failed';
		$response['error'] = true;
	}

	if (!$mysqli->options(MYSQLI_OPT_CONNECT_TIMEOUT, 5)) {
		$response['msg'] = 'Setting MYSQLI_OPT_CONNECT_TIMEOUT failed';
		$response['error'] = true;
	}

	if (!$mysqli->real_connect($host, $user, $pass, $table)) {
		$connectError = mysqli_connect_error();
		$response['msg'] = 'Connect Error: ' . $connectError;
		$response['error'] = true;
		// if the database is non-existant..
		if(substr($connectError, 0, 16) == 'Unknown database') {
			$response['extra'] = 'showCreateDB';
		}
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

// create database
function createDatabase($host, $table, $user, $pass, $responseType) {
	// sleep just for the ajax call
	sleep(2);
	// turn off error reporting
	error_reporting(0);
	// response
	$response = [
		'error' => false,
		'msg' => '',
		'extra' => '',
	];

	// create connection
	$connection = new mysqli($host, $user, $pass);
	// check connection
	if ($connection->connect_error) {
		$response['msg'] = 'Connect Error: please check host, user and password';
		$response['error'] = true;
	} else {
		// create database
		if ($connection->query("CREATE DATABASE " . $table) === TRUE) {
			$response['msg'] = 'success';
		} else {
			$response['msg'] = 'Connect Error: please check host, user and password';
			$response['error'] = true;
		}
		$connection->close();
	}

	// is response json?
	if($responseType == 'json') {
		jsonIt($response);
	} else {
		return $response;
	}
}

// create the ttm class :)
function install($host, $table, $user, $pass, $responseType) {
	// check if class is available first
	$directory = __DIR__;
	$directory = str_replace('helpers', '', $directory);
	$tt = $directory . 'tt.php';
	$file = fopen($tt, 'w');

	$contents  = '<?php' . "\n";
	$contents .= '/**' . "\n";
	$contents .= ' *	File: tt.php' . "\n";
	$contents .= ' *' . "\n";
	$contents .= ' */' . "\n\n";
	$contents .= '/**' . "\n";
	$contents .= ' *	Table Tennis class' . "\n";
	$contents .= ' *' . "\n";
	$contents .= ' */' . "\n";
	$contents .= 'class tt {' . "\n";
	$contents .= "\n";
	$contents .= '  // database connection' . "\n";
	$contents .= '  const DBHOST  = \'' . $host . '\';' . "\n";
	$contents .= '  const DBTABLE = \'' . $table . '\';' . "\n";
	$contents .= '  const DBUSER  = \'' . $user . '\';' . "\n";
	$contents .= '  const DBPASS  = \'' . $pass . '\';' . "\n";
	$contents .= "\n";
	$contents .= '}' . "\n";
	$contents .= '?>' . "\n";

	fwrite($file, $contents);
	fclose($file);

	// sleep for a bit
	sleep(5);

	// response
	$response = [
		'error' => false,
		'msg' => 'Installing Database Tables',
		'progress' => '25',
	];

	// is response json?
	if($responseType == 'json') {
		jsonIt($response);
	} else {
		return $response;
	}
}

// set up database tables now that we are "installed"
function setUpDatabaseTables($responseType) {
	// include tt
	$directory = __DIR__;
	$directory = str_replace('helpers', '', $directory);
	$tt = $directory . 'tt.php';
	include($tt);

	// set sql1 - users table
	$sql1 = 'CREATE TABLE IF NOT EXISTS  `' . tt::DBTABLE . '`.`users` (' .
	'`id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,' .
	'`name` VARCHAR(256) NOT NULL,' .
	'`username` VARCHAR(256) NOT NULL,' .
	'`email` VARCHAR(256) NOT NULL,' .
	'`password` VARCHAR(256) NOT NULL,' .
	'`about` TEXT NOT NULL,' .
	'`email_code` VARCHAR(256) NOT NULL,' .
	'`email_validated` INT(2) NOT NULL,' .
	'`is_admin` VARCHAR(10) NOT NULL,' .
	'`receive_email` INT(2) NOT NULL,' .
	'`created` DATETIME NOT NULL,' .
	'`updated` DATETIME NOT NULL,' .
	'`last_login` DATETIME NOT NULL' .
	')ENGINE = INNODB;';

	// set sql2 - match_ref table
	$sql2 = 'CREATE TABLE IF NOT EXISTS  `' . tt::DBTABLE . '`.`match_ref` (' .
	'`id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,' .
	'`player1` INT(11) NOT NULL,' .
	'`player2` INT(11) NOT NULL,' .
	'`serve_first` INT(11) NOT NULL,' .
	'`date_time_started` DATETIME NOT NULL,' .
	'`total_time` TIME NOT NULL,' .
	'`completed` INT(2) NOT NULL' .
	') ENGINE = INNODB;';

	// set sql3 - match_player table
	$sql3 = 'CREATE TABLE IF NOT EXISTS  `' . tt::DBTABLE . '`.`match_player` (' .
	'`id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,' .
	'`match_id` INT(11) NOT NULL,' .
	'`player_id` INT(11) NOT NULL,' .
	'`final_score` INT(11) NOT NULL,' .
	'`aces` INT(2) NOT NULL,' .
	'`bad_serves` INT(2) NOT NULL,' .
	'`frustration` INT(2) NOT NULL,' .
	'`ones` INT(2) NOT NULL,' .
	'`feel_goods` INT(2) NOT NULL,' .
	'`slams_missed` INT(2) NOT NULL,' .
	'`slams_made` INT(2) NOT NULL,' .
	'`digs` INT(2) NOT NULL,' .
	'`foosball` INT(2) NOT NULL,' .
	'`just_the_tip` INT(2) NOT NULL,' .
	'`fabulous` INT(2) NOT NULL,' .
	'`date_created` DATETIME NOT NULL,' .
	'`date_modified` DATETIME NOT NULL,' .
	'`user_created` INT(11) NOT NULL,' .
	'`user_modified` INT(11) NOT NULL' .
	') ENGINE = INNODB;';

	// set sql4 - seasons table
	$sql4 = 'CREATE TABLE IF NOT EXISTS  `' . tt::DBTABLE . '`.`seasons` (' .
	'`id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,' .
	'`season_number` INT(11) NOT NULL,' .
	'`start` DATETIME NOT NULL,' .
	'`end` DATETIME NOT NULL,' .
	'`year` INT(11) NOT NULL' .
	') ENGINE = INNODB;';

	// set sql5 - pages table
	$sql5 = 'CREATE TABLE IF NOT EXISTS  `' . tt::DBTABLE . '`.`pages` (' .
	'`id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,' .
	'`page` VARCHAR(256) NOT NULL,' .
	'`title` VARCHAR(256) NOT NULL,' .
	'`content` TEXT NOT NULL,' .
	'`date_created` DATETIME NOT NULL,' .
	'`date_modified` DATETIME NOT NULL,' .
	'`user_created` INT(11) NOT NULL,' .
	'`user_modified` INT(11) NOT NULL,' .
	'`published` INT(2) NOT NULL DEFAULT "1"' .
	') ENGINE = INNODB;';

	// create connection to database
	$conn = mysqli_connect(tt::DBHOST, tt::DBUSER, tt::DBPASS, tt::DBTABLE);

	// install tables
	mysqli_query($conn, $sql1);
	mysqli_query($conn, $sql2);
	mysqli_query($conn, $sql3);
	mysqli_query($conn, $sql4);
	mysqli_query($conn, $sql5);

	// close connection
	mysqli_close($conn);

	// sleep for a bit
	sleep(5);

	// response
	$response = [
		'error' => false,
		'msg' => 'Seeding Database Tables',
		'progress' => '50',
	];

	// is response json?
	if($responseType == 'json') {
		jsonIt($response);
	} else {
		return $response;
	}
}

// set database table(s)
// - users table
function seedDatabaseTables($name, $username, $password, $email, $responseType) {
	// include tt
	$directory = __DIR__;
	$directory = str_replace('helpers', '', $directory);
	$tt = $directory . 'tt.php';
	include($tt);

	// create connection to database
	$conn = mysqli_connect(tt::DBHOST, tt::DBUSER, tt::DBPASS, tt::DBTABLE);

	// placeholder for content section / manage pages!

	// Set up for user e-mail
	$email_code = md5(uniqid(rand(), true));

	// Insert new user
	$admin_record = [
		'name' => $name,
		'username' => $username,
		'email' => $email,
		'password' => pass_encrypt($password),
		'about' => '',
		'email_code' => $email_code,
		'email_validated' => 0,
		'is_admin' => 1,
		'receive_email' => 1,
		'created' => date('Y-m-d H:i:s'),
		'last_login' => '0000-00-00 00:00:00',
	];

	// insert query
	$query = 'INSERT INTO users ( ' . implode(',', array_keys($admin_record)) . ' )';
	$query .= ' VALUES(\'' . implode('\',\'', $admin_record) . '\')';

	// mysql query
	mysqli_query($conn, 'SET NAMES \'utf8\'');
	mysqli_query($conn, 'SET CHARACTER SET \'utf8\'');

	// insert into database
	$result = mysqli_query($conn, $query);

	// get base url
	$base_url	= getBaseUrl();

	// set up validate link
	$link_validate = $base_url . 'validate.php?' . $email_code;

	// set up e-mail msg
	$email_msg = '
	<html>
	<head>
	<title>Welcome to Tabble Tennis, ' . $admin_record['name'] . '</title>
	</head>
	<body>
	<p>Hey ' . $admin_record['name'] . ',</p>
	<p>You have installed Table Tennis Manager on your server! :)</p>
	<p>Thank you for trying this out! All errors or feature requests can be submitted on GitHub <a href="https://github.com/calebnance/table-tennis-manager/">(calebnance/table-tennis-manager)</a>.</p>
	<br>
	<p>Please validate this e-mail address by clicking the link below, if the link does not work, copy the full link underneath into your favorite internet browser.</p>
	<p><a href="'.$link_validate.'">Validate E-mail</a></p>
	<p>'.$link_validate.'</p>
	<p><br />Thank You!</p>
	</body>
	</html>
	';

	// set headers for e-mail
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= 'From: Table Tennis Manager<no_reply@calebnance.com>' . "\r\n";

	// send mail
	mail($admin_record['email'], 'Table Tennis Manager Validate E-mail', $email_msg, $headers);

	// sleep for a bit
	sleep(5);

	// response
	$response = [
		'error' => false,
		'msg' => 'Validation E-mail has been sent!',
		'progress' => '100',
	];

	// is response json?
	if($responseType == 'json') {
		jsonIt($response);
	} else {
		return $response;
	}
}
