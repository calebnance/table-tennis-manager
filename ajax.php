<?php
	// include helper
	include_once('includes/helper.php');

	// default response for now
	$response = array(
		'msg' 	=> '',
		'error' => (bool) false,
	);

	// only posts
	if(!isset($_POST['ajax'])) {
		header('Location: index.php?msg=5');
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
			$response['msg']   = 'We at least need something to do..';
			$response['error'] = (bool) true;
		}

		print_r(json_encode($response));
		exit();
	}
?>
