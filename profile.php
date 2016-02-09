<?php
	include_once('includes/config.php');
	include_once('includes/database.php');
	include_once('includes/helper.php');

	$isProfile = false;

	// are we looking at someone else's profile?
	// and if actual username
	if(!empty($_GET['username']) && checkUsername($_GET['username'])) {
		//print_r($_GET['username']);

		$username = $_GET['username'];
		// TODO: get name
		$name = $_GET['username'];

		$title = 'Profile | ' . $name;
	} else {
		// Check session
		checksession();

		//echo 'get the current logged in users profile stuff';
		$title = 'My Profile | ' . $_SESSION['name'];
		$isProfile = true;
		$registered = 1;
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
					<a class="btn btn-default pull-right" href="#"><i class="fa fa-pencil"></i> Edit Profile</a>
					<?php
					}
					?>

					<h1 class="page-header">My Profile</h1>

					<div class="clearfix"></div>

					<div class="gravatar invisible pull-left margin-b-5 margin-r-10" data-email="<?php echo md5($_SESSION['email']); ?>" data-username="<?php echo $_SESSION['name']; ?>"></div><!-- /.gravatar -->

					<div class="profile-text">
						<?php
						/* have easter eggs and notify user when they get them! have badges for it or points or something.. idk. */
						?>
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc id augue sit amet neque suscipit venenatis sed et orci.
						Curabitur condimentum scelerisque enim, non dignissim elit ultricies eu. Integer sit amet convallis enim. Vivamus ornare
						libero et tellus egestas blandit. Suspendisse sem orci, faucibus non justo eget, finibus accumsan dui. Aenean rhoncus augue
						nec porta cursus. Nam vel euismod orci, non dignissim lorem. Curabitur nisl eros, semper in molestie nec, pellentesque sit amet metus.
						Vivamus varius ex convallis, tincidunt ante a, porttitor nunc. Integer imperdiet ultrices quam, a ornare tellus. Integer tincidunt
						ligula in purus elementum rutrum. Pellentesque enim quam, finibus in augue eget, consequat elementum eros.</p>

						<p>Aenean molestie vitae lorem et dignissim. Phasellus rhoncus scelerisque erat non tristique. Maecenas mattis arcu turpis, vel
						pulvinar ex luctus vel. Nulla nunc lacus, porta id enim non, dapibus maximus neque. Vestibulum id augue sed velit rhoncus semper.
						Quisque condimentum dui at magna porttitor, nec tincidunt ante iaculis. Integer lacinia posuere eleifend. Nullam dictum massa ipsum,
						vulputate egestas dolor feugiat eget. Curabitur neque nisl, rutrum eget ante et, fringilla commodo lectus. Etiam feugiat mi eu nunc
						venenatis, et pellentesque leo mattis. Nulla facilisi.</p>

						<p>Ut porttitor elit non nisi facilisis feugiat. Mauris feugiat magna et purus dignissim, sit amet mollis sem eleifend. Phasellus
						pulvinar lorem vel ex tempus congue. Fusce iaculis mauris a est commodo, ac sollicitudin ligula convallis. Pellentesque facilisis
						arcu id lorem feugiat, in porta mi volutpat. Nullam molestie ex mi, eget congue nunc accumsan eget. Phasellus et quam lectus.</p>
					</div><!-- /.profile-text -->

					<div class="clearfix"></div>
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
