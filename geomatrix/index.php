<?php

/**
 * The main template file
 *
 * @package Geomatrix
 */

use Geomatrix\Theme;

Theme\custom_get_header();

$page_type = "content-none";
ob_start();
if (is_404()) {
  status_header(404);
  nocache_headers();
  get_template_part('template-parts/content/content', 'none');
} else {
  if (is_page()) {
    the_post();
    $page_type = "content-page";
    get_template_part('template-parts/content/content', 'page');
  } else if (have_posts()) {
    $page_type = "content-post";
    get_template_part('template-parts/content/content', 'post');
  } else {
    // If no content, include the "No posts found" template.
    status_header(404);
    nocache_headers();
    get_template_part('template-parts/content/content', 'none');
  }
}
$page_content = ob_get_clean(); ?>

<div class="page-wrapper content-page <?= $page_type; ?>">
  <main class="content-wrapper">

    <section class="component vertical end">
      <div class="container">
        <?= $page_content; ?>
      </div>
    </section>

  </main> <!-- .container -->
</div> <!-- .page-wrapper -->

<?php
Theme\custom_get_footer();
