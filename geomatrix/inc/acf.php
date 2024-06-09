<?php

/**
 * Add ACF Options page
 */
if (function_exists('acf_add_options_page')) {
  $child = acf_add_options_page(array(
    'page_title'  => __('Footer Settings'),
    'menu_title'  => __('Footer'),
    'redirect'    => false,
  ));
}

/**
 * Setup ACF Google maps key
 */
add_action('acf/init', 'my_acf_init');
function my_acf_init()
{
  $api_key = get_field('google_maps_api_key', 'option');
  acf_update_setting('google_api_key', $api_key);
}

/**
 * Filter custom fields to accept shortcodes
 */
add_filter('acf/format_value/type=text', 'text_area_shortcode', 10, 3);
add_filter('acf/format_value/type=textarea', 'text_area_shortcode', 10, 3);
function text_area_shortcode($value, $post_id, $field)
{
  if (is_admin() && !defined('DOING_AJAX')) {
    // don't do this in the admin
    // could have unintended side effects
    return;
  }
  return do_shortcode($value);
}