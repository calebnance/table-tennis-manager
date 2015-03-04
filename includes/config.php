<?php
	// Helper
	include($root_path . 'includes/helper.php');

	// Is it installed?
	isInstalled();

	// Version
	$version  = '0.9.6';

	// Paths
	$base_url	= getBaseUrl($dir_deep);
	$assets		= $base_url . 'assets/';
	$css			= $assets . 'css/';
	$js				= $assets . 'js/';
	$bs				= $assets . 'bootstrap/';
	$bs_css		= $bs . 'css/';
	$bs_js		= $bs . 'js/';
	$fa				= $assets . 'fontawesome4/';
	$fa_css		= $fa . 'css/';
	$dp 			= $assets . 'datepicker/';
	$dp_js 		= $dp . 'js/';
	$dp_css 	= $dp . 'css/';

	// Variables
	$current_page	= getCurrentPage();

	// Does this class exist? Errors out when wizard is present, so fixed it.
	if(class_exists('tt')) {
		// Database
		$db_host	= tt::DBHOST;
		$db_user	= tt::DBUSER;
		$db_pass	= tt::DBPASS;
		$db_name	= tt::DBTABLE;
	}

	// Season Setup
	$weeks = 2; // for each season
	if(date('N') == 1) {
		$week_start	= date('Y-m-d'); // grab today
	} else {
		$week_start	= date('Y-m-d', strtotime('next monday')); // grab last weeks monday
	}

	// Includes
	$styles		= array();
	$scripts	= array();

	$styles[]	= $bs_css . 'bootstrap.min.css';
	$styles[]	= $fa_css . 'font-awesome.min.css';
	$styles[]	= $css . 'offcanvas.css';
	$styles[]	= $css . 'plugins.css';
	$styles[]	= $css . 'style.css';

	// If a single page needs its own style.. set $page_styles before header is included
	// $page_styles		= array();
	// $page_styles[]	= 'style2.css';
	if(isset($page_styles)){
		foreach($page_styles as $page_style){
			$styles[] = $css . $page_style;
		}
	}

	//$scripts[] = $js . 'jquery-1.10.2.min.js';
	$scripts[] = $js . 'jquery-2.1.3.min.js';
	$scripts[] = $bs_js . 'bootstrap.min.js';
	$scripts[] = $js . 'offcanvas.js';
	$scripts[] = $js . 'javascript.js';

	// Table tennis defaults
	$pts_to_win		= 11;
	$pts_per_turn	= 2;
	$skunk				= 5;

	// Debug
?>
