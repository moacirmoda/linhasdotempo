
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
    <script>
      $(document).ready(function(){
        $('#searchWP').submit(function(){
          var searchType = $(this).find('input[name="searchIAHX"]:checked').val();
          if (searchType == 'true') {
            $('#searchiHAxForm').find('input[name="q"]').val($(this).find('input[name="s"]').val());
            $('#searchiHAxForm').submit();
            return false;
          }
        });
      });
    </script>
	</body>
</html>
