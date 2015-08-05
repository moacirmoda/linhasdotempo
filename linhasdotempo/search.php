<?php 

global $post;
global $query_string;

$query = new WP_Query($query_string);

if(isset($_GET['s']) and isset($_GET['type']) and $_GET['type'] == 'advanced') {
	
	$args = array(
	    'post_type' => 'event', 
	    'post_status' => 'publish',
	);

	$str_querypost = 'post_type=event';
	
	if(isset($_REQUEST['periodo']) and is_array($_REQUEST['periodo'])) {
		$args['date_query'] = array('relation' => 'OR');
		
		foreach($_REQUEST['periodo'] as $periodo) {
			list($from, $to) = explode('-', $periodo);
			
			// from
			$from_year = substr($from, 0, 4); 
			$from_month = substr($from, 4, 5);

			// to
			$to_year = substr($to, 0, 4);
			$to_month = substr($to, 4, 5);

			// criando os args de período
			$current_period_array = array(
		        'column'  => 'post_date',
		        'after'   => array(
		        	'year' => $from_year,
		        	'month' => $from_month,
		        ),
		        'before'   => array(
		        	'year' => $to_year,
		        	'month' => $to_month,
		        ),
			);

			$args['date_query'][] = $current_period_array;
		}
	}

	if(isset($_REQUEST['_tema']) and is_array($_REQUEST['_tema'])) {
		
		$args['tax_query'] = array();

		foreach($_REQUEST['_tema'] as $tema) {

			$current_tema_array = array(
				'taxonomy' => 'tema',
				'field'    => 'term_id',
				'terms'    => array($tema),
			);
			$args['tax_query'][] = $current_tema_array;
		}
	}

	$query = new WP_Query( $args );
}

get_header(); 
?>

<div class="search-results">

	<div class='container-fluid'>
		<div class='row'>
			<div class='col-md-12'>
				<div class='box-title'>
					<?php if(empty($_REQUEST['s'])): ?>
						<h1>Resultados da busca avançada (<?= $query->found_posts; ?>)</h1>
					<?php else: ?>
						<h1>Resultados para: "<?= $_REQUEST['s']; ?>" (<?= $query->found_posts; ?>)</h1>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>

	<?php while ( $query->have_posts() ) : $query->the_post(); ?>

		<?php // var_dump($post); ?>

		<article class='search'>
			<a href="<?= get_permalink(get_the_ID()); ?>" title="<?php the_title(); ?>">
				<div class='container-fluid'>

					<div class='row'>
						<div class='col-md-12'>
							<h2>
								<?php the_title(); ?>

								<?php if($post->post_type == 'event'): ?>
									(<?= print_date_shortformat(get_field('data_inicio', $child->ID)); ?>
									
									<?php if(get_field('data_final')): ?>
										- <?= print_date_shortformat(get_field('data_final', $child->ID)); ?>
									<?php endif; ?>)

								<?php endif; ?>
							</h2>
						</div>
					</div>

					<div class='content'>
						<div class='row'>
							<div class='col-md-12'>
								<?php the_excerpt(); ?>
							</div>
						</div>
					</div>
			</a>
			</div>
		</article>

	<?php endwhile; ?>

	<div class='container-fluid'>
		<div class='row'>
			<div class='col-md-12'>
				<?php // the_posts_pagination(); ?>
			</div>
		</div>
	</div>
</div>


<?php get_footer(); ?>