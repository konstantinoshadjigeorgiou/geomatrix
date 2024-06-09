<?php

/**
 * Geomatrix functions and definitions
 *
 * @package Geomatrix
 */

define("TEXT_DOMAIN", "Geomatrix");

$library_includes = [

  // Includes
  'inc/theme.php',                    // Theme functions
  'inc/extras.php',                   // Extra functions
  'inc/classes/custom_menu_walker.php', // Custom menu walker

];

foreach ($library_includes as $file) {
  if (!$filepath = locate_template($file)) {
    trigger_error(
      sprintf('Error locating %s for inclusion', $file),
      E_USER_ERROR
    );
  }

  require_once $filepath;
}
unset($file, $filepath);

function register_secondary_menu()
{
  register_nav_menu('secondary-menu', __('Secondary Menu'));
}
add_action('after_setup_theme', 'register_secondary_menu');


function add_custom_script()
{
  wp_enqueue_script('jquery');
}
add_action('wp_enqueue_scripts', 'add_custom_script');

function create_platforms_post_type()
{
  $labels = array(
    'name'                  => _x('Platforms', 'Post Type General Name', 'text_domain'),
    'singular_name'         => _x('Platform', 'Post Type Singular Name', 'text_domain'),
    'menu_name'             => __('Platforms', 'text_domain'),
    'name_admin_bar'        => __('Platform', 'text_domain'),
    'archives'              => __('Platform Archives', 'text_domain'),
    'attributes'            => __('Platform Attributes', 'text_domain'),
    'parent_item_colon'     => __('Parent Platform:', 'text_domain'),
    'all_items'             => __('All Platforms', 'text_domain'),
    'add_new_item'          => __('Add New Platform', 'text_domain'),
    'add_new'               => __('Add New', 'text_domain'),
    'new_item'              => __('New Platform', 'text_domain'),
    'edit_item'             => __('Edit Platform', 'text_domain'),
    'update_item'           => __('Update Platform', 'text_domain'),
    'view_item'             => __('View Platform', 'text_domain'),
    'view_items'            => __('View Platforms', 'text_domain'),
    'search_items'          => __('Search Platform', 'text_domain'),
    'not_found'             => __('Not found', 'text_domain'),
    'not_found_in_trash'    => __('Not found in Trash', 'text_domain'),
    'featured_image'        => __('Featured Image', 'text_domain'),
    'set_featured_image'    => __('Set featured image', 'text_domain'),
    'remove_featured_image' => __('Remove featured image', 'text_domain'),
    'use_featured_image'    => __('Use as featured image', 'text_domain'),
    'insert_into_item'      => __('Insert into platform', 'text_domain'),
    'uploaded_to_this_item' => __('Uploaded to this platform', 'text_domain'),
    'items_list'            => __('Platforms list', 'text_domain'),
    'items_list_navigation' => __('Platforms list navigation', 'text_domain'),
    'filter_items_list'     => __('Filter platforms list', 'text_domain'),
  );
  $args = array(
    'label'                 => __('Platform', 'text_domain'),
    'description'           => __('Post Type for platforms', 'text_domain'),
    'labels'                => $labels,
    'supports'              => array('title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields'),
    'taxonomies'            => array(),
    'hierarchical'          => false,
    'public'                => true,
    'show_ui'               => true,
    'show_in_menu'          => true,
    'menu_position'         => 5,
    'show_in_admin_bar'     => true,
    'show_in_nav_menus'     => true,
    'can_export'            => true,
    'has_archive'           => true,
    'exclude_from_search'   => false,
    'publicly_queryable'    => true,
    'capability_type'       => 'post',
  );
  register_post_type('platform', $args);
}

add_action('init', 'create_platforms_post_type', 0);



function platform_add_meta_boxes()
{
  add_meta_box(
    'platform_custom_excerpt', // ID of the metabox
    'Custom Excerpt', // Title of the metabox
    'platform_custom_excerpt_callback', // Callback function
    'platform', // Post type
    'normal', // Context
    'high' // Priority
  );

  add_meta_box(
    'platform_download_links', // ID of the metabox
    'Download Links', // Title of the metabox
    'platform_download_links_callback', // Callback function
    'platform', // Post type
    'normal', // Context
    'high' // Priority
  );
}
add_action('add_meta_boxes', 'platform_add_meta_boxes');

function platform_custom_excerpt_callback($post)
{
  $value = get_post_meta($post->ID, '_platform_custom_excerpt', true);
  echo '<textarea style="width:100%" rows="5" name="platform_custom_excerpt">' . esc_attr($value) . '</textarea>';
}

function platform_download_links_callback($post)
{
  $platforms = [
    'windows' => [
      'url' => get_post_meta($post->ID, '_platform_windows_url', true),
      'media' => get_post_meta($post->ID, '_platform_windows_media', true),
    ],
    'android' => [
      'url' => get_post_meta($post->ID, '_platform_android_url', true),
      'media' => get_post_meta($post->ID, '_platform_android_media', true),
    ],
    'mac' => [
      'url' => get_post_meta($post->ID, '_platform_mac_url', true),
      'media' => get_post_meta($post->ID, '_platform_mac_media', true),
    ],
  ];

  foreach ($platforms as $platform => $data) {
    echo ucfirst($platform) . ' Link:<br>';
    echo '<input type="text" name="platform_' . $platform . '_url" value="' . esc_attr($data['url']) . '">';
    echo '<br>';
    echo ucfirst($platform) . ' Media Uploader:<br>';
    echo '<input type="hidden" name="platform_' . $platform . '_media" value="' . esc_attr($data['media']) . '">';
    echo '<input type="button" class="button button-primary" value="Upload Media" id="platform_media_upload_button_' . $platform . '">';
    echo '<div id="imageContainer' . ucfirst($platform) . '"><img src="' . esc_attr($data['media']) . '"/></div>';
    echo '<br>';
    echo '<br>';
  }


  // $windowsURL = get_post_meta($post->ID, '_platform_windows_url', true);
  // $windowsMedia = get_post_meta($post->ID, '_platform_windows_media', true);
  // $androidURL = get_post_meta($post->ID, '_platform_android_url', true);
  // $androidMedia = get_post_meta($post->ID, '_platform_android_media', true);
  // $macURL = get_post_meta($post->ID, '_platform_mac_url', true);
  // $macMedia = get_post_meta($post->ID, '_platform_mac_media', true);

  // echo 'Windows Link:<br>';
  // echo '<input type="text" name="platform_windows_url" value="' . esc_attr($windowsURL) . '">';
  // echo '<br>';
  // echo 'Windows Media Uploader:<br>';
  // echo '<input type="hidden" name="platform_windows_media" value="' . esc_attr($windowsMedia) . '">';
  // echo '<input type="button" class="button button-primary" value="Upload Media" id="platform_media_upload_button_windows"> ';
  // echo '<div id="imageContainerWindows"><img src="' . esc_attr($windowsMedia) . '"/></div>';
  // echo '<br>';
  // echo '<br>';
  // echo 'Android Link:<br>';
  // echo '<input type="text" name="platform_android_url" value="' . esc_attr($androidURL) . '">';
  // echo '<br>';
  // echo 'Android Media Uploader:<br>';
  // echo '<input type="hidden" name="platform_android_media" value="' . esc_attr($androidMedia) . '">';
  // echo '<input type="button" class="button button-primary" value="Upload Media" id="platform_media_upload_button_android">';
  // echo '<div id="imageContainerAndroid"><img src="' . esc_attr($androidMedia) . '"/></div>';
  // echo '<br>';
  // echo '<br>';
  // echo 'Mac Link:<br>';
  // echo '<input type="text" name="platform_mac_url" value="' . esc_attr($macURL) . '">';
  // echo '<br>';
  // echo 'Mac Media Uploader:<br>';
  // echo '<input type="hidden" name="platform_mac_media" value="' . esc_attr($macMedia) . '">';
  // echo '<input type="button" class="button button-primary" value="Upload Media" id="platform_media_upload_button_mac">';
  // echo '<div id="imageContainerMac"><img src="' . esc_attr($macMedia) . '"/></div>';


?>

<script>
  jQuery(document).ready(function($) {
    var mediaUploaders = {
      'windows': null,
      'android': null,
      'mac': null
    };

    function createMediaUploader(platform) {
      if (mediaUploaders[platform]) {
        mediaUploaders[platform].open();
        return;
      }
      mediaUploaders[platform] = wp.media.frames.file_frame = wp.media({
        title: 'Choose Media',
        button: {
          text: 'Select'
        },
        multiple: false
      });
      mediaUploaders[platform].on('select', function() {
        var attachment = mediaUploaders[platform].state().get('selection').first().toJSON();
        $('input[name=platform_' + platform + '_media]').val(attachment.url);
        var img = $('<img />', {
          id: 'MediaImage' + platform.charAt(0).toUpperCase() + platform.slice(1),
          src: attachment.url,
          alt: 'Media Image'
        });
        jQuery('#imageContainer' + platform.charAt(0).toUpperCase() + platform.slice(1)).html(img);

      });
      mediaUploaders[platform].open();
    }

    $('#platform_media_upload_button_windows').click(function(e) {
      e.preventDefault();
      createMediaUploader('windows');
    });

    $('#platform_media_upload_button_android').click(function(e) {
      e.preventDefault();
      createMediaUploader('android');
    });

    $('#platform_media_upload_button_mac').click(function(e) {
      e.preventDefault();
      createMediaUploader('mac');
    });
  });
</script>

<?php
}

function platform_save_meta_boxes($post_id)
{
  if (array_key_exists('platform_custom_excerpt', $_POST)) {
    update_post_meta(
      $post_id,
      '_platform_custom_excerpt',
      sanitize_text_field($_POST['platform_custom_excerpt'])
    );
  }
  $platforms = ['windows', 'android', 'mac'];
  foreach ($platforms as $platform) {
    $url_key = 'platform_' . $platform . '_url';
    $media_key = 'platform_' . $platform . '_media';
    if (array_key_exists($url_key, $_POST)) {
      update_post_meta(
        $post_id,
        '_' . $url_key,
        sanitize_text_field($_POST[$url_key])
      );
    }
    if (array_key_exists($media_key, $_POST)) {
      update_post_meta(
        $post_id,
        '_' . $media_key,
        sanitize_text_field($_POST[$media_key])
      );
    }
  }
}
add_action('save_post', 'platform_save_meta_boxes');
