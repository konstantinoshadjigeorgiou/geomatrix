<?php

/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Geomatrix
 *
 */

use Geomatrix\Theme;

?>


<footer>
  <div class="container">
    <div class="footer__header">
      <div class="footer__logo">
        <img src="<?= get_stylesheet_directory_uri(); ?>/dist/images/footer-logo.png" alt="<?= bloginfo('name'); ?>">
      </div>
    </div>

    <div class="footer__main">
      <div class="footer__risk-warning">
        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
      </div>

      <div class="footer__apps">
        <p>Get the app</p>

        <div class="footer__apps--icons">
          <a href="#"><img src="<?= get_stylesheet_directory_uri(); ?>/dist/images/ios.png" alt="ios app"></a>
          <a href="#"><img src="<?= get_stylesheet_directory_uri(); ?>/dist/images/android.png" alt="android app"></a>
        </div>
      </div>

      <div class="footer__menu">
        <?php
        if (has_nav_menu('main')) : ?>
          <nav class="footer-navigation nav-footer-menu" aria-label="<?php esc_attr_e('Footer menu', TEXT_DOMAIN); ?>">
            <?php
            wp_nav_menu(
              array(
                'theme_location' => 'secondary-menu',
                'menu_class'     => 'footer-menu footer-links',
                'link_before'    => '<span>',
                'link_after'     => '</span>'
              )
            ); ?>
          </nav>
        <?php
        endif; ?>
      </div>

    </div>
    <div class="footer__company-info">
      <div class="copyright">
        © 2024 All rights reserved.
      </div>

      <div class="company-info__socials">
        <div class="socials__links">
          <ul>
            <li>
              <a href="#"><img src="<?= get_stylesheet_directory_uri(); ?>/dist/images/social/twitter.svg" alt="twitter"></a>
            </li>
            <li>
              <a href="#"><img src="<?= get_stylesheet_directory_uri(); ?>/dist/images/social/linkedin.svg" alt="linkedin"></a>
            </li>
            <li>
              <a href="#"><img src="<?= get_stylesheet_directory_uri(); ?>/dist/images/social/fb.svg" alt="facebook"></a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</footer>



</div><!-- #page -->
<?php wp_footer(); ?>
</body>

</html>