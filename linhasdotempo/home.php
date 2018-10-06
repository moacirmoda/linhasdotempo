<?php get_header(); ?>
<section class="home">
  
  <div class="row" style="text-align: center;">
    <div class="col-md-6">
      <h1>Projetos</h1>
      <div class="projects">
        <?php
        $args = array( 'post_type' => 'projects', 'posts_per_page' => -1 );
        $loop = new WP_Query( $args );
        while ( $loop->have_posts() ) : $loop->the_post();
        ?>
          <div class="project-card">
            <span class="date"><?php echo date_parse(get_post_meta(get_the_ID(), 'data_inicio', true))['year'] ?></span>
            <h2>
              <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h2>
            <p><?php the_excerpt(); ?></p>
          </div>
        <?php
        endwhile;
        ?>
      </div>
    </div>
    <div class="col-md-6">
      <h1>Temas</h1>
      <div class="projects">
        <?php
        foreach(get_categories(array('taxonomy' => 'tema')) as $theme ):
        ?>
          <div class="project-card">
            <h2>
              <a href="<?php echo get_term_link($theme->term_id, 'tema'); ?>"><?php echo $theme->name; ?></a>
            </h2>
          </div>
        <?php
        endforeach;
        ?>
      </div>
    </div>
  </div>

</section>
<?php get_footer(); ?>
