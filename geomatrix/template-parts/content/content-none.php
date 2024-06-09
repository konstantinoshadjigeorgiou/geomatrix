<?php

/**
 * Template part for displaying a message that posts cannot be found
 *
 * @package Geomatrix
 */

?>

<div class="title-wrapper start">
  <h1 class="title line end"><?php _e('Nothing Found', 'Geomatrix'); ?></h1>

  <div class="description">
    <?php
    if (is_search()) : ?>
      <p><?php _e('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'Geomatrix'); ?></p>
    <?php
    else : ?>
      <p><?php _e('It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'Geomatrix'); ?></p>
    <?php
    endif; ?>

    <?= get_search_form(); ?>
  </div>
</div>