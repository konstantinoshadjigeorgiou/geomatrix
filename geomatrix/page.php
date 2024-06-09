<?php

use Geomatrix\Theme;

Theme\custom_get_header(); ?>

<div class="default-template">
  <div class="container">
    <h1><?= the_title(); ?></h1>

    <div class="content">
      <?= the_content(); ?>
    </div>
  </div>
</div>

<?php
Theme\custom_get_footer();
