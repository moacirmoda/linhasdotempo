
		<footer>
			<div class="container-fluid">
				<div class='row'>
					<div class='col-md-7'>
						
						<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('left-footer') ) :
							get_sidebar('left-footer');
						endif ?>

					</div>
					<div class='col-md-5'>

						<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('right-footer') ) :
							get_sidebar('right-footer');
						endif ?>
					</div>
				</div>
			</div>
		</footer>

		<?php wp_footer(); ?>
		<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
		<script src="<?php bloginfo('stylesheet_directory'); ?>/static/js/scripts.js"></script>
	</body>
</html>