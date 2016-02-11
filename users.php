<?php
$registered = 1;
$title = 'Users List';
include('template/header.php');

if($show_form) {
	include_once('includes/database.php');
	$users = getUsers();
}

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
				<table class="table">
					<thead>
						<tr>
							<th>Name</th>
							<th>Username</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach($users as $user) {
							?>
							<tr>
								<td>
									<?php
									/* TODO
									<div class="gravatar invisible pull-left margin-b-5 margin-r-10" data-email="<?= md5($user->email); ?>" data-username="<?= $user->username; ?>"></div><!-- /.gravatar -->
									*/
									?>
									<?= $user->name; ?>
								</td>
								<td>
									<?= $user->username; ?>
								</td>
								<td class="text-right">
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
include('template/footer.php');
?>
