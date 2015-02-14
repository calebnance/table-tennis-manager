<?php
	$title 			= 'Installation';
	$root_path  = '../';
	$dir_deep   = 'install';
	include('../template/header.php');
	// Include page js
	$scripts[] = $js . 'classie.js';
	$scripts[] = $js . 'text-input-effects.js';
	$scripts[] = $js . 'wizard.js';
?>
	<div class="container">
		<div class="row row-offcanvas row-offcanvas-right">

			<div class="col-xs-12">

				<h1 class="page-header">Installation Wizard</h1>

				<div id="wizard" class="well" role="tabpanel">

					<!-- Nav tabs -->
					<ul class="nav nav-tabs" role="tablist" id="tab-wizard">
						<li role="presentation" class="active">
							<a href="#step1" aria-controls="step1" role="tab" data-toggle="tab">Step 1</a>
						</li>
						<li role="presentation">
							<a href="#step2" aria-controls="step2" role="tab" data-toggle="tab">Step 2</a>
						</li>
						<?php
						/*
						<li role="presentation">
							<a href="#step3" aria-controls="step3" role="tab" data-toggle="tab">Step 3</a>
						</li>
						<li role="presentation">
							<a href="#step4" aria-controls="step4" role="tab" data-toggle="tab">Step 4</a>
						</li>
						*/
						?>
					</ul>

					<!-- Tab panes -->
					<div class="tab-content">
						<div role="tabpanel" class="tab-pane fade in active step1" id="step1" data-complete="0">
							<h3>Connect Database</h3>

							<div>
								<div class="row">
									<div class="col-md-6">
										<span class="input input--jiro">
											<input class="input__field input__field--jiro required" type="text" id="dbHost" />
											<label class="input__label input__label--jiro" for="dbHost">
												<span class="input__label-content input__label-content--jiro">Database Host</span>
											</label>
										</span>
										<span class="input input--jiro">
											<input class="input__field input__field--jiro required" type="text" id="dbTable" />
											<label class="input__label input__label--jiro" for="dbTable">
												<span class="input__label-content input__label-content--jiro">Database Name</span>
											</label>
										</span>
									</div><!-- /.col-md-6 -->
									<div class="col-md-6">
										<span class="input input--jiro">
											<input class="input__field input__field--jiro required" type="text" id="dbUser" />
											<label class="input__label input__label--jiro" for="dbUser">
												<span class="input__label-content input__label-content--jiro">Database User</span>
											</label>
										</span>
										<span class="input input--jiro">
											<input class="input__field input__field--jiro required" type="text" id="dbPass" />
											<label class="input__label input__label--jiro" for="dbPass">
												<span class="input__label-content input__label-content--jiro">Database Password</span>
											</label>
										</span>
									</div><!-- /.col-md-6 -->

									<div class="col-md-12">
										<a href="#" class="btn btn-default pull-right display-none" id="gotoStep2">Step 2 <i class="fa fa-chevron-right"></i></a>
										<a href="#" class="btn btn-default pull-left display-none" id="check-connection">Check Connection</a>
										<div class="clearfix"></div>
										<div id="errorMsg"></div><!-- /#errorMsg -->
										<div class="clearfix"></div>
									</div><!-- /.col-md-12 -->

								</div><!-- /.row -->
							</div>

						</div><!-- /#step1 -->
						<div role="tabpanel" class="tab-pane fade step2" id="step2" data-complete="0">
							<h3>Administrator Setup</h3>

							<div>
								<div class="row">
									<div class="col-md-12">
										<span class="input input--jiro">
											<input class="input__field input__field--jiro required" type="text" id="username" />
											<label class="input__label input__label--jiro" for="username">
												<span class="input__label-content input__label-content--jiro">Username</span>
											</label>
										</span>
										<span class="input input--jiro">
											<input class="input__field input__field--jiro required" type="password" id="password" />
											<label class="input__label input__label--jiro" for="password">
												<span class="input__label-content input__label-content--jiro">Password</span>
											</label>
										</span>
									</div><!-- /.col-md-12 -->

									<div class="col-md-12">
										<a href="#" class="btn btn-default pull-right display-none" id="complete-install">Complete Install</a>
										<a href="#" class="btn btn-default pull-left" id="gobackStep2"><i class="fa fa-chevron-left"></i> Step 2</a>
										<div class="clearfix"></div>
									</div><!-- /.col-md-12 -->

								</div><!-- /.row -->
							</div>
						</div><!-- /#step2 -->
						<?php
						/*
						<div role="tabpanel" class="tab-pane fade step3" id="step3" data-complete="0">
							messages
						</div><!-- /#step3 -->
						<div role="tabpanel" class="tab-pane fade step4" id="step4" data-complete="0">
							settings
						</div><!-- /#step4 -->
						*/
						?>
					</div>

				</div><!-- /#wizard -->

				<div class="well display-none" id="installing">
					<div class="jumbotron text-align-center margin-b-0">
						<i class="fa fa-spinner fa-spin margin-r-10" id="installing-loader"></i>
						<p class="lead margin-b-10">Installing<span id="dot-loader"></span></p>
						<p class="lead margin-b-20" id="installation-text">Saving Database Connection</p>

						<div class="progress margin-b-0">
							<div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
								0%
							</div><!-- /.progress-bar -->
						</div><!-- /.progress -->

					</div><!-- /.jumbotron -->
				</div><!-- /#complete -->

				<div class="well display-none" id="complete">
					<div class="jumbotron text-align-center margin-b-0">
						<h1><i class="fa fa-check"></i> Installation is Complete</h1>
						<p class="lead">You may now start your league!</p>
						<a href="../index.php" class="btn btn-primary btn-lg margin-b-0">Home</a>
					</div><!-- /.jumbotron -->
				</div><!-- /#complete -->

			</div><!--/.col-xs-12 -->

			<?php include($root_path . 'template/sidebar.php'); ?>

		</div><!--/.row-->
	</div><!--/.container-->

<?php
	include($root_path . 'template/footer.php');
?>
