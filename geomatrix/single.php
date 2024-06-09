<?php

/**
 * Template part for displaying a single post
 *
 * @package Geomatrix
 */

use Geomatrix\Theme;

Theme\custom_get_header();

Theme\update_post_views();

the_post(); ?>

<div class="content-wrapper">
  <section class="post-section">
    <article id="post-<?= the_ID(); ?>" <?= post_class("component vertical"); ?>>
      <div class="container">

        <div class="component-content">

          <div class="title-wrapper">
            <h2 class="title line end"><?= the_title(); ?></h2>

            <div class="post-analytics">
              <div class="views">
                <?= Theme\get_post_views(); ?>
              </div>
            </div>

            <div class="description">
              <?= the_content(); ?>
            </div>
          </div>

          <?php
          if (has_post_thumbnail()) : ?>
            <div class="media-wrapper">
              <img src="<?= the_post_thumbnail_url(); ?>" alt="<?= the_title(); ?>" />
            </div>
          <?php
          endif; ?>

        </div>
    </article>
  </section>
</div>

<?php
Theme\custom_get_footer();
