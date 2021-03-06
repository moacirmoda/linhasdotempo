<?php

define( 'WPCF7_ADMIN_READ_CAPABILITY', 'manage_options' );
define( 'WPCF7_ADMIN_READ_WRITE_CAPABILITY', 'manage_options' );

$MONTHS = array('', 'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro');

// sidebars
if ( function_exists('register_sidebar') ) {
	register_sidebar(array(
		'name' => 'Rodapé - Esquerda',
		'id' => 'left-footer',
		'description' => 'Os ítens colocados aqui aparecerão na esquerda do rodapé do portal.',
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '',
		'after_title' => '',
	));

	register_sidebar(array(
		'name' => 'Rodapé - Direita',
		'id' => 'right-footer',
		'description' => 'Os ítens colocados aqui aparecerão na direita do rodapé do portal.',
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '',
		'after_title' => '',
	));
}

// menu
function register_my_menu() {
	register_nav_menu('main-menu',__( 'Menu Principal' ));
}
add_action( 'init', 'register_my_menu' );

function print_date($date) {

	global $MONTHS;
	// $date tem que vir no formato 20150618
	$output = "";

	$year = substr($date, 0, 4);
	$month = (int) substr($date, 4, 2);
	$day = substr($date, 6, 2);

	return $day . " de " . $MONTHS[$month] . " de " . $year;
}

function print_date_shortformat($date) {
	
	$year = substr($date, 0, 4);
	$month = substr($date, 4, 2);
	$day = substr($date, 6, 2);

	return $day . "/" . $month . "/" . $year;	
}

// hook para fazer com que a data de publicação seja a data do evento
function linhasdotempo_hook_publish_time( $post_id ) {

	$correct_date = get_field('data_inicio', $post_id);

	if(!$correct_date)
		return;
	
	$date = DateTime::createFromFormat('Ymd', $correct_date);
    $date = $date->format('Y-m-d');

    // unhook this function so it doesn't loop infinitely
	remove_action( 'save_post', 'linhasdotempo_hook_publish_time' );

	// update the post, which calls save_post again
	wp_update_post( array( 'ID' => $post_id, 'post_date' => $date ) );

	// re-hook this function
	add_action( 'save_post', 'linhasdotempo_hook_publish_time' );
}

add_action( 'save_post', 'linhasdotempo_hook_publish_time' );

add_action('in_admin_footer', 'foot_monger');
function foot_monger() { ?>

	<script type='text/javascript'>
		$ = jQuery;

		// escondendo o item ordem
		var order_input = $("#pageparentdiv #menu_order").closest('p');
		order_input.prev('p').hide();
		order_input.hide();

		// escondendo ítens não utilizados no painel
		$("#menu-posts").hide();
		$("#menu-comments").hide();
    </script>
<?php } 

function get_excerpt_by_id($post_id){
    $the_post = get_post($post_id); //Gets post ID
    $the_excerpt = $the_post->post_content; //Gets post_content to be used as a basis for the excerpt
    $excerpt_length = 35; //Sets excerpt length by word count
    $the_excerpt = strip_tags(strip_shortcodes($the_excerpt)); //Strips tags and images
    $words = explode(' ', $the_excerpt, $excerpt_length + 1);

    if(count($words) > $excerpt_length) :
        array_pop($words);
        array_push($words, '…');
        $the_excerpt = implode(' ', $words);
    endif;

    $the_excerpt = '<p>' . $the_excerpt . '</p>';

    return $the_excerpt;
}

function acf_load_value_references( $value, $post_id, $field ) {

  if (empty($value)) {
    global $wpdb;
    $value = $wpdb->get_var('SELECT meta_value FROM '.$wpdb->prefix.'postmeta WHERE meta_key = "referencias" ORDER BY meta_id DESC LIMIT 1');
  }

  return $value;
}
add_filter('acf/load_value/name=referencias', 'acf_load_value_references', 10, 3);

add_action( 'admin_init', 'bvs_settings' );
function bvs_settings(){

  register_setting(
    'general',
    'ihax_url',
    'sanitize_settings'
  );
  add_settings_section(
    'bvs_settings',
    'Configurações da BVS',
    'bvs_settings_section_description',
    'general'
  );
  add_settings_field(
    'ihax_url',
    'iHAx URL',
    'bvs_settings_ihax_url_field_callback',
    'general',
    'bvs_settings'
  );

  add_option('ihax_url', 'http://pesquisa.bvsalud.org/enfermeria/');
}

function bvs_settings_ihax_url_field_callback() {
  ?>
  <label for="ihax_url">
    URL de busca do iHAx
  </label>
  <input id="ihax_url" type="text" value="<?php echo get_option( 'ihax_url') ?>" name="ihax_url">
  <?php
}

function sanitize_settings( $input ) {
  return $input;
}

function bvs_settings_section_description() {
  echo wpautop( "Configurações da BVS" );
}
