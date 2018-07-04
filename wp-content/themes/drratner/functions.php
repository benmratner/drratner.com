<?php

require_once 'functions/acf.php';
require_once 'functions/helpers.php';

/*------------------------------------*\
  Theme Support
\*------------------------------------*/

function SITE_PACKAGE_setup()
{

}

/*------------------------------------*\
  Functions
\*------------------------------------*/

// Load scripts
function SITE_PACKAGE_scripts()
{
  if ($GLOBALS['pagenow'] != 'wp-login.php' && !is_admin()) {
    wp_deregister_script('jquery');
    wp_register_script('jquery', get_template_directory_uri() . '/dist/jquery.min.js', null, '3.1.1', true);
    wp_enqueue_script('jquery'); // Enqueue it!

    wp_register_script('bootstrap', get_template_directory_uri() . '/dist/bootstrap.min.js', array('jquery'), '3.3.7', true);
    wp_enqueue_script('bootstrap'); // Enqueue it!

    wp_register_script('SITE_PACKAGE', get_template_directory_uri() . '/dist/main.min.js', array('bootstrap', 'jquery'), '1.0.0', true);
    wp_enqueue_script('SITE_PACKAGE'); // Enqueue it!
  }
}

// Load styles
function SITE_PACKAGE_styles()
{
  wp_register_style('SITE_PACKAGE', get_template_directory_uri() . '/dist/main.css', null, '1.0', 'all');
  wp_enqueue_style('SITE_PACKAGE'); // Enqueue it!
}

// Add page slug to body class - Credit: Starkers Wordpress Theme
function add_slug_to_body_class($classes)
{
  global $post;
  if (is_page()) {
  $classes[] = sanitize_html_class($post->post_name);
  }

  return $classes;
}


// Remove Admin bar
function remove_admin_bar()
{
  return false;
}

/*------------------------------------*\
  Actions + Filters + ShortCodes
\*------------------------------------*/

// Add Actions
add_action('after_setup_theme', 'SITE_PACKAGE_setup');
add_action('wp_enqueue_scripts', 'SITE_PACKAGE_scripts'); // Add Custom Scripts to wp_head
add_action('wp_enqueue_scripts', 'SITE_PACKAGE_styles'); // Add Theme Stylesheet

// Add Filters
add_filter('body_class', 'add_slug_to_body_class'); // Add slug to body class (Starkers build)
add_filter('show_admin_bar', 'remove_admin_bar'); // Remove Admin bar


// Add the ACF options page
if( function_exists('acf_add_options_page') ) {
	acf_add_options_page();
}
