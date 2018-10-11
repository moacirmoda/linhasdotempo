<?php 

get_header(); 
global $post;

?>

<?php while ( have_posts() ) : the_post(); ?>

	<article>
		<div class='container-fluid'>

      <div class="row">
        <div class="col-md-6">
          <div style="text-align: center; background-color: rgba(232, 236, 241, 0.6); padding: 10px;">
          <?php if($post->post_parent): ?>
            <?php $parent = get_post($post->post_parent); ?>

            <div class='parent-box'>
              <div class='row'>
                <div class='col-md-12'>
                  <a href="<?= get_permalink($parent->ID); ?>" title="<?= $parent->post_title; ?>"><b>PROJETO PRINCIPAL:</b> <?= $parent->post_title; ?></a>
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

          <?php if(get_field('instituicoes')): ?>
            <div class='instituicoes-box'>
              <div class='row'>
                <div class='col-md-12'>
                  <h2>Instituições</h2>
                  <?php the_field('instituicoes'); ?>
                </div>
              </div>
            </div>
          <?php endif; ?>

          <?php if(get_field('equipe')): ?>
            <div class='equipe-box'>
              <div class='row'>
                <div class='col-md-12'>
                  <h2>Equipe</h2>
                  <?php the_field('equipe'); ?>
                </div>
              </div>
            </div>
          <?php endif; ?>
          
          <?php if(get_field('fontes_de_financiamento')): ?>
            <div class='fontes-de-financiamento-box'>
              <div class='row'>
                <div class='col-md-12'>
                  <h2>Fontes de financimaneto</h2>
                  <?php the_field('fontes_de_financiamento'); ?>
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

          <?php if(get_field('eventos')): ?>
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
                <a href="<?= site_url(); ?>/contato/?projects=<?= get_the_ID(); ?>">
                  Deseja fazer alguma correção/sugestão sobre este projeto?
                </a>
              </div>
            </div>
          </div>

        </div>
      </div>
      <div class="col-md-6">
        <div style="padding: 10px;">
        <section id="cd-timeline" class="cd-container">
          <?php
            global $post;
            global $wpdb;

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
    
          <?php foreach($years as $year):
              $lt_posts[$year] = array(); 

              $str_querypost = array(
                'post_type' => 'event',
                'post_parent' => 0,
                'posts_per_page' => -1,
                'orderby' => 'date',
                'meta_key' => 'projeto',
                'meta_value' => serialize(array('' . get_the_ID()))
              );

              // if(isset($_REQUEST['lt-year'])) {
              //   $lt_year = (int)$_REQUEST['lt-year'];
              //   $str_querypost["year"] = $lt_year;
              // } else {
              //   $str_querypost["year"] = $year;
              // }
              
              if(isset($_REQUEST['lt-order']) and $_REQUEST['lt-order'] == 'desc') {
                $str_querypost['order'] = "desc";
              } else {
                $str_querypost['order'] = "asc";
              }

              foreach(get_posts($str_querypost) as $post) {
                $query = "SELECT meta_value FROM $wpdb->postmeta WHERE post_id = '$post->ID' AND meta_key = 'peridiocidade'"; 
                $result = $wpdb->get_row($query, OBJECT );
                if($result) {
                  $lt_posts[$year][$result->meta_value][] = $post;
                }
              }

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
        </div>
      </div>

		</div>				
	</article>

<?php endwhile; ?>


<?php get_footer(); ?>
