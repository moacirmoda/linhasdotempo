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
      
      <form action="<?php bloginfo('siteurl'); ?>" action="GET" id="searchWP">
        <div class='col-md-6 search'>
          <!-- <input type="hidden" name="post_type" value="event" /> -->
          <input type="text" placeholder='Buscar' name='s'>
        </div>
        <div class='col-md-2'>
          <div class='radio'>
            <label style='padding-top: 10px;'>
              <input name='searchIAHX' type='radio' value='false' style='width: 12px; margin-top: 20px;' checked /> Pesquisar na BVS
            </label>
          </div>
        </div>
        <div class='col-md-2'>
          <label>
            <input name='searchIAHX' type='radio' value='true' style='width: 12px; margin-top: 20px;' /> Pesquisar no iAHx
          </label>
        </div>
        <div class='col-md-2'>
          <button type='submit' class='btn btn-lg' style='background-color: #cdb995; margin-top: 2px;'>Pesquisar</button>
        </div>
      </form>
      <form action="<?php echo get_option('ihax_url') ?>" method="get" target="_blank" id="searchiHAxForm" style="display: none;">
        <input type="hidden" name="output" value="site" />
        <input type="hidden" name="lang" value="pt" />
        <input type="hidden" name="from" value="0" />
        <input type="hidden" name="sort" value="" />
        <input type="hidden" name="format" value="summary" />
        <input type="hidden" name="count" value="20" />
        <input type="hidden" name="fb" value="" />
        <input type="hidden" name="page" value="1" />
        <input type="hidden" name="search_form_submit" value="Pesquisar" />
        <input type="hidden" name="index" value="tw" />
        <input type="hidden" name="q" value="" />
      </form>

		</div>
	</div>
</div>

<script>
	
</script>
