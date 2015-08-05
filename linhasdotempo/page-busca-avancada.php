<?php 

global $post;
$query = NULL;

// busca de temas
if(isset($_REQUEST['ajax']) and isset($_REQUEST['tema'])) {

	$tema = $_REQUEST['tema'];

	$terms = get_terms('tema', array('name__like' => $tema));
	print json_encode($terms);
	die;

}

$months = array('Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro');

get_header(); ?>

<article class='page advanced-search'>
	<div class='container-fluid'>

		<div class='title-box'>
			<div class='row'>
				<div class='col-md-12'>
					<h1><a href="<?= get_permalink(get_the_ID()); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h1>
				</div>
			</div>
		</div>

		<?php if(!$query): ?>
			<div class='article-content'>
				<div class='row'>
					<div class='col-md-12'>
						<form id='formBuscaAvancada' method='GET' action='<?php bloginfo('wpurl'); ?>'>

							<input type='hidden' name='s' value=''>
							<input type='hidden' name='type' value='advanced'>
							
							<div id='divTermosDePesquisa'>
								<span id='spanEmpty'><i>Não há condições selecionadas.</i></span>
							</div>

							<div id='divBuscar'>
								<button type='sumbmit' class='btn btn-linha-do-tempo'>Buscar</button>
							</div>
						</form>

						<div id='divTermo'>
							<h2>Termos:</h2>
							<input type='text' name='search' placeholder='Digite o termo...'>
							<select>
								<option value='contem'>contém</option>
								<option value='nao_contem'>não contém</option>
								<option value='exato'>termo exato</option>
								<option value='parte'>parte do termo</option>
							</select>
							<a href="#" class='btn btn-linha-do-tempo btn-xs'><i class='glyphicon glyphicon-plus'></i></a>
						</div>
						
						<div id='divPeriodo'>
							<h2>Período:</h2>
							<select name='from_month'>
								<option value=''>Mês</option>
								<?php $count=1; foreach($months as $month): ?>
									<option value='<?php printf("%02d", $count++); ?>'><?= $month; ?></option>
								<?php endforeach; ?>
							</select>
							<input type='number' class='input-sm' name='from_year' min='1500' max='2100' placeholder='Ano'>

							até

							<select name='to_month'>
								<option value=''>Mês</option>
								<?php $count=1; foreach($months as $month): ?>
									<option value='<?php printf("%02d", $count++); ?>'><?= $month; ?></option>
								<?php endforeach; ?>
							</select>
							<input type='number' class='input-sm' name='to_year' min='1500' max='2100' placeholder='Ano'>

							<a href="#" class='btn btn-linha-do-tempo btn-xs'><i class='glyphicon glyphicon-plus'></i></a>
						</div>

						<div id='divTemas'>
							<h2>Temas:</h2>
							<input type='text' name='search' id='inputSearchTema' placeholder='Digite o tema, ou parte dele...'>
							<a href="#" class='btn btn-linha-do-tempo btn-xs' id='submitTemaSearch'><i class='glyphicon glyphicon-search'></i></a>

							<img id='imgTemaLoading' src='<?php echo get_template_directory_uri(); ?>/static/img/ajax-loader.gif'>
							<div id='divTemasBuscados'>
								<span id='spanTemaEmpty'><i>Não foi localizado nenhum tema.</i></span>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php endif; ?>

		<div class='article-content'>
			<div class='row'>
				<div class='col-md-12'>
					<?php while ( have_posts() ) : the_post(); ?>
						<?php the_content(); ?>
					<?php endwhile; ?>
				</div>
			</div>
		</div>
		</div>
	</article>


<?php get_footer(); ?>