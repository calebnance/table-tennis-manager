<?php
	$title 			= 'Installation';
	$root_path  = '../';
	$dir_deep   = 'install';
	include('../template/header.php');
	// Include page js
	$scripts[] = $js . 'classie.js';
	$scripts[] = $js . 'text-input-effects.js';
?>
	<div class="container">
		<div class="row row-offcanvas row-offcanvas-right">

			<div class="col-xs-12">

				<h1 class="page-header">Installation Wizard</h1>

				<div id="wizard" class="well" role="tabpanel">

					<!-- Nav tabs -->
					<ul class="nav nav-tabs" role="tablist">
						<li role="presentation" class="active">
							<a href="#step1" aria-controls="step1" role="tab" data-toggle="tab">Step 1</a>
						</li>
						<li role="presentation">
							<a href="#step2" aria-controls="step2" role="tab" data-toggle="tab">Step 2</a>
						</li>
						<li role="presentation">
							<a href="#step3" aria-controls="step3" role="tab" data-toggle="tab">Step 3</a>
						</li>
						<li role="presentation">
							<a href="#step4" aria-controls="step4" role="tab" data-toggle="tab">Step 4</a>
						</li>
					</ul>

					<!-- Tab panes -->
					<div class="tab-content">
						<div role="tabpanel" class="tab-pane fade in active" id="step1">
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
								</div><!-- /.row -->
							</div>

						</div><!-- /#step1 -->
						<div role="tabpanel" class="tab-pane fade" id="step2">
							profile
						</div><!-- /#step2 -->
						<div role="tabpanel" class="tab-pane fade" id="step3">messages</div>
						<div role="tabpanel" class="tab-pane fade" id="step4">settings</div>
					</div>

				</div>

			</div><!--/span-->

			<?php include($root_path . 'template/sidebar.php'); ?>

		</div><!--/.row-->
	</div><!--/.container-->

<?php
	include($root_path . 'template/footer.php');
?>
