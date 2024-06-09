<?php

/**
 * Truncates text.
 *
 * Cuts a string to the length of $length and replaces the last characters
 * with the ending if the text is longer than length.
 *
 * @param string $text String to truncate.
 * @param integer $length Length of returned string, including ellipsis.
 * @param string $ending Ending to be appended to the trimmed string.
 * @param boolean $exact If false, $text will not be cut mid-word
 * @param boolean $considerHtml If true, HTML tags would be handled correctly
 * @return string Trimmed string.
 */
function truncate($text, $length = 100, $ending = '...', $exact = true, $considerHtml = false)
{
  if ($considerHtml) {
    // if the plain text is shorter than the maximum length, return the whole text
    if (strlen(preg_replace('/<.*?>/', '', $text)) <= $length) {
      return $text;
    }
    // splits all html-tags to scanable lines
    preg_match_all('/(<.+?>)?([^<>]*)/s', $text, $lines, PREG_SET_ORDER);
    $total_length = strlen($ending);
    $open_tags = array();
    $truncate = '';
    foreach ($lines as $line_matchings) {
      // if there is any html-tag in this line, handle it and add it (uncounted) to the output
      if (!empty($line_matchings[1])) {
        // if it’s an “empty element” with or without xhtml-conform closing slash (f.e.)
        if (preg_match('/^<(\s*.+?\/\s*|\s*(img|br|input|hr|area|base|basefont|col|frame|isindex|link|meta|param)(\s.+?)?)>$/is', $line_matchings[1])) {
          // do nothing
          // if tag is a closing tag (f.e.)
        } else if (preg_match('/^<\s*\/([^\s]+?)\s*>$/s', $line_matchings[1], $tag_matchings)) {
          // delete tag from $open_tags list
          $pos = array_search($tag_matchings[1], $open_tags);
          if ($pos !== false) {
            unset($open_tags[$pos]);
          }
          // if tag is an opening tag (f.e. )
        } else if (preg_match('/^<\s*([^\s>!]+).*?>$/s', $line_matchings[1], $tag_matchings)) {
          // add tag to the beginning of $open_tags list
          array_unshift($open_tags, strtolower($tag_matchings[1]));
        }
        // add html-tag to $truncate’d text
        $truncate .= $line_matchings[1];
      }
      // calculate the length of the plain text part of the line; handle entities as one character
      $content_length = strlen(preg_replace('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|&#x[0-9a-f]{1,6};/i', ' ', $line_matchings[2]));
      if ($total_length + $content_length > $length) {
        // the number of characters which are left
        $left = $length - $total_length;
        $entities_length = 0;
        // search for html entities
        if (preg_match_all('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|&#x[0-9a-f]{1,6};/i', $line_matchings[2], $entities, PREG_OFFSET_CAPTURE)) {
          // calculate the real length of all entities in the legal range
          foreach ($entities[0] as $entity) {
            if ($entity[1] + 1 - $entities_length <= $left) {
              $left--;
              $entities_length += strlen($entity[0]);
            } else {
              // no more characters left
              break;
            }
          }
        }
        $truncate .= substr($line_matchings[2], 0, $left + $entities_length);
        // maximum lenght is reached, so get off the loop
        break;
      } else {
        $truncate .= $line_matchings[2];
        $total_length += $content_length;
      }
      // if the maximum length is reached, get off the loop
      if ($total_length >= $length) {
        break;
      }
    }
  } else {
    if (strlen($text) <= $length) {
      return $text;
    } else {
      $truncate = substr($text, 0, $length - strlen($ending));
    }
  }
  // if the words shouldn't be cut in the middle...
  if (!$exact) {
    // ...search the last occurance of a space...
    $spacepos = strrpos($truncate, ' ');
    if (isset($spacepos)) {
      // ...and cut the text in this position
      $truncate = substr($truncate, 0, $spacepos);
    }
  }
  // add the defined ending to the text
  $truncate .= $ending;
  if ($considerHtml) {
    // close all unclosed html-tags
    foreach ($open_tags as $tag) {
      $truncate .= "</" . $tag . ">";
    }
  }
  return $truncate;
}

/**
 * Generates the url for social media sharing
 *
 * @date 2022-02-17
 *
 * @param {string} $social - The social network name
 * @param {string} $permalink - The link to be shared
 * @returns {string} - Social link markup
 */
function generate_social_link($social, $permalink)
{
  $permalink = urlencode($permalink);

  switch ($social) {
    case 'facebook':
      $link = "https://www.facebook.com/sharer/sharer.php?u={$permalink}";
      break;
    case 'twitter':
      $link = "https://twitter.com/intent/tweet?url={$permalink}&text=";
      break;
    case 'pinterest':
      $link = "https://pinterest.com/pin/create/button/?url={$permalink}&media=&description=";
      break;
    case 'linkedin':
      // 2015 version - (2022-02-17) still works
      // $link = "https://www.linkedin.com/shareArticle?mini=true&url={$permalink}";
      // 2020 version
      $link = "https://www.linkedin.com/sharing/share-offsite/?url={$permalink}";
      break;
    case 'vk':
      $link = "https://vk.com/share.php?url={$permalink}";
      break;
    case 'email':
      $link = "mailto:info@example.com?&subject=&cc=&bcc=&body={$permalink}%0A";
      break;
    case 'telegram':
      $link = "https://t.me/share/url?url={$permalink}&text=";
      break;
    default:
      $link = "";
      break;
  }

  ob_start();
  $title = __('Share on', TEXT_DOMAIN) . ' ' . ucfirst($social); ?>

  <div class="share-link-wrapper <?= $social; ?>-share">
    <a class="share-link" href="#" title="<?= $title; ?>" onclick="popUp=window.open('<?= $link; ?>', 'popupwindow', 'scrollbars=yes,width=800,height=400');popUp.focus();return false;">
      <img src="<?= get_stylesheet_directory_uri() . '/dist/images/social/' . $social; ?>.svg" alt="<?= $title; ?>" />
    </a>
  </div>
<?php
  return ob_get_clean();
}

/**
 * Generates the share markup
 *
 * @date 2022-02-17
 *
 * @param {array} $socials - Array with names of social networks to add. Currently supported ['facebook', 'twitter', 'pinterest', 'linkedin', 'vk', 'email', 'telegram']
 * @param {string} $permalink - Link of the page that is being shared
 * @param {string} $title - Optional title for the share button
 *
 * @returns {string} - The share markup
 */
function generate_share($socials, $permalink, $title = '')
{
  // Import the styling
  wp_register_style('Geomatrix-share', get_stylesheet_directory_uri() . '/dist/styles/components/share.css', array(), '1.0.0');
  wp_enqueue_style('Geomatrix-share');

  ob_start(); ?>

  <div class="share">
    <a class="share-title" href="#" target="_blank">
      <?php
      if (!empty($title)) : ?>
        <span><?= __($title, TEXT_DOMAIN); ?></span>
      <?php
      endif; ?>
      <span class="share-image"></span>
    </a>
    <?php
    // calculate delay depending on how many items selected
    $visibility_delay = $animation_delay = count($socials) * 50;
    // half transition delay plus 25ms for smoother animation
    $visibility_delay += $visibility_delay / 2 + 25; ?>
    <div class="share-list-wrapper" style="--visibility-deplay: <?= $visibility_delay; ?>ms">
      <ul class="share-list">
        <?php
        foreach ($socials as $social) : ?>
          <li style="--animation-delay: <?= $animation_delay; ?>ms">
            <?= generate_social_link($social, $permalink); ?>
          </li>
        <?php
          $animation_delay -= 50;
        endforeach; ?>
      </ul>
    </div>
  </div>

  <?php
  return ob_get_clean();
}

/**
 * Generates the markup for an element |
 * img - [url, title] |
 * a - [url, target, title, data-attrs] |
 * default (div) - string
 *
 * @date 2022-02-17
 *
 * @param {sring} $content - The element content
 * @param {sring} $class - The element class
 * @param {sring} $tag='div' - The element tags
 *
 * @returns {any} - Element markup
 */
function generate_element($content, $class = "", $tag = 'div', $translate = false)
{
  ob_start();

  if (!empty($content)) {

    switch ($tag):
      case 'image':
      case 'img': ?>
        <img class="<?= $class; ?>" src="<?= $content["url"]; ?>" alt="<?= $content["alt"]; ?>" />
      <?php
        break;

      case 'video': ?>
        <video autoplay loop muted playsinline>
          <source src="<?= $content["url"]; ?>" type="<?= $content["mime_type"]; ?>">
          <?= __("Your browser does not support the video tag.", TEXT_DOMAIN); ?>
        </video>
        <?php
        break;

      case 'text':
        if (pathinfo($content['filename'])['extension'] === "json") : ?>
          <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
          <lottie-player src=<?= $content['url'] ?> background="transparent" speed="1" loop autoplay></lottie-player>
        <?php
        endif;
        break;

      case 'link':
      case 'a': ?>
        <a href='<?= do_shortcode($content['url']); ?>' <?= (!empty($content['target'])) ? " target='{$content['target']}'" : ""; ?><?= (!empty($class)) ? " class='{$class}'" : ""; ?><?= (isset($content['download'])) ? " download" : ""; ?>>
          <?= prepare_content($content['title'], $translate); ?>
        </a>
        <?php
        if (isset($content['risk_warning'])) :
          if ($content['risk_warning']['enable']) :
            $rw_text = "Your capital is at risk";

            if ($content['risk_warning']['include_terms']) {
              $rw_text .= ". T&Cs Apply.";
            } ?>

            <?= generate_element(__($rw_text, TEXT_DOMAIN), 'risk-warning'); ?>
          <?php
          endif; ?>
        <?php
        endif; ?>
      <?php
        break;
      default:
        echo "<{$tag} class='{$class}'>"; ?>
        <?= prepare_content($content, $translate); ?>
    <?php
        echo "</{$tag}>";
        break;
    endswitch;
  }

  return ob_get_clean();
}

function prepare_content($content, $translate)
{
  ob_start();
  $the_content = do_shortcode($content);
  if ($translate) : ?>
    <?= __($the_content, TEXT_DOMAIN); ?>
  <?php
  else : ?>
    <?= $the_content; ?>
  <?php
  endif;

  return ob_get_clean();
}

function search_markup()
{
  ob_start();
  ?>
  <div class="search-wrapper">
    <form action="/" method="get">
      <div class="form-inner">
        <label for="s" class="sronly"><?= __("Enter your search keywords here", TEXT_DOMAIN); ?></label>

        <div class="input-wrapper">
          <input type="text" name="s" id="search" placeholder="<?= __("Search", TEXT_DOMAIN); ?>">

          <button type="submit">
            <span class="sronly"><?= __("Click to search the site for your keywords", TEXT_DOMAIN); ?></span>
            <?= file_get_contents(get_stylesheet_directory_uri() . "/dist/images/search.svg"); ?>
          </button>
        </div>
      </div>
    </form>
  </div>
<?php
  return ob_get_clean();
}

function get_buttons_markup($buttons)
{
  if (
    !$buttons['enable']
    || empty($buttons['items'])
  ) {
    return "";
  }

  ob_start(); ?>

  <div class="buttons">
    <?php
    foreach ($buttons['items'] as $button) : ?>

      <div class="button-wrapper">
        <?php
        $button['link']['risk_warning'] = $button['risk_warning']; ?>
        <?= generate_element($button['link'], "btn {$button['type']}", 'a'); ?>

        <?php
        if ($button['custom_html']['enable']) : ?>
          <?= generate_element($button['custom_html']['text'], 'custom-html'); ?>
        <?php
        endif; ?>
      </div> <!-- .button-wrapper -->

    <?php
    endforeach; ?>
  </div> <!-- .button-wrapper -->

<?php
  return ob_get_clean();
}

function get_footnote_markup($footnote)
{
  if (
    !$footnote['enable']
    || empty($footnote['text'])
  ) {
    return "";
  }

  ob_start();
  $footnote_class = "footnote";
  if ($footnote['line_above']) {
    $footnote_class .= " line";
  } ?>
  <?= generate_element($footnote['text'], $footnote_class); ?>
<?php
  return ob_get_clean();
}

function get_custom_html_markup($custom_html)
{
  if (
    !$custom_html['enable']
    || empty($custom_html['text'])
  ) {
    return "";
  }

  ob_start(); ?>
  <?= generate_element($custom_html['text'], 'custom-html'); ?>
<?php
  return ob_get_clean();
}

function check_component_variables($sections, $args)
{
  if (empty($sections)) {
    return null;
  }

  $section_index = 0;
  if (!empty($args)) {
    $section_index = $args['index'];
  }

  if (!isset($sections[$section_index])) {
    return null;
  }

  return $sections[$section_index];
}

function get_page_type()
{
  global $wp_query;
  $type = 'notfound';

  if ($wp_query->is_page) {
    $type = is_front_page() ? 'front' : 'page';
  } elseif ($wp_query->is_home) {
    $type = 'home';
  } elseif ($wp_query->is_single) {
    $type = ($wp_query->is_attachment) ? 'attachment' : 'single';
  } elseif ($wp_query->is_category) {
    $type = 'category';
  } elseif ($wp_query->is_tag) {
    $type = 'tag';
  } elseif ($wp_query->is_tax) {
    $type = 'tax';
  } elseif ($wp_query->is_archive) {
    if ($wp_query->is_day) {
      $type = 'day';
    } elseif ($wp_query->is_month) {
      $type = 'month';
    } elseif ($wp_query->is_year) {
      $type = 'year';
    } elseif ($wp_query->is_author) {
      $type = 'author';
    } else {
      $type = 'archive';
    }
  } elseif ($wp_query->is_search) {
    $type = 'search';
  } elseif ($wp_query->is_404) {
    $type = 'notfound';
  }

  return $type;
}

/**
 * Allow additional MIME types
 * Use 'text/plain' instead of 'application/json' for JSON because of a current Wordpress core bug
 */

function add_upload_mimes($types)
{
  $types['json'] = 'text/plain';
  return $types;
}
add_filter('upload_mimes', 'add_upload_mimes');
