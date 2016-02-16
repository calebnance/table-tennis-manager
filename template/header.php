<?php
	// Are we directory(ies) deep?
	if(!isset($root_path)) {
		$root_path = '';
	}

	// Remove direcory from paths?
	if(!isset($dir_deep)) {
		$dir_deep = '';
	}

	// Config
	include_once($root_path . 'includes/config.php');

	// Check session
	checksession();

	// Are they logged in?
	$loggedin = 0;
	if(isset($_SESSION['loggedin'])){
		$loggedin = 1;
	}

	// Show message
	$show_form = 1;
	if((isset($registered) && $registered = 1) && $loggedin == 0){
		$_SESSION['msg'] = 'You need to be <a href="' . $base_url . 'login.php">logged-in</a> to view the full page.';
		$_SESSION['msg-type'] = 'warning';
		$show_form = 0;
	}

	// admin only?
	if(!empty($adminOnly) && $_SESSION['is_admin'] == 0){
		$_SESSION['msg'] = 'That page is <strong>admin only!</strong>';
		$_SESSION['msg-type'] = 'danger';
		header('location: index.php');
		exit();
	}

	// Title handled
	if(!$title){
		$title = 'Table Tennis Manager';
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $title; ?></title>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<?php
		foreach($styles as $style){
			echo sprintf('<link href="%s" rel="stylesheet" type="text/css">' . "\n", $style);
		}
		?>
	</head>

	<body>
	<?php include($root_path . 'template/menu.php'); ?>

	<div class="container">
		<div id="message-area">
		<?php
		// hey that's a good idea, use session and stuff
		if(!empty($_SESSION['msg'])) {
			include('template/msgs/alert.php');
			unset($_SESSION['msg']);
			unset($_SESSION['msg-type']);
		}
		?>
		</div><!-- /#message-area -->
	</div><!-- /.container -->
