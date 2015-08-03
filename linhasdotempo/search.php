<?php 

get_header(); 
global $post;

$_POST_TYPES_LABEL = array(
	'page' => "página",
	'post' => "notícia",
	'event' => "evento",
);

?>

<div class="search-results">

	<div class='container-fluid'>
		<div class='row'>
			<div class='col-md-12'>
				<div class='box-title'>
					<h1>Resultados para: "<?= $_REQUEST['s']; ?>" (<?= $wp_query->found_posts; ?>)</h1>
				</div>
			</div>
		</div>
	</div>

	<?php while ( have_posts() ) : the_post(); ?>

		<?php // var_dump($post); ?>

		<article class='search'>
			<a href="<?= get_permalink(get_the_ID()); ?>" title="<?php the_title(); ?>">
				<div class='container-fluid'>

					<div class='row'>
						<div class='col-md-12'>
							<h2>
								<!-- <small><?= $_POST_TYPES_LABEL[$post->post_type]; ?></small> -->
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
				<?php the_posts_pagination(); ?>
			</div>
		</div>
	</div>
</div>


<?php get_footer(); ?>