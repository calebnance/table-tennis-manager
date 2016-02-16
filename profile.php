<?php
	include_once('includes/config.php');
	include_once('includes/database.php');
	include_once('includes/helper.php');

	$isProfile = false;

	// Check session
	checksession();

	// are we looking at someone else's profile?
	// and if actual username
	if(!empty($_GET['username']) && checkUsername($_GET['username'])) {
		$username = $_GET['username'];
		$user = getUserByUsername($username);
		// set all the things
		$name = $user->name;
		$email = $user->email;
		$last_login = $user->last_login;
		$title = 'Profile | ' . $name;
		$pageHeading = $name . '\'s Profile';
		// session user and user page the same?
		if($username == $_SESSION['username']) {
			$isProfile = true;
		}
	} else {
		$isProfile = true;
		$registered = 1;
		// set all the things
		$username = $_SESSION['username'];
		$name = $_SESSION['name'];
		$email = $_SESSION['email'];
		$last_login = $_SESSION['last_login'];
		if(!empty($name)) {
			$title = 'My Profile | ' . $name;
		} else {
			$title = 'My Profile | No Access';
		}
		$pageHeading = 'My Profile';
	}

	include('template/header.php');
?>
	<div class="container">
		<div class="row row-offcanvas row-offcanvas-right">
			<?php
			if($show_form) {
			?>
				<div class="col-xs-12 col-sm-9">
					<p class="pull-right visible-xs">
						<button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle</button>
					</p>

					<?php
					if($isProfile) {
					?>
					<a class="btn btn-default pull-right" href="/edit/profile.php"><i class="fa fa-pencil"></i> Edit Profile</a>
					<?php
					}
					?>

					<h1 class="page-header"><?= $pageHeading; ?></h1>

					<div class="clearfix"></div>

					<div class="gravatar invisible pull-left margin-b-5 margin-r-10" data-email="<?php echo md5($email); ?>" data-username="<?php echo $username; ?>"></div><!-- /.gravatar -->

					<div class="profile-text">
						<p class="lead margin-b-10">
							Last Login: <?php echo date('m-d-Y g:ha', strtotime($last_login)); ?>
						</p>
						<?php
						/* have easter eggs and notify user when they get them! have badges for it or points or something.. idk.
						?>
						<p>TODO::About</p>
						<p>TODO::Badges Earned</p>
						<?php
						*/
						?>
					</div><!-- /.profile-text -->

					<div class="clearfix"></div>
					<?php
					/*
					<h3>This Season Stats</h3>
					<table class="table">
						<tbody>
							<tr>
								<td><strong>Total Games Played:</strong></td>
								<td>100</td>
								<td><strong>Winning Percentage:</strong></td>
								<td>90%</td>
							</tr>
							<tr>
								<td><strong>Games Won:</strong></td>
								<td>90</td>
								<td><strong>Games Lost:</strong></td>
								<td>10</td>
						</tbody>
					</table>

					<h3>Lifetime Stats</h3>
					<table class="table">
						<tbody>
							<tr>
								<td><strong>Total Games Played:</strong></td>
								<td>100</td>
								<td><strong>Winning Percentage:</strong></td>
								<td>90%</td>
							</tr>
							<tr>
								<td><strong>Games Won:</strong></td>
								<td>90</td>
								<td><strong>Games Lost:</strong></td>
								<td>10</td>
						</tbody>
					</table>
					*/
					?>

				</div><!-- /.col-xs-12 -->

				<?php
				include('template/sidebar.php');
			}
			?>

		</div><!-- /.row -->
	</div><!-- /.container -->

<?php
	include('template/footer.php');
?>
