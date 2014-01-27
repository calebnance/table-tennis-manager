<?php

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

function getBaseURL(){
	$full_url = getFullURL();
	$full_url_explode = explode('/', $full_url);
	
	array_pop($full_url_explode);
	
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

function pass_encrypt($text){
	return trim(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $salt, $text, MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND))));
}

function pass_decrypt($text){
	return trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $salt, base64_decode($text), MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND)));
}

?>