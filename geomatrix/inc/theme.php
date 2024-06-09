<?php

namespace Geomatrix\Theme;

add_action('after_setup_theme', __NAMESPACE__ . '\\setup');
if (!function_exists('setup')) :

  function setup()
  {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');

    // Set tagline

    // This theme uses wp_nav_menu() in two locations.
    register_nav_menus(
      array(
        'main' => __('Main menu', TEXT_DOMAIN),
      )
    );
  }

endif;

/**
 * Add shortcode support
 */
add_filter('wp_nav_menu_items', 'do_shortcode');
add_filter('the_title', 'do_shortcode');
add_filter('the_seo_framework_pro_add_title', 'do_shortcode');
add_filter('the_content', 'do_shortcode');


/**
 * Enqueue scripts and styles.
 */
add_action('wp_enqueue_scripts', __NAMESPACE__ . '\\register_global_assets');
function register_global_assets()
{
  $version = '1.0.0';
  wp_register_style('main-style', get_stylesheet_directory_uri() . '/dist/styles/styles.min.css', array(), $version);
  wp_enqueue_style('main-style');

  wp_register_script('main-header', get_stylesheet_directory_uri() . '/dist/scripts/header.js', array('jquery'), $version, true);
  wp_enqueue_script('main-header');

  wp_register_script('main-script', get_stylesheet_directory_uri() . '/dist/scripts/main.js', array('jquery'), $version, true);
  wp_enqueue_script('main-script');



  /**
   * Register the page template assets
   */
  $type = get_page_type();
  // Single page templates
  if ($type == "single" && !empty(get_query_var('post_type'))) {
    $post_type = get_query_var('post_type');
    $template = "$type-{$post_type}";
  } else {
    $template = str_replace(".php", "", basename(get_page_template()));
  }

  register_asset("pages", $template);

  register_libraries("page-templates", $template);

  /**
   * Register all used custom fields assets
   */
  check_custom_fields_and_register(get_fields());
}

function register_asset($post_type, $name)
{
  if (!wp_style_is($name, "enqueued") && file_exists(__DIR__ . "/../dist/styles/{$post_type}/{$name}.css")) {
    wp_register_style($name, get_stylesheet_directory_uri() . "/dist/styles/{$post_type}/{$name}.css", array(), '1.0.0');
    wp_enqueue_style($name);
  }

  if (!wp_script_is($name, "enqueued") && file_exists(__DIR__ . "/../dist/scripts/{$post_type}/{$name}.js")) {
    wp_register_script($name, get_stylesheet_directory_uri() . "/dist/scripts/{$post_type}/{$name}.js", array("jquery"), '1.0.0', true);
    wp_enqueue_script($name);
  }
}

function register_libraries($type, $component_name)
{
  /**
   * Add the theme's libraries here
   *
   * Structure
   *  - "library folder name" => "unique class you use in your templates to load the library"
   */

  $libraries = [
    'slick' => 'my-slick'
  ];

  foreach ($libraries as $lib => $keyword) {
    if (!wp_style_is($lib, "enqueued") && file_exists(__DIR__ . "/../{$type}/{$component_name}.php")) {
      $page_content = file_get_contents(__DIR__ . "/../{$type}/{$component_name}.php");

      preg_match('/' . $keyword . '/', $page_content, $matches);

      if (!empty($matches)) {
        call_user_func(__NAMESPACE__ . "\\" . str_replace('-', '_', $lib) . "_register_assets");
      }
    }
  }
}

/**
 * Check which components are used and register their assets
 *
 * @param mixed $fields Array custom fields to check
 * @param array $libraries Array of libraries to register depending on their special keyword e.g. array('slick' => 'my-slick')
 */
function check_custom_fields_and_register($fields)
{
  if (is_array($fields)) {
    $all_fields = array_keys($fields);

    foreach ($all_fields as $field) {
      $component_name = str_replace("_", "-", $field);

      /**
       * Register any necessary libraries before registering component assets
       */
      register_libraries('template-parts/components', $component_name);

      /**
       * Register component assets
       */
      register_asset("components", $component_name);
    }
  }
}


/**
 * Register library assets
 *
 * <library>_register_assets
 */
// Slick slider
function slick_register_assets()
{
  // Import styles
  wp_register_style('slick', get_stylesheet_directory_uri() . '/dist/libs/slick/1.8.1/slick.css', array());
  wp_enqueue_style('slick');
  wp_register_style('slick-theme', get_stylesheet_directory_uri() . '/dist/libs/slick/1.8.1/slick-theme.css', array());
  wp_enqueue_style('slick-theme');
  wp_register_style('slick-custom', get_stylesheet_directory_uri() . '/dist/libs/slick/1.8.1/slick-custom.css', array());
  wp_enqueue_style('slick-custom');

  // Import scripts
  wp_register_script('slick', get_stylesheet_directory_uri() . '/dist/libs/slick/1.8.1/slick.js', array('jquery'), null, true);
  wp_enqueue_script('slick');

}
// Datatabes
function datatables_register_assets()
{
  // Import styles
  wp_register_style('datatables', get_stylesheet_directory_uri() . '/dist/libs/datatables/1.12.1/datatables.min.css', array());
  wp_enqueue_style('datatables');
  wp_register_style('datatables-responsive', get_stylesheet_directory_uri() . '/dist/libs/datatables/2.3.0/responsive.dataTables.min.css', array());
  wp_enqueue_style('datatables-responsive');
  wp_register_style('datatables-custom', get_stylesheet_directory_uri() . '/dist/libs/datatables/datatables-custom.css', array());
  wp_enqueue_style('datatables-custom');

  // Import scripts
  wp_register_script('datatables', get_stylesheet_directory_uri() . '/dist/libs/datatables/1.12.1/datatables.min.js', array('jquery'), null, true);
  wp_enqueue_script('datatables');
  wp_register_script('datatables-responsive', get_stylesheet_directory_uri() . '/dist/libs/datatables/2.3.0/responsive.dataTables.min.js', array('jquery'), null, true);
  wp_enqueue_script('datatables-responsive');
}

/**
 * Add favicon to the website
 */
add_action('admin_head', __NAMESPACE__ . '\\site_favicon');
function site_favicon()
{
  echo print_favicons();
}

/**
 * Print favicon meta tags
 */
function print_favicons($path = '')
{
  $favicon_path = (!empty($path)) ? $path : "/favicon";
  ob_start(); ?>
  <link rel="apple-touch-icon" sizes="180x180" href="<?= get_stylesheet_directory_uri() . $favicon_path; ?>/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="<?= get_stylesheet_directory_uri() . $favicon_path; ?>/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="<?= get_stylesheet_directory_uri() . $favicon_path; ?>/favicon-16x16.png">
  <link rel="manifest" href="<?= get_stylesheet_directory_uri() . $favicon_path; ?>/site.webmanifest">
  <link rel="mask-icon" href="<?= get_stylesheet_directory_uri() . $favicon_path; ?>/safari-pinned-tab.svg" color="#5bbad5">
  <link rel="shortcut icon" href="<?= get_stylesheet_directory_uri() . $favicon_path; ?>/favicon.ico">
  <meta name="msapplication-TileColor" content="#da532c">
  <meta name="msapplication-config" content="<?= get_stylesheet_directory_uri() . $favicon_path; ?>/browserconfig.xml">
  <meta name="theme-color" content="#ffffff">
<?php
  return ob_get_clean();
}

/**
 * Customize nav menu links attributes
 */
add_filter('nav_menu_link_attributes', __NAMESPACE__ . '\\custom_menu_link_attributes', 10, 3);
function custom_menu_link_attributes($atts, $item, $args)
{
  $atts['data-text'] = $item->post_title;
  return $atts;
}

function get_post_views()
{
  $count = get_post_meta(get_the_ID(), 'current_post_views', true);
  if (empty($count)) {
    $count = 0;
  }

  return "$count " . __("views", TEXT_DOMAIN);
}

function update_post_views()
{
  $key = 'current_post_views';

  $post_id = get_the_ID();

  $count = (int) get_post_meta($post_id, $key, true);

  $count++;

  update_post_meta($post_id, $key, $count);
}

add_filter('manage_posts_columns', __NAMESPACE__ . '\\custom_posts_columns');
function custom_posts_columns($columns)
{
  $columns['post_views'] = 'Views';

  return $columns;
}

add_action('manage_posts_custom_column', __NAMESPACE__ . '\\custom_posts_columns_values');
function custom_posts_columns_values($column)
{
  if ($column === 'post_views') {
    echo get_post_views();
  }
}


function custom_get_header()
{
  $cache_ignore = wp_cache_get('ignore');
  if (
    empty($cache_ignore)
    || $cache_ignore == 0
  ) {
    get_header();
  }
}

function custom_get_footer()
{
  $cache_ignore = wp_cache_get('ignore');
  if (
    empty($cache_ignore)
    || $cache_ignore == 0
  ) {
    get_footer();
  }
}
