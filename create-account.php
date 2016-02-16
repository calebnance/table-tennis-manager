<?php
	include_once('includes/config.php');
	include_once('includes/database.php');

	// check database table
	$response = checkConnection($db_host, $db_name, $db_user, $db_pass);

	// set title
	$title = 'Create Account';

	// database table be there!
	if($response['extra'] !== 'showCreateDB') {
		$db = new Database($db_host, $db_name, $db_user, $db_pass);
		// check to see if there are any users in the database
		// if not, this first sign up will be the admin!
		// let them know!
		$first_signup = $db->select('users', '*', '1=1', 'object', '', '', '', '1');

		if($_POST){
			$response = [
				'msg' => 'Successfully added the user <strong>' . $_POST['acco_username'] . '</strong>! Please check your e-mail to validate this account!',
				'type' => 'success',
			];

			// Check username and e-mail does not exist
			$username_check	= $db->select('users', '*', 'username="' . $_POST['acco_username'] . '"', 'object');
			$email_check = $db->select('users', '*', 'email="' . $_POST['acco_email'] . '"', 'object');

			// if username check or email check returned something..
			if(!empty($username_check) || !empty($email_check)){
				$response['type']	= 'info';
				// username has already been taken!
				if(!empty($username_check)){
					$response['msg'] = 'Username has already been taken, think of something else... I know it\'s tough';
					echo json_encode($response);
					exit();
				}
				// email has already been used!
				if(!empty($email_check)){
					$response['msg'] = 'E-mail has already been registered, have you forgotten you\'ve already signed up? (make sure to check your spam folder)';
					echo json_encode($response);
					exit();
				}
			}

			// Set up for user e-mail
			$email_code = md5(uniqid(rand(), true));
			// Insert new user
			$user_record = [
				'name' => $_POST['acco_name'],
				'username' => $_POST['acco_username'],
				'email' => $_POST['acco_email'],
				'password' => pass_encrypt($_POST['acco_password']),
				'email_code' => $email_code,
				'email_validated' => 0,
				'created' => date('Y-m-d H:i:s'),
				'last_login' => '0000-00-00 00:00:00',
			];
			// first user? make them administrator
			if(empty($first_signup)){
				$user_record['is_admin'] = 1;
			}
			$db->insert('users', $user_record);

			// Send e-mail for validation
			$link_validate = $base_url . 'validate.php?' . $email_code;
			$email_msg = '<html>
				<head>
					<title>Welcome to Tabble Tennis, '.$user_record['name'].'</title>
				</head>
				<body>
					<p>Hey '.$user_record['name'].',</p>
					<p>Thank you for signing up for Table Tennis!</p>
					<p>The next step is to validate this e-mail address by clicking the link below, if the link does not work, copy the full link underneath into your favorite internet browser.</p>
					<p><a href="'.$link_validate.'">Validate E-mail</a></p>
					<p>'.$link_validate.'</p>
					<p><br />Thank You!</p>
				</body>
			</html>';

			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= 'From: Table Tennis Manager<no_reply@calebnance.com>' . "\r\n";

			// Send mail
			mail($user_record['email'], 'Table Tennis Validate E-mail', $email_msg, $headers);

			echo json_encode($response);
			exit();
		}

		include('template/header.php');

		// Include page js
		// are we in dev or prod?
		if(DEBUG) {
			$scripts[] = $js . 'dev/create-account.js?v=' . $version;
		} else {
			$scripts[] = $js . 'create-account.min.js?v=' . $version;
		}
	?>
		<div class="container">
			<div class="row row-offcanvas row-offcanvas-right">

				<div class="col-xs-12 col-sm-9">
					<p class="pull-right visible-xs">
						<button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle</button>
					</p>
					<h1 class="page-header">Create Account</h1>
					<?php
					if(empty($first_signup)){
					?>
					<div class="alert alert-info">This is the first account for this site! You will be the administrator!</div>
					<?php
					}
					?>
					<form id="create_account_form" role="form" action="create-account.php" method="POST">
						<div class="row">
							<div class="col-xs-12 col-md-6">
								<div class="form-group">
									<label class="control-label" for="acco_name">Name <span></span></label>
									<input type="text" class="form-control required" id="acco_name" name="acco_name" placeholder="Enter Name">
								</div><!-- /.form-group -->
								<div class="form-group">
									<label class="control-label" for="acco_username">Username <span></span></label>
									<input type="text" class="form-control required" id="acco_username" name="acco_username" placeholder="Enter Username">
								</div><!-- /.form-group -->
								<div class="form-group">
									<label class="control-label" for="acco_email">E-mail <span></span></label>
									<input type="email" class="form-control required" id="acco_email" name="acco_email" placeholder="example@gmail.com">
								</div><!-- /.form-group -->
							</div><!-- /.col-xs-12 -->
							<div class="col-xs-12 col-md-6">
								<div class="form-group">
									<label class="control-label" for="acco_password">Password <span></span></label>
									<input type="password" class="form-control required" id="acco_password" name="acco_password" placeholder="Password">
								</div><!-- /.form-group -->
								<div class="form-group">
									<label class="control-label" for="acco_password2">Re-Type Password <span></span></label>
									<input type="password" class="form-control required" id="acco_password2" name="acco_password2" placeholder="Password">
								</div><!-- /.form-group -->
							</div><!-- /.col-xs-12 -->
						</div><!-- /.row -->

						<button id="submit-create-account" type="submit" class="btn btn-navy">Create Account</button>

					</form>
				</div><!-- /.col-xs-12 -->

				<?php
				include('template/sidebar.php');
				?>

			</div><!-- /.row -->
		</div><!-- /.container -->

	<?php
	} else {

		include('template/header.php');
	?>

	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<?php
				// no database table
				include('template/msgs/noDatabase.php');
				?>
			</div><!-- /.col-xs-12 -->
		</div><!-- /.row -->
	</div><!-- /.container -->

	<?php
	}

	include('template/footer.php');
?>
