<?php
	include_once('includes/config.php');
	
	if(!$title){
		$title = 'Table Tennis';
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
	<?php include('template/menu.php'); ?>
	
	<div class="container">
		<div id="message-area">
		</div><!-- /.message-area -->
	</div><!-- /.container -->