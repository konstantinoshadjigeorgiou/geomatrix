<?php

/**
 * The template for displaying single Platform posts
 *
 * @package Your_Theme_Name
 */

use Geomatrix\Theme;

Theme\custom_get_header();
?>

<div id="primary" class="platforms">
  <main id="main" class="site-main">
    <?php
    while (have_posts()) :
      the_post();
    ?>
      <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <section class="platform">
          <div class="container">
            <header class="entry-header">
              <h1 class="entry-title"><?php the_title(); ?></h1>
              <?php
              // Display the custom excerpt
              $custom_excerpt = get_post_meta(get_the_ID(), '_platform_custom_excerpt', true);
              if ($custom_excerpt) {
                echo '<p>' . esc_html($custom_excerpt) . '</p>';
              }
              ?>
            </header><!-- .entry-header -->
          </div>
        </section>
        <section>
          <div class="container">
            <div class="entry-content">
              <?php


              // Display the download links
              $windowsURL = get_post_meta(get_the_ID(), '_platform_windows_url', true);
              $windowsMedia = get_post_meta(get_the_ID(), '_platform_windows_media', true);
              $androidURL = get_post_meta(get_the_ID(), '_platform_android_url', true);
              $androidMedia = get_post_meta(get_the_ID(), '_platform_android_media', true);
              $macURL = get_post_meta(get_the_ID(), '_platform_mac_url', true);
              $macMedia = get_post_meta(get_the_ID(), '_platform_mac_media', true);
              ?>

              <div class="platforms">
                <?php if ($windowsURL) : ?>
                  <div class="platform__item">
                    <a href="<?php echo esc_url($windowsURL); ?>" class="platforms__link">
                      <img src="<?php echo esc_url($windowsMedia); ?>" alt="Windows" class="platforms__icon">
                      Windows</a>
                  </div>
                <?php endif; ?>

                <?php if ($androidURL) : ?>
                  <div class="platform__item">
                    <a href="<?php echo esc_url($androidURL); ?>" class="platforms__link">
                      <img src="<?php echo esc_url($androidMedia); ?>" alt="Android" class="platforms__icon">Android</a>
                  </div>
                <?php endif; ?>

                <?php if ($macURL) : ?>
                  <div class="platform__item">
                    <a href="<?php echo esc_url($macURL); ?>" class="platforms__link">
                      <img src="<?php echo esc_url($macMedia); ?>" alt="Mac" class="platforms__icon">
                      Mac</a>
                  </div>
                <?php endif; ?>
              </div><!-- .platforms -->

              <?php




              // Display the content
              the_content();
              ?>
            </div><!-- .entry-content -->
          </div>
        </section>
      </article><!-- #post-<?php the_ID(); ?> -->

    <?php
    endwhile; // End of the loop.
    ?>

  </main><!-- #main -->

</div><!-- #primary -->

<?php
get_footer();




