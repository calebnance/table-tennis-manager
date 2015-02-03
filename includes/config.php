<?php
	// Helper
	include($root_path . 'includes/helper.php');

	// Is it installed?
	isInstalled();

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

	// Database
	$db_host		= 'localhost';
	$db_user		= 'root';
	$db_pass		= 'root';
	$db_name		= 'ttm_2014';

	// Season Setup
	$weeks			= 2; // for each season
	$week_start	= '2014-10-06'; // set this date that will continue until the end of the year

	// Includes
	$styles		= array();
	$scripts	= array();

	$styles[]	= $bs_css . 'bootstrap.min.css';
	$styles[]	= $fa_css . 'font-awesome.min.css';
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

	$scripts[] = $js . 'jquery-1.10.2.min.js';
	$scripts[] = $bs_js . 'bootstrap.min.js';
	$scripts[] = $js . 'offcanvas.js';
	$scripts[] = $js . 'javascript.js';

	// Table tennis defaults
	$pts_to_win		= 11;
	$pts_per_turn	= 2;
	$skunk				= 5;

	// Debug
?>
