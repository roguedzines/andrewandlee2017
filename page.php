<?php //get theme options
global $data;
?>
<?php get_header(); ?>
<div class="content-wrapper">
  <div class="inner-wrap">
  <div class="row">
    <div class="column column-1">
      <div class="post-content">
        <?php wp_nav_menu( array(
            'theme_location' => 'portfolio_menu',
            'sort_column' => 'menu_order',
            'menu_class' => 'side-menu',
            'fallback_cb' => 'default_menu'
          )); ?>
      </div>
    </div>
    <div class="column column-11 nomargin">
      <div class="post-content">
		<?php if(have_posts()): while (have_posts()) : the_post();?>
<?php the_content( $more_link_text = null, $strip_teaser = false );?>
<?php endwhile;?>
    <?php endif;?>
      </div>
    </div>
  </div>
</div>
</div>
<?php get_footer(); ?>
