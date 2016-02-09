<div class="navbar navbar-fixed-top navbar-inverse" role="navigation">
	<div class="container">

		<div class="navbar-header">
			<?php
			if($current_page != 'wizard.php') {
			?>
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<?php
			}
			?>
			<a class="navbar-brand" href="<?php echo $base_url; ?>">Table Tennis Manager</a>
		</div><!-- /.navbar-header -->
		<?php
		if($current_page != 'wizard.php') {
		?>
		<div class="collapse navbar-collapse">

			<ul class="nav navbar-nav">
				<li <?php echo isCurrentPage($current_page, ''); ?>>
					<a href="<?php echo $base_url; ?>">Home</a>
				</li>
				<?php
				/*
				<li <?php echo isCurrentPage($current_page, 'about.php'); ?>>
					<a href="<?php echo $base_url; ?>about.php">About</a>
				</li>
				*/
				?>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle " data-toggle="dropdown">League <b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li <?php echo isCurrentPage($current_page, 'rules.php'); ?>>
							<a href="<?php echo $base_url; ?>rules.php">Rules</a>
						</li>
						<li <?php echo isCurrentPage($current_page, 'standings.php'); ?>>
							<a href="<?php echo $base_url; ?>standings.php">Standings</a>
						</li>
						<li <?php echo isCurrentPage($current_page, 'matches.php'); ?>>
							<a href="<?php echo $base_url; ?>matches.php">Matches</a>
						</li>
						<?php
						/*
						<li <?php echo isCurrentPage($current_page, 'compare.php'); ?>>
							<a href="<?php echo $base_url; ?>compare.php">Compare</a>
						</li>
						*/
						?>
					</ul>
				</li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<?php if($loggedin == 0){ ?>
					<li class="dropdown">
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
					</li>
				<?php } else { ?>
					<li><a href="<?php echo $base_url; ?>logout.php">Logout</a></li>
				<?php } ?>
			</ul>

		</div><!-- /.nav-collapse -->
		<?php
		}
		?>

	</div><!-- /.container -->
</div><!-- /.navbar -->
