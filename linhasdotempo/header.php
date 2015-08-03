<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	
	<!-- <link rel="stylesheet" href="http://codyhouse.co/demo/vertical-timeline/css/reset.css"> -->
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/static/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>">

	<title><?php is_front_page() ? bloginfo('description') : wp_title(''); ?> | <?php bloginfo('name'); ?></title>

	<!--[if lt IE 9]>
	<script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/html5.js"></script>
	<![endif]-->
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<header>
		<div class='main-header'>
			<div class='container-fluid'>
				<div class='row first'>
					<div class='col-md-3'>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class='main-logo' title="<?php bloginfo( 'name' ); ?>"><img src="<?php bloginfo('stylesheet_directory'); ?>/static/img/logo-header.png" title="<?php bloginfo( 'name' ); ?>" width='70%' /></a>
					</div>
					<div class='col-md-3'>
						<a href="#" class='sub-logo' title="<?php bloginfo( 'description' ); ?>"><img src="<?php bloginfo('stylesheet_directory'); ?>/static/img/sublogo-header.png" title="<?php bloginfo( 'description' ); ?>" width='70%'/></a>
					</div>
					<div class='col-md-3'></div>
					<div class='col-md-3'>
						<ul class='institucional-logos'>
							<li><a href="#" title="Fundação Oswaldo Cruz"><img src="<?php bloginfo('stylesheet_directory'); ?>/static/img/fiocruz-logo.png" title="Fundação Oswaldo Cruz" width='70%' /></a></li>
							<li><a href="#" title="Fundação Oswaldo Cruz"><img src="<?php bloginfo('stylesheet_directory'); ?>/static/img/bvslogo.png" title="Fundação Oswaldo Cruz" width='70%' /></a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>

		<div id='menu'>
			<div class='container-fluid'>
				<div class='row'>
					<?php wp_nav_menu(); ?>
				</div>
			</div>
		</div>
		
		<!-- search bar -->
		<?php include 'search-bar.php'; ?>

	</header>