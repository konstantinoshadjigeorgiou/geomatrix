<?php

class Custom_Menu_Walker extends Walker_Nav_Menu
{
  function start_lvl(&$output, $depth = 0, $args = null)
  {
    $output .= "<ul class='link-wrapper'>";
  }

  function end_lvl(&$output, $depth = 0, $args = null)
  {
    $output .= "</ul>";
  }

  function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
  {
    $li_classes = "";
    if ($depth == 0) {
      $li_classes .= "footer-links-wrapper ";
    } else {
      $li_classes .= "link-content ";
    }

    $li_classes .= implode(" ", array_filter($item->classes));

    $output .= "<li class='{$li_classes}'>";

    if ($depth == 0) {
      $output .= "<input type='checkbox' class='link-title-check' />";
      $output .= "<div class='links-title'>";
      $output .= "<span>{$item->title}</span>";
      $output .= "</div>";
    } else {
      $output .= "<a href='{$item->url}' class='footer-link'>{$item->title}";
    }
  }

  function end_el(&$output, $item, $depth = 0, $args = null)
  {
    if ($depth != 0) {
      $output .= "</a>";
    }

    $output .= "</li>";
  }
}
