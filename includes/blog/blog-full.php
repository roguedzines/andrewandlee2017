<? // get data for options
global $data;
global $post;
if ($data['home_blog_post_count']!='8') {

	$home_blog_post_count = $data['home_blog_post_count'];
} else {

	$home_blog_post_count = 4;
}
?>

<?php // get posts
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
query_posts(array(
'paged'=>$paged,
'posts_per_page'=>$home_blog_post_count)
);
?>
<div class="content-wrapper">
<?
if(have_posts()):?>

<?php get_template_part('loop');
?>
<?php endif;?>
<?php wp_reset_query(); ?>
  <?php if (function_exists('saxonTheme_pagination'))saxonTheme_pagination(); ?>
</div>
