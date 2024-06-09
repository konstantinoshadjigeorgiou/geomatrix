<?php

/**
 * Fields
 *    class
 *    orientation
 *    direction
 *    subject
 *    title
 *    description
 *    cards
 */

if (function_exists('get_field')) :
  $section = check_component_variables(get_field('cards'), $args);

  if (empty($section)) {
    return;
  }

  // This overides the $title variable. if you ever encounter a related bug, check this
  extract($section);


  // Prepare component classes
  $component_classes = "cards-component component {$orientation} {$direction}";

  if (!empty($class)) {
    $component_classes .= " {$class}";
  }

  $component_classes = trim($component_classes); ?>

  <div class="<?= $component_classes; ?>">

    <div class="container cards-component-inner">

      <div class="component-content">

        <?php
        if (!empty($title['text'])) :
          $title_classes = "title";
         ?>

          <div class="title-wrapper <?= $title['alignment']; ?>">
            <?= generate_element($subject['text'],'subject'); ?>
            <?= generate_element($title['text'], $title_classes, $title['type']); ?>

            <?php
            if ($description['enable'] && !empty($description['text'])) : ?>
              <?= generate_element($description['text'], 'description'); ?>
            <?php
            endif; ?>

          </div>

        <?php
        endif;

        if (!empty($cards['items'])) : ?>

          <?php
          // Cards
          if (!empty($cards['items'])) :

            $cards_wrapper_classes = "cards-wrapper";

            if (count($cards['items']) > 2) {
              $cards_wrapper_classes .= " desktop-carousel";
            } ?>

            <div class="<?= $cards_wrapper_classes; ?>">
              <div class="cards my-slick my-slick-cards">
                <?php
                foreach ($cards['items'] as $key => $item) :
                  /**
                   * Store card-iner markup in a variable to wrap it later
                   */
                  ob_start(); ?>
                  <div class="card-inner <?= $item['alignment']; ?>">
                    <header class="header">
                      <?php
                      switch ($item['media_type']):
                        case 'file': ?>
                          <?php
                          if (!empty($item['file'])) : ?>
                            <?= generate_element($item['file'], $item['file']['type'], $item['file']['type']); ?>
                          <?php
                          endif; ?>
                        <?php
                          break;

                        default: ?>
                        <?php
                          break;
                      endswitch;

                      $card_title = $item['title'];
                      if ($card_title['enable']) :
                        $card_title_classes = "title";
                       ?>
                        <?= generate_element($card_title['text'], $card_title_classes, "h3"); ?>
                      <?php
                      endif; ?>
                    </header>

                    <?php
                    $card_description = $item['description'];

                    if ($card_description['enable']) : ?>

                      <div class="main">

                        <?= generate_element($card_description['text'], "description"); ?>

                      </div> <!-- .main -->
                    <?php
                    endif; ?>
                  </div> <!-- card-inner -->

                  <?php
                  $card_inner = ob_get_clean();

                  $card_classes = "card";
                  if (!empty($item['class'])) {
                    $card_classes .= " {$item['class']}";
                  }
         ?>
                    <article class="<?= $card_classes; ?>">
                      <?= $card_inner; ?>
                    </article>


                <?php
                endforeach; ?>
              </div> <!-- cards my-slick -->

            </div> <!-- cards-wrapper -->
        <?php
          endif;

        endif; ?>

      </div>


    </div>

  </div>

<?php
endif;
