<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js no-svg">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">

	<title><?php echo get_bloginfo('name'); if(!is_home() || !is_front_page()) wp_title('|', true, 'left'); ?></title>
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo get_template_directory_uri(); ?>/images/favicon.ico">
  <link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/images/apple-touch-icon.png">

	<?php
	wp_deregister_script('jquery');
	wp_enqueue_script('jquery', get_template_directory_uri() .'/inc/jquery-3.3.1.min.js');
	wp_head();
	?>

	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css?family=Days+One|Quicksand:500,700" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/style.css?<?php echo filemtime(get_template_directory() . "/style.css"); ?>">

  <script type="text/javascript">
    $(document).ready(function() {
      $("a[href^='http']").not("[href*='" + window.location.host + "']").prop('target','new');
      $("a[href$='.pdf']").prop('target', 'new');
    });
  </script>
</head>
<body <?php body_class(); ?>>

  <header class="site-width">
    <a href="<?php echo home_url(); ?>" id="logo">
      <img src="<?php echo get_template_directory_uri(); ?>/images/logo.svg" alt="Wikk Industries"> simply. accessible.
    </a>

    <div id="header-menu">
      <span class="redtext">Service:</span> 877-421-9490
      <span class="sep"></span>
      <a href="<?php echo home_url(); ?>/pro/" class="hm">Pro Area</a><br>
      <img src="<?php echo get_template_directory_uri(); ?>/images/made-in-the-usa.png" alt="Made in the USA">
    </div>
  </header>

  <input type="checkbox" id="toggle-menu" role="button">
  <label for="toggle-menu"></label>
  <?php wp_nav_menu(array('theme_location'=>'main-menu','container'=>'nav')); ?>