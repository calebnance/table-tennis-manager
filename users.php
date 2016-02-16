<?php
$registered = 1;
$adminOnly = true;
$title = 'Users List';
include('template/header.php');

if($show_form) {
	include_once('includes/database.php');
	$users = getUsers();
}

// check database table
$response = checkConnection($db_host, $db_name, $db_user, $db_pass);

// database table be there!
if($response['extra'] !== 'showCreateDB') {
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
			<h1 class="page-header">Users List</h1>

			<?php
			if(empty($users)) {
				include('template/msgs/noUsersSet.php');
			} else {
				?>
				<table class="table table-hover table-striped">
					<thead>
						<tr>
							<th></th>
							<th>Name</th>
							<th>Username</th>
							<th class="text-center">Site Admin</th>
							<th class="text-center">Get System E-mails</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach($users as $user) {
							?>
							<tr>
								<td class="text-center v-align-middle width-75">
									<a href="<?= $base_url . 'profile.php?username=' . $user->username; ?>">
										<div class="gravatar noHW invisible pull-left" data-email="<?= md5($user->email); ?>" data-username="<?= $user->username; ?>"></div><!-- /.gravatar -->
									</a>
								</td>
								<td class="v-align-middle">
									<?= $user->name; ?>
								</td>
								<td class="v-align-middle">
									<?= $user->username; ?>
								</td>
								<td class="v-align-middle text-center">
									<?php
									if($user->is_admin) {
									?>
									<div class="label label-success">
										<i class="fa fa-check"></i> Yes
									</div><!-- /.btn -->
									<?php
									} else {
									?>
									<div class="label label-danger">
										<i class="fa fa-times"></i> No
									</div><!-- /.btn -->
									<?php
									}
									?>
								</td>
								<td class="v-align-middle text-center">
									<?php
									if($user->is_admin && $user->receive_email) {
									?>
									<div class="label label-success">
										<i class="fa fa-check"></i> Yes
									</div><!-- /.btn -->
									<?php
									} else {
									?>
									<div class="label label-danger">
										<i class="fa fa-times"></i> No
									</div><!-- /.btn -->
									<?php
									}
									?>
								</td>
								<td class="v-align-middle text-right">
									<a class="btn btn-default" href="<?= $base_url . 'profile.php?username=' . $user->username; ?>">View Profile</a>
								</td>
							</tr>
							<?php
						}
						?>
					</tbody>
				</table>
				<?php
			}
			?>

		</div><!-- /.col-xs-12 -->

		<?php
			include('template/sidebar.php');
		}
		?>

	</div><!-- /.row -->
</div><!-- /.container -->

<?php
} else {
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
