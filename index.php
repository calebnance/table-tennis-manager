<?php
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
						<a href="create-account.php" class="btn btn-default btn-lg"><span class="fa fa-pencil"></span> Create Account</a>
						<a href="<?php echo $base_url; ?>login.php" id="login-button" class="btn btn-default btn-lg"><span class="fa fa-sign-in"></span> Login</a>
					<?php } else { ?>
						<h1>Welcome, <?php echo $_SESSION['username']; ?></h1>
						<a href="<?php echo $base_url; ?>logout.php" id="login-button" class="btn btn-default btn-lg"><span class="fa fa-sign-out"></span> Logout</a>
					<?php } ?>
				</div><!-- /.jumbotron -->

			</div><!-- /.col-xs-12 -->

			<?php
			include('template/sidebar.php');
			?>

		</div><!-- /.row -->
	</div><!-- /.container -->

<?php
	include('template/footer.php');
?>
