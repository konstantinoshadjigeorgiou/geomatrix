<?php

/**
 * The template for displaying the Platforms archive page
 *
 * @package Your_Theme_Name
 */

get_header(); ?>

<div id="primary" class="content-area">
  <main id="main" class="site-main">
    <section class="platform">
      <div class="container">
        <div class="container">
          <header class="entry-header">
            <h1 class="entry-title">Platforms</h1>
            <p>Elevate your trading experience to cosmic heights with our range of powerful and versatile platforms. MetaTrader 4, MetaTrader 5, and Webtrader provide you with the advanced tools and resources needed to navigate the universe of trading opportunities with confidence and ease.</p>
          </header><!-- .entry-header -->
        </div>
      </div>
    </section>
    <section class="cards-section accounts">
      <div class="cards-component component vertical normal">
        <div class="container cards-component-inner">
          <div class="component-content">
            <div class="cards-wrapper">
              <div class="cards">
                <?php
                // Get the IDs of the pages with titles "MT4", "MT5", and "WebTrader"
                $platform_titles = array('MT4', 'MT5', 'WebTrader');
                $platforms = get_posts(array(
                  'post_type' => 'platform',
                  'post_status' => 'publish',
                  'posts_per_page' => 3,
                  'orderby' => 'post__in',
                  'post_name__in' => $platform_titles, // Ensures specific posts are queried
                ));

                if ($platforms) :
                  foreach ($platforms as $platform) :
                    setup_postdata($platform);
                ?>
                    <article class="card" id="post-<?php echo $platform->ID; ?>" <?php post_class(); ?>>
                      <div class="card-inner center">
                        <header class="header">
                          <h2 class="entry-title"><a href="<?php echo get_permalink($platform->ID); ?>"><?php echo get_the_title($platform->ID); ?><span>↗</span></a></h2>
                          <div class="entry-excerpt">
                            <?php echo get_the_excerpt($platform->ID); ?>
                          </div><!-- .entry-excerpt -->

                          <div class="learn-more">
                            <a class="btn secondary login" href="<?php echo get_permalink($platform->ID); ?>"><?php _e('Learn More', 'text_domain'); ?></a>
                          </div><!-- .learn-more -->
                        </header>


                        <div class="main">
                          <div class='description'>
                            <?php if (has_post_thumbnail($platform->ID)) : ?>
                              <div class="entry-thumbnail">
                                <?php echo get_the_post_thumbnail($platform->ID, 'full'); ?>
                              </div><!-- .entry-thumbnail -->
                            <?php endif; ?>
                          </div>

                        </div> <!-- .main -->



                      </div>
                    </article><!-- #post-<?php echo $platform->ID; ?> -->
                <?php
                  endforeach;
                  wp_reset_postdata();
                else :
                  get_template_part('template-parts/content', 'none');
                endif;
                ?>
              </div> <!-- cards my-slick -->
            </div> <!-- cards-wrapper -->
          </div>
        </div>
      </div>
    </section>

  </main><!-- #main -->

</div><!-- #primary -->

<?php
get_footer();
