<?php 

get_header(); 
global $post;

?>


<?php while ( have_posts() ) : the_post(); ?>

	<article class='page'>
		<div class='container-fluid'>

			<div class='title-box'>
				<div class='row'>
					<div class='col-md-12'>
						<h1><a href="<?= get_permalink(get_the_ID()); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h1>
					</div>
				</div>
			</div>

			<div class='article-content'>
				<div class='row'>
					<div class='col-md-12'>
						<?php the_content(); ?>
					</div>
				</div>
			</div>
			
		</div>
	</article>

<?php endwhile; ?>


<?php get_footer(); ?>