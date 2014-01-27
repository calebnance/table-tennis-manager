<?php
	// make sure to check for sql injection! in all of these areas being added!
	$email_code = $_SERVER['QUERY_STRING'];
	
	if($email_code):
		// include files
		include_once('includes/config.php');
		include_once('includes/database.php');
		
		$db		= new Database($db_host, $db_name, $db_user, $db_pass);
		$nocode	= $db->select('users', 'DISTINCT id', 'email_code="'.$email_code.'"', 'object');
		
		// is there a validate code in the database
		if($nocode):
			$valid		= $db->select('users', 'DISTINCT id', 'email_code="'.$email_code.'" AND email_validated="1"', 'object');
			
			// has the code already been validated?
			if(!$valid[0]):
				$user = array();
				$user['email_validated'] = 1;
				
				$db->update('users', $user, 'id='.$nocode[0]->id);

				echo 'code has been validated';
			else:
				echo 'code has already been validated!';
			endif;
		else:
			echo 'no code found in database';
		endif;
	else:
		echo 'no email code';
	endif;
?>