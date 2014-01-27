<?php
	$title = 'Matches';
	include('template/header.php');
?>
	<div class="container">
		<div class="row row-offcanvas row-offcanvas-right">
			
			<div class="col-xs-12 col-sm-9">
				<p class="pull-right visible-xs">
					<button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle</button>
				</p>
				<h1 class="page-header">Matches <small>(not yet working)</small></h1>
				
				<div class="table-responsive">
					<table class="table table-striped table-bordered">
						<thead>
							<tr>
								<th class="text-right"><a href="#" class="btn btn-default btn-xs pull-left"><span class="glyphicon glyphicon-sort-by-order"></span></a> #<span class="clearfix"></span></th>
								<th class="text-right">Player 1</th>
								<th></th>
								<th class="text-left">Player 2</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td class="text-right">1</td>
								<td class="text-right">FName LName - 7</td>
								<td class="text-center">vs</td>
								<td class="text-left">LName FName - 11</td>
								<td><a href="#" class="btn btn-default"><span class="glyphicon glyphicon-wrench"></span></td>
							</tr>
							<tr>
								<td class="text-right">2</td>
								<td class="text-right">FName LName - 3</td>
								<td class="text-center">vs</td>
								<td class="text-left">LName FName - 11</td>
								<td><a href="#" class="btn btn-default"><span class="glyphicon glyphicon-wrench"></span></td>
							</tr>
							<tr>
								<td class="text-right">3</td>
								<td class="text-right">FName LName</td>
								<td class="text-center">vs</td>
								<td class="text-left">LName FName</td>
								<td><a href="#" class="btn btn-default"><span class="glyphicon glyphicon-wrench"></span></td>
							</tr>
							<tr>
								<td class="text-right">4</td>
								<td class="text-right">FName LName</td>
								<td class="text-center">vs</td>
								<td class="text-left">LName FName</td>
								<td><a href="#" class="btn btn-default"><span class="glyphicon glyphicon-wrench"></span></td>
							</tr>
							<tr>
								<td class="text-right">5</td>
								<td class="text-right">FName LName</td>
								<td class="text-center">vs</td>
								<td class="text-left">LName FName</td>
								<td><a href="#" class="btn btn-default"><span class="glyphicon glyphicon-wrench"></span></td>
							</tr>
							<tr>
								<td class="text-right">6</td>
								<td class="text-right">FName LName</td>
								<td class="text-center">vs</td>
								<td class="text-left">LName FName</td>
								<td><a href="#" class="btn btn-default"><span class="glyphicon glyphicon-wrench"></span></td>
							</tr>
						</tbody>
					</table>
				</div><!-- /.table-responsive -->
				
			</div><!--/span-->
			
			<?php include('template/sidebar.php'); ?>
			
		</div><!--/.row-->
	</div><!--/.container-->


<?php
	include('template/footer.php');
?>