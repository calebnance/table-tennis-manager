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
	</body>
</html>