<?php

/**
 * Template part for displaying posts
 *
 * @package Geomatrix
 */

use Geomatrix\Theme;

Theme\custom_get_header();
$post_type = get_post_type_object(get_post_type()); ?>

<div class="component-content">
  <div class="title-wrapper">
    <h1 class="title line end"><?= __($post_type->label, TEXT_DOMAIN); ?></h1>
  </div>

  <div class="articles-wrapper">
    <div class="articles">
      <?php
      while (have_posts()) :
        the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class("article"); ?>>

          <h2><?php the_title(); ?></h2>

          <?php
          if (has_post_thumbnail()) : ?>
            <img src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>" />
          <?php
          endif; ?>

          <?php
          if ($post_type->name == "posts") : ?>
            <div class="date-wrapper no-border-top">
              <div class="date">
                <?php the_date("F j, Y"); ?>
              </div>
            </div>
          <?php
          endif; ?>
          <div class="post-analytics">
            <div class="views">
              <?= Theme\get_post_views(); ?>
            </div>
          </div>

          <div class="content">
            <?php the_content(); ?>
          </div>

          <div class="read-more">
            <a href="<?= get_permalink(); ?>"><?= __("Read more", TEXT_DOMAIN); ?></a>
          </div>

        </article> <!-- article -->

      <?php
      endwhile; ?>
    </div>

  </div>
</div>
