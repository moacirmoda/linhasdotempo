<?php

$years = $wpdb->get_results( "SELECT YEAR(post_date) AS year FROM wp_posts WHERE post_type = 'event' AND post_status = 'publish' GROUP BY year DESC" );

?>

<form action="<?php bloginfo('wpurl'); ?>" action='GET' id='formSearchBar'>
	<input type='hidden' name='lt-year' id='formSearchBarYear' value='<?= $_REQUEST['lt-year']; ?>'>
	<input type='hidden' name='lt-order' id='formSearchBarOrder' value='<?= $_REQUEST['lt-order']; ?>'>
</form>

<div class='search-bar'>
	<div class='container-fluid'>
		<div class='row'>
			<div class='col-md-2 logo'>
			</div>
			
			<div class='col-md-6 search'>
				<form action="<?php bloginfo('siteurl'); ?>" action="GET">
				<!-- <input type="hidden" name="post_type" value="event" /> -->
					<input type="text" placeholder='Buscar' name='s'>
				</form>
			</div>
			
			<div class='col-md-2 visao'>
				<select class='submit-on-change' data-form-name="formSearchBar" data-field-name='lt-order'>
					<option value='asc' <?php if($_REQUEST['lt-order'] != 'desc') echo 'selected="true"'; ?>>Ascendente</option>
					<option value='desc' <?php if($_REQUEST['lt-order'] == 'desc') echo 'selected="true"'; ?>>Descendente</option>
				</select>
			</div>

			<div class='col-md-2 ano'>
				<select class='submit-on-change' data-form-name="formSearchBar" data-field-name='lt-year'>
					<option value="">Ano:</option>
					<?php foreach($years as $year): ?>
						<?php if(isset($_REQUEST['lt-year']) and $_REQUEST['lt-year'] == $year->year): ?>
							<option selected><?= $year->year; ?></option>
						<?php else: ?>
							<option ><?= $year->year; ?></option>
						<?php endif; ?>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
	</div>
</div>

<script>
	
</script>
