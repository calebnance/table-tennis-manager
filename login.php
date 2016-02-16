<?php
	// login
	$username	= '';
	$pass = '';

	if($_POST){
		// Lets do some checking
		if(empty($_POST['username']) || empty($_POST['password'])){
			if(isset($_POST['username']) || isset($_POST['password'])){
				session_start();
				$_SESSION['msg'] = 'Make sure you fill in your username and password.';
				$_SESSION['msg-type'] = 'danger';
			}
		} else {
			include_once('includes/config.php');
			include_once('includes/database.php');

			$username	= $_POST['username'];
			$pass = $_POST['password'];

			$db = new Database($db_host, $db_name, $db_user, $db_pass);
			$user_info = $db->select('users', '*', 'username="'.$username.'"');

			// is user
			if($user_info){
				$user_pass	= pass_decrypt($user_info[0]['password']);
				// password is with user
				if($user_pass === $pass){
					startsession($user_info, $db);
					$referer = explode('/', $_SERVER['HTTP_REFERER']);
					$refererPage = end($referer);
					// if $referer is set
					// AND if $refererPage's last 4 characters are .php
					// AND if $refererPage doesn't equal login.php page
					if(!empty($refererPage) && (substr($refererPage, -4) == '.php') && $refererPage !== 'login.php') {
						header('location: ' . $refererPage);
					} else {
						header('location: index.php');
					}
					$_SESSION['msg'] = 'You are now logged in!';
					$_SESSION['msg-type'] = 'success';
					exit();
				} else {
					$pass = '';
					session_start();
					$_SESSION['msg'] = 'Password did not match.';
					$_SESSION['msg-type'] = 'danger';
				}
			} else {
				$username = $pass = '';
				session_start();
				$_SESSION['msg'] = 'Username was not found!';
				$_SESSION['msg-type'] = 'danger';
			}

		}
	}

	session_start();
	// are we already logged in?!
	if(!empty($_SESSION['loggedin'])){
		header('location: /');
		$_SESSION['msg'] = 'You are already logged in!';
		$_SESSION['msg-type'] = 'success';
		exit();
	}

	$title = 'Login';
	include('template/header.php');
?>
	<div class="container">
		<div class="row row-offcanvas row-offcanvas-right">

			<div class="col-xs-12 col-sm-9">
				<p class="pull-right visible-xs">
					<button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle</button>
				</p>
				<h1 class="page-header">Login</h1>

				<form class="form-signin" role="form" action="<?php echo $base_url; ?>login.php" method="POST">
					<input type="text" name="username" class="form-control" placeholder="Username" value="<?php echo $username; ?>" required>
					<input type="password" name="password" class="form-control" placeholder="Password" value="<?php echo $pass; ?>" required>
					<button class="btn btn-lg btn-navy btn-block" type="submit">Sign in</button>
					<a href="<?php echo $base_url; ?>create-account.php" class="btn btn-lg btn-navy btn-block">Create Account</a>
				</form>

			</div><!-- /.col-xs-12 -->

			<?php
			include('template/sidebar.php');
			?>

		</div><!-- /.row -->
	</div><!-- /.container -->

<?php
	include('template/footer.php');
?>
