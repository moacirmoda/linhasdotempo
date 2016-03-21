<?php 
global $post;
global $wpdb;

get_header(); 

$last_month = "";
$last_year = "";

// recuperando todos os anos
$results = $wpdb->get_results( "SELECT YEAR(post_date) as year FROM $wpdb->posts  GROUP BY year", OBJECT );
$years = array();
foreach ($results as $key => $value) {
	$years[] = (int)$value->year;
}

$peridiocidade = array_reverse(array('Dia', 'Mês', 'Ano', 'Década', 'Século'));
$lt_posts = array();
?>

<section id="cd-timeline" class="cd-container">

	<?php foreach($years as $year): $lt_posts[$year] = array(); ?>
		<?php

			$str_querypost = "post_type=event&post_parent=0&posts_per_page=-1&orderby=date";
			if(isset($_REQUEST['lt-year'])) {

				$lt_year = (int)$_REQUEST['lt-year'];
				$str_querypost .= "&year=" . $lt_year;
			} else {
				$str_querypost .= "&year=" . $year;
			}

			if(isset($_REQUEST['lt-order']) and $_REQUEST['lt-order'] == 'desc') {
				$str_querypost .= "&order=desc";
			} else {
				$str_querypost .= "&order=asc";
			}

			foreach(get_posts($str_querypost) as $post) {
				$query = "SELECT meta_value FROM $wpdb->postmeta WHERE post_id = '$post->ID' AND meta_key = 'peridiocidade'"; 
				$result = $wpdb->get_row($query, OBJECT );
				if($result) {
					$lt_posts[$year][$result->meta_value][] = $post;
				}
			}

		// var_dump($lt_posts);
		?>
	<?php endforeach; ?>
		
	<?php foreach($lt_posts as $year => $posts):  ?>

		<?php foreach($peridiocidade as $periodo): ?>

			<?php if(!array_key_exists($periodo, $posts)) continue; ?>
			
			<?php foreach($posts[$periodo] as $post): ?>

				<?php if(get_the_date("Y") != $last_year): ?>
					<div class="cd-timeline-block title">
						<?php if(in_array($periodo, array("Século", "Década"))): ?>
							<div class="cd-timeline-date"><?= get_the_date("Y", $post->ID) ?>-<?= substr(get_field('data_final'), 0, 4); ?></div>
						<?php else: ?>
							<div class="cd-timeline-date"><?= get_the_date("Y", $post->ID) ?></div>
							<?php $last_year = get_the_date("Y"); ?>
						<?php endif; ?>
					</div>
				<?php endif; ?>

				<?php if(get_the_date("m") != $last_month and in_array($periodo, array("Ano", "Mês", "Dia"))): ?>
					<div class="cd-timeline-block title">
						<div class="cd-timeline-date month"><?= ucwords(get_the_date('F', $post->ID)); ?></div>
					</div>
				<?php endif; ?>

				
				<div class="cd-timeline-block">
					<a href="<?php the_permalink(); ?>">
						<div class="cd-timeline-img"></div>

						<div class="cd-timeline-content">
							<div class='flag'></div>
							<span class="cd-date"><?= get_the_date('d \d\e F \d\e Y', $post->ID); ?></span>
							<h2><?= apply_filters('get_the_title', $post->post_title); ?></h2>
							<p><?= apply_filters('get_the_excerpt', $post->post_excerpt); ?></p>
							<p><?= get_excerpt_by_id($post->ID); ?></p>
						</div> <!-- cd-timeline-content -->
					</a>	
				</div> <!-- cd-timeline-block -->
					
				<!-- salvando a última data para comparação -->
				
				<?php $last_month = get_the_date("m"); ?>
		
			<?php endforeach; ?>
		
		<?php endforeach; ?>

	<?php endforeach; ?>
</section> <!-- cd-timeline -->

<?php get_footer(); ?>