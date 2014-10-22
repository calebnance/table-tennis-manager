<?php
	$title = 'Validate E-mail Address';
	include('template/header.php');

	// make sure to check for sql injection! in all of these areas being added!
	$email_code = $_SERVER['QUERY_STRING'];

	if($email_code){
		// include files
		include_once('includes/config.php');
		include_once('includes/database.php');

		$db 		= new Database($db_host, $db_name, $db_user, $db_pass);
		$nocode	= $db->select('users', 'DISTINCT id', 'email_code="'.$email_code.'"', 'object');

		// is there a validate code in the database
		if($nocode){
			$valid = $db->select('users', 'DISTINCT id', 'email_code="'.$email_code.'" AND email_validated="1"', 'object');

			// has the code already been validated?
			if(!$valid[0]){
				$user = array(
					'email_validated' => 1,
				);
				$db->update('users', $user, 'id=' . $nocode[0]->id);
				$msg = 'E-mail address has been validated!';
			} else {
				$msg = 'E-mail address has already been validated!';
			}
		} else {
			$msg = 'E-mail address and code were not found in database';
		}
	} else {
		$msg = 'No E-mail address code set!';
	}
?>
	<div class="container">
		<div class="row row-offcanvas row-offcanvas-right">

			<div class="col-xs-12 col-sm-9">
				<p class="pull-right visible-xs">
					<button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle</button>
				</p>
				<h1 class="page-header">E-mail Validation</h1>
				<p class="lead"><?php echo $msg; ?></p>
			</div><!--/span-->

			<?php include('template/sidebar.php'); ?>

		</div><!--/.row-->
	</div><!--/.container-->


<?php
	include('template/footer.php');
?>
