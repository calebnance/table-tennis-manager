<?php
	// login
	$username	= '';
	$pass		= '';
	if($_POST){
		// Lets do some checking
		if(empty($_POST['username']) || empty($_POST['password'])){
			if(isset($_POST['username']) || isset($_POST['password'])){
				$msg = 'Make sure you fill in your username and password.';
			}
		} else {
			include_once('includes/config.php');
			include_once('includes/database.php');
			
			$username	= $_POST['username'];
			$pass		= $_POST['password'];
			
			$db = new Database($db_host, $db_name, $db_user, $db_pass);
			$user_info = $db->select('users', '*', 'username="'.$username.'"');
			if($user_info){
				$user_pass	= pass_decrypt($user_info[0]['password']);
				if($user_pass === $pass){
					startsession($user_info, $db);
					header('location: index.php?msg=1');
					exit();
				} else {
					$pass = '';
					$msg = '<div class="alert alert-info alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Password did not match.</div>';
				}
			} else {
				$username = $pass = '';
				$msg = '<div class="alert alert-info alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Username was not found!</div>';
			}
		
		}
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
				
			</div><!--/span-->
			
			<?php include('template/sidebar.php'); ?>
			
		</div><!--/.row-->
	</div><!--/.container-->


<?php
	include('template/footer.php');
?>