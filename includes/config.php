<?php
	// Set debug
	const DEBUG = false;

	// Include Helpers
	include_once($root_path . 'includes/helper.php');

	// Is it installed?
	isInstalled();

	// Set timezone
	date_default_timezone_set('America/New_York');

	// Set version
	$version  = '0.9.9';

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

	// Set helper variables
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
	// for each season
	$weeks = 2;
	if(date('N') == 1) {
		// grab today
		$week_start	= date('Y-m-d');
	} else {
		// grab last weeks monday
		$week_start	= date('Y-m-d', strtotime('next monday'));
	}

	// Includes
	$styles = [];
	$scripts = [];

	$styles[]	= $bs_css . 'bootstrap.min.css?v=' . $version;
	$styles[]	= $fa_css . 'font-awesome.min.css?v=' . $version;

	// are we in dev or prod?
	if(DEBUG) {
		$styles[]	= $css . 'dev/offcanvas.css?v=' . $version;
		$styles[]	= $css . 'dev/plugins.css?v=' . $version;
		$styles[]	= $css . 'dev/style.css?v=' . $version;
	} else {
		$styles[]	= $css . 'offcanvas.min.css?v=' . $version;
		$styles[]	= $css . 'plugins.min.css?v=' . $version;
		$styles[]	= $css . 'style.min.css?v=' . $version;
	}

	/**
	 * If a single page needs its own style..
	 * set $page_styles before header is included
	 *
	 * $page_styles		= [];
	 * $page_styles[]	= 'page-specific-style.css';
	 */
	if(isset($page_styles)){
		foreach($page_styles as $page_style){
			$styles[] = $css . $page_style . '?v=' . $version;
		}
	}

	$scripts[] = $js . 'jquery-2.1.3.min.js?v=' . $version;
	$scripts[] = $bs_js . 'bootstrap.min.js?v=' . $version;

	// are we in dev or prod?
	if(DEBUG) {
		$scripts[] = $js . 'dev/offcanvas.js?v=' . $version;
		$scripts[] = $js . 'dev/javascript.js?v=' . $version;
	} else {
		$scripts[] = $js . 'offcanvas.min.js?v=' . $version;
		$scripts[] = $js . 'javascript.min.js?v=' . $version;
	}

	// Table tennis defaults
	$pts_to_win = 11;
	$pts_per_turn	= 2;
	$skunk = 5;
?>
