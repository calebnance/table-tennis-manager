<?php
	$title = 'Create Account';
		
	include('template/header.php');
	
	// Include page js
	$scripts[] = $js . 'create-account.js';

	if($_POST){
		print_r($_POST);
	}
	
?>
	<div class="container">
		<div class="row row-offcanvas row-offcanvas-right">
			
			<div class="col-xs-12 col-sm-9">
				<p class="pull-right visible-xs">
					<button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle</button>
				</p>
				<h1 class="page-header">Create Account</h1>
				
				<form role="form" action="create-account.php" method="POST">
					
					<div class="form-group">
						<label for="acco_name">Name</label>
						<input type="email" class="form-control required" id="acco_name" name="acco_name" placeholder="Enter Name">
					</div>
					<div class="form-group">
						<label for="acco_email">E-mail</label>
						<input type="email" class="form-control required" id="acco_email" name="acco_email" placeholder="example@gmail.com">
					</div>
					<div class="form-group">
						<label for="acco_password">Password</label>
						<input type="password" class="form-control required" id="acco_password" name="acco_password" placeholder="Password">
					</div>
					<div class="form-group">
						<label for="acco_password2">Re-Type Password</label>
						<input type="password" class="form-control required" id="acco_password2" name="acco_password2" placeholder="Password">
					</div>
					<button id="submit-create-account" type="submit" class="btn btn-navy">Create Account</button>
				</form>
				
			</div><!--/span-->
			
			<?php include('template/sidebar.php'); ?>
			
		</div><!--/.row-->
	</div><!--/.container-->


<?php
	include('template/footer.php');
?>