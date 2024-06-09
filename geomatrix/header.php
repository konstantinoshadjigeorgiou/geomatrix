<?php

/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Geomatrix
 */

use Geomatrix\Theme; ?>

<!doctype html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="profile" href="https://gmpg.org/xfn/11" />
  <!-- Favicon -->
  <?= Theme\print_favicons(); ?>

  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
  <div id="page" class="site">
    <a class="skip-link sronly" href="#content"><?php __('Skip to content', TEXT_DOMAIN); ?></a>


    <header id="main-navbar" class="main-navbar">

      <div class="container menu">

        <div class="menu-inner">
          <div class="main-menu">
            <?php
            $href = "/"; ?>

            <a href="<?= $href; ?>" class="logo no-underline">
              <img src="<?= get_stylesheet_directory_uri(); ?>/dist/images/logo.png" alt="<?= bloginfo('name'); ?>">
            </a>

            <?php
            if (has_nav_menu('main')) : ?>
                <nav class="main-navigation nav-menu" aria-label="<?php esc_attr_e('Main Menu', TEXT_DOMAIN); ?>">
                  <?php
                  wp_nav_menu(
                    array(
                      'theme_location' => 'main',
                      'menu_class'     => 'navbar-menu',
                      'link_before' => '<span>',
                      'link_after' => '</span>'
                    )
                  ); ?>
                </nav><!-- .main-navigation -->
              <div class="navbar-menu-wrapper">

                <div class="dashboard-buttons">
                  <a class="btn secondary login" href="#">Sign up</a>
                </div>
                <div class="menu-button menu-lines" id="menu-button">
                  <span class="sronly">Menu</span>
                  <img src="<?= get_stylesheet_directory_uri(); ?>/dist/images/menu.svg" alt="<?= bloginfo('menu'); ?>">

                </div>
              </div> <!-- navbar-menu-wrapper -->
            <?php
            endif; ?>
          </div> <!-- main-menu -->
        </div> <!-- menu-inner -->

      </div><!-- .container.menu -->

    </header><!-- #main-header -->


    <div class="mobile-navigation">

      <div class="menu-button" id="menu-button">
        <span class="sronly">Menu</span>
        <div class="menu-lines">&nbsp</div>
      </div>

      <div class="mobile-navigation-content">
        <?php
        wp_nav_menu(
          array(
            'theme_location'  => 'main',
            'menu_class'      => 'header-menu main-menu-mobile',
            'container_class' => 'menu-main-navigation-container',
          )
        ); ?>
      </div>
    </div>