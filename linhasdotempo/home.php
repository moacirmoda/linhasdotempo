<?php 
get_header(); 
global $post;

$last_month = "";
$last_year = "";
?>

<section id="cd-timeline" class="cd-container">
	<?php

		$str_querypost = 'post_type=event&post_parent=0&posts_per_page=-1&orderby=date';
		if(isset($_REQUEST['lt-year'])) {

			$lt_year = (int)$_REQUEST['lt-year'];
			$str_querypost .= "&year=" . $lt_year;
		}

		if(isset($_REQUEST['lt-order']) and $_REQUEST['lt-order'] == 'desc') {
			$str_querypost .= "&order=desc";
		} else {
			$str_querypost .= "&order=asc";
		}

		// print $str_querypost;
		query_posts($str_querypost); 
	?>
	
	<?php while ( have_posts() ) : the_post(); ?>

		<?php if(get_the_date("Y") != $last_year): ?>
			<div class="cd-timeline-block title">
				<div class="cd-timeline-date"><?= get_the_date("Y") ?></div>
			</div>
		<?php endif; ?>

		<?php if(get_the_date("m") != $last_month): ?>
			<div class="cd-timeline-block title">
				<div class="cd-timeline-date month"><?= ucwords(get_the_date('F')); ?></div>
			</div>
		<?php endif; ?>

		
		<div class="cd-timeline-block">
			<a href="<?php the_permalink(); ?>">
				<div class="cd-timeline-img"></div>

				<div class="cd-timeline-content">
					<div class='flag'></div>
					<span class="cd-date"><?php the_date('d \d\e F \d\e Y'); ?></span>
					<h2><?php the_title(); ?></h2>
					<p><?php the_excerpt(); ?></p>
				</div> <!-- cd-timeline-content -->
			</a>	
		</div> <!-- cd-timeline-block -->
			
		<!-- salvando a última data para comparação -->
		<?php $last_year = get_the_date("Y"); ?>
		<?php $last_month = get_the_date("m"); ?>

	<?php endwhile; ?>
</section> <!-- cd-timeline -->

<?php get_footer(); ?>