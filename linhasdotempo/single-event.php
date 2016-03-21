<?php 

get_header(); 
global $post;

?>

<?php while ( have_posts() ) : the_post(); ?>

	<article>
		<div class='container-fluid'>

			<?php if($post->post_parent): ?>
				<?php $parent = get_post($post->post_parent); ?>

				<div class='parent-box'>
					<div class='row'>
						<div class='col-md-12'>
							<a href="<?= get_permalink($parent->ID); ?>" title="<?= $parent->post_title; ?>"><b>EVENTO PRINCIPAL:</b> <?= $parent->post_title; ?></a>
						</div>
					</div>
				</div>
			<?php endif; ?>

			<div class='date-box'>
				<div class='row'>
					<div class='col-md-12'>
						<h2>
							<?php
								print print_date(get_field('data_inicio')); 
								if(get_field('data_final')):
									print " - " . print_date(get_field('data_final'));
								endif;
							?>
						</h2>
					</div>
				</div>
			</div>

			<div class='title-box'>
				<div class='row'>
					<div class='col-md-12'>
						<h1><a href="<?= get_permalink(get_the_ID()); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h1>
					</div>
				</div>
			</div>

			<div class='temas-box'>
				<div class='row'>
					<div class='col-md-12'>
						<ul>
							<?= the_terms(get_the_ID(), "tema", '<li>', '', '</li>'); ?>
							<!-- <li><a href="#" title="Dilma">Dilma</a></li>
							<li><a href="#" title="Governo">Governo</a></li>
							<li><a href="#" title="Saúde">Saúde</a></li> -->
						</ul>
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

			<?php $children = get_children(array('post_parent' => get_the_ID(), 'numberposts' => -1)); ?>
			<?php if (count($children) > 0): ?>
				<div class='subeventos-box'>
					<div class='row'>
						<div class='col-md-12'>
							<h2>Sub Eventos</h2>
							<ul>	
								<?php foreach($children as $child): ?>
									<li><a href="<?= get_permalink($child->ID); ?>" title="<?= $child->post_title; ?>"><?= print_date_shortformat(get_field('data_inicio', $child->ID)); ?> - <?= $child->post_title; ?></a></li>
								<?php endforeach; ?>
								<!-- <li><a href="#" title="Dilma">25/05/2015 - Criação do aplicativo Linhas do Tempo</a></li>
								<li><a href="#" title="Dilma">26/05/2015 - Criação do programa ProUNI</a></li> -->
							</ul>
						</div>
					</div>
				</div>
			<?php endif; ?>

			<?php if(get_field('anexos')): ?>
				<div class='anexos-box'>
					<div class='row'>
						<div class='col-md-12'>
							<h2>Anexos</h2>
							<?php the_field('anexos'); ?>
						</div>
					</div>
				</div>
			<?php endif; ?>

			<?php if(get_field('referencias')): ?>
				<div class='referencias-box'>
					<div class='row'>
						<div class='col-md-12'>
							<h2>Referências</h2>
							<?php the_field('referencias'); ?>
						</div>
					</div>
				</div>
			<?php endif; ?>
			
			<?php if(get_field('notas_tecnicas')): ?>
				<div class='comentarios-box'>
					<div class='row'>
						<div class='col-md-12'>
							<h2>Notas Técnicas</h2>
							<?php the_field('notas_tecnicas'); ?>
						</div>
					</div>
				</div>
			<?php endif; ?>

			<?php if(get_field('comentario')): ?>
				<div class='comentarios-box'>
					<div class='row'>
						<div class='col-md-12'>
							<h2>Comentários ao leitor</h2>
							<?php the_field('comentario'); ?>
						</div>
					</div>
				</div>
			<?php endif; ?>

			<?php if(get_field('projeto')): ?>
				<div class='comentarios-box'>
					<div class='row'>
						<div class='col-md-12'>
							<h2>Projeto</h2>
							<?php the_field('projeto'); ?>
							<?php if(get_field('sub_projeto')): ?>
								/ <?php the_field('sub_projeto'); ?>
							<?php endif; ?>
						</div>
					</div>
				</div>
			<?php endif; ?>

			<div class='alert-box'>
				<div class='row'>
					<div class='col-md-12'>
						<a href="<?= site_url(); ?>/contato/?event=<?= get_the_ID(); ?>">
							Deseja fazer alguma correção/sugestão sobre este evento?
						</a>
					</div>
				</div>
			</div>
		</div>
				
	</article>

<?php endwhile; ?>


<?php get_footer(); ?>