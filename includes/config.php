<?php
	include('includes/helper.php');
	
	// Paths
	$base_url	= getBaseUrl();
	$assets		= $base_url . 'assets/';
	$css		= $assets . 'css/';
	$js			= $assets . 'js/';
	$bs			= $assets . 'bootstrap/';
	$bs_css		= $bs . 'css/';
	$bs_js		= $bs . 'js/';
	$bs_fonts	= $bs . 'fonts/';
	
	// Variables
	$current_page	= getCurrentPage();
	
	// Database
	$db_host		= 'localhost';
	$db_user		= 'root';
	$db_pass		= 'root';
	$db_name		= 'ttm_2014';
	
	// Includes
	$styles		= array();
	$scripts	= array();
	
	$styles[]	= $bs_css . 'bootstrap.min.css';
	$styles[]	= $css . 'offcanvas.css';
	$styles[]	= $css . 'style.css';
	
	// If a single page needs its own style.. set $page_styles before header is included
	// $page_styles		= array();
	// $page_styles[]	= 'style2.css';
	if(isset($page_styles)){
		foreach($page_styles as $page_style){
			$styles[] = $css . $page_style;
		}
	}
	
	$scripts[]	= $js . 'jquery-1.10.2.min.js';
	$scripts[]	= $bs_js . 'bootstrap.min.js';
	$scripts[]	= $js . 'offcanvas.js';
	
	// Debug
?>