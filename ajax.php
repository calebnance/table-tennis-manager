<?php
	// include helper
	include_once('includes/helper.php');

	// default response for now
	$response = [
		'msg' => '',
		'error' => (bool) false,
	];

	// only posts
	if(!isset($_POST['ajax'])) {
		session_start();
		$_SESSION['msg'] = 'I like your style, but naw homie, you can\'t go there.';
		$_SESSION['msg-type'] = 'info';
		header('Location: index.php');
		exit();
	} else {
		// we also need a function..
		if(isset($_POST['function'])) {
			$function = $_POST['function'];
			if(isset($_POST['args'])) {
				$arguments = $_POST['args'];
				call_user_func_array($function, $arguments);
			} else {
				$function();
			}
		} else {
			$response['msg'] = 'We at least need something to do..';
			$response['error'] = (bool) true;
		}

		print_r(json_encode($response));
		exit();
	}
?>
