<?php
// just in case install/validate gets called!
$email_code = $_SERVER['QUERY_STRING'];
if($email_code){
	header('Location: /validate.php?' . $email_code);
} else {
	header('Location: /');
}
