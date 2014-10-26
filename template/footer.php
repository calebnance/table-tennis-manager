		<div class="container">

			<hr />

			<footer>
				<p>Table Tennis Manager | <?php echo date('Y'); ?></p>
			</footer>

		</div><!-- /.container -->

		<!-- Le javascript -->
		<?php
		foreach($scripts as $script){
			echo sprintf('<script src="%s"></script>' . "\n", $script);
		}
		?>
		<!-- Le css -->
		<?php
		if(isset($post_styles)){
			foreach($post_styles as $post_style){
				echo sprintf('<link href="%s" rel="stylesheet" type="text/css">' . "\n", $post_style);
			}
		}
		?>
	</body>
</html>
