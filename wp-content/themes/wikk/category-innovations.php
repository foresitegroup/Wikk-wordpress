<?php get_header(); ?>

<h1 class="site-width news-title">Innovations &amp; News</h1>

<div id="news-tabs">
  <div class="site-width">
    <label>Innovations</label>
    <a href="<?php echo get_site_url(null, '/news/news/'); ?>">News</a>
  </div>
</div>

<?php get_template_part('content', 'news'); ?>

<?php
$FooterText = "Want to know more about our work?";
get_footer();
?>