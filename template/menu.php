<div class="navbar navbar-fixed-top navbar-inverse" role="navigation">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="<?php echo $base_url; ?>">Table Tennis</a>
		</div><!-- /.navbar-header -->
		<div class="collapse navbar-collapse">
			<ul class="nav navbar-nav">
				<li <?php if($current_page == ''){ echo 'class="active"'; } ?>><a href="<?php echo $base_url; ?>">Home</a></li>
				<li <?php if($current_page == 'standings.php'){ echo 'class="active"'; } ?>><a href="<?php echo $base_url; ?>standings.php">Standings</a></li>
				<li <?php if($current_page == 'rules.php'){ echo 'class="active"'; } ?>><a href="<?php echo $base_url; ?>rules.php">Rules</a></li>
				<li <?php if($current_page == 'compare.php'){ echo 'class="active"'; } ?>><a href="<?php echo $base_url; ?>compare.php">Compare</a></li>
				<li <?php if($current_page == 'about.php'){ echo 'class="active"'; } ?>><a href="<?php echo $base_url; ?>about.php">About</a></li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
					<?php if($loggedin == 0){ ?>
						<a href="#" class="dropdown-toggle " data-toggle="dropdown">Login <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li>
								<form class="form-signin" role="form" action="login.php" method="POST">
									<input type="text" name="username" class="form-control" placeholder="Username" required>
									<input type="password" name="password" class="form-control" placeholder="Password" required>
									<button class="btn btn-lg btn-navy btn-block" type="submit">Sign in</button>
									<a href="<?php echo $base_url; ?>create-account.php" class="btn btn-lg btn-navy btn-block">Create Account</a>
								</form>
							</li>
						</ul>
					<?php } else { ?>
						<a href="<?php echo $base_url; ?>logout.php">Logout</a>
					<?php } ?>
				</li>
			</ul>
		</div><!-- /.nav-collapse -->
	</div><!-- /.container -->
</div><!-- /.navbar -->	