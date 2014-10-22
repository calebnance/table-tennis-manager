<?php
	// message
	if(isset($_GET) && $_GET['msg']){
		if($_GET['msg'] == 1){
			$msg = '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>You are now logged in!</div>';
		}
		if($_GET['msg'] == 2){
			$msg = '<div class="alert alert-info alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>You have been logged out due to inactivity.</div>';
		}
		if($_GET['msg'] == 3){
			$msg = '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>You are now logged out!</div>';
		}
		if($_GET['msg'] == 4){
			$msg = '<div class="alert alert-info alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>You do not have access to this page.</div>';
		}
	}
	include('template/header.php');
?>
	<div class="container">
		<div class="row row-offcanvas row-offcanvas-right">

			<div class="col-xs-12 col-sm-9">
				<p class="pull-right visible-xs">
					<button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle</button>
				</p>

				<div class="jumbotron">
					<?php if($loggedin == 0){ ?>
						<h1>Welcome</h1>
						<a href="create-account.php" class="btn btn-default btn-lg"><span class="glyphicon glyphicon-pencil"></span> Create Account</a>
						<a href="<?php echo $base_url; ?>login.php" id="login-button" class="btn btn-default btn-lg"><span class="glyphicon glyphicon-user"></span> Login</a>
					<?php } else { ?>
						<h1>Welcome, <?php echo $_SESSION['username']; ?></h1>
						<a href="<?php echo $base_url; ?>logout.php" id="login-button" class="btn btn-default btn-lg"><span class="glyphicon glyphicon-user"></span> Logout</a>
					<?php } ?>
				</div><!-- /.jumbotron -->

			</div><!--/span-->

			<?php include('template/sidebar.php'); ?>

		</div><!--/.row-->
	</div><!--/.container-->


<?php
	include('template/footer.php');
?>
