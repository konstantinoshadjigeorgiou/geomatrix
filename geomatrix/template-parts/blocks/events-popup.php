<?php

use Geomatrix\Events\Events_Helper;

$Events_Helper = new Events_Helper(); ?>

<div class="modal">
  <form action="" class="modal-form">
    <div class="modal-inner">
      <div class="modal-head">
        <?= generate_element(__('Register for', TEXT_DOMAIN) . " " . $args['title'], "modal-title"); ?>
        <?= generate_element(
          [
            'url' => '',
            'title' => "<span class='sronly'>" . __('Close', TEXT_DOMAIN) . "</span>",
            'data-attrs' => 'data-event-id="' . $args['id'] . '"'
          ],
          'modal-close',
          'a'
        ); ?>
      </div>

      <div class="modal-body">
        <div class="form-group">
          <label>
            <?= __('First name', TEXT_DOMAIN); ?>
            <input type="text" name="first-name" class="first-name" />
          </label>
        </div>

        <div class="form-group">
          <label>
            <?= __('Last name', TEXT_DOMAIN); ?>
            <input type="text" name="last-name" class="last-name" />
          </label>
        </div>

        <div class="form-group">
          <label>
            <?= __('Email', TEXT_DOMAIN); ?>
            <input type="text" name="email" class="email" />
          </label>
        </div>

        <div class="form-group">
          <label>
            <?= __('Country of residence', TEXT_DOMAIN); ?>

            <select name="country" class="country">
              <?php
              foreach ($Events_Helper->get_countries() as $key => $country) : ?>
                <option value="<?= $key; ?>"><?= $country; ?></option>
              <?php
              endforeach; ?>
            </select>
          </label>
        </div>

        <div class="form-group">
          <label>
            <?= __('Phone code', TEXT_DOMAIN); ?>
            <select name="phone-code" class="phone-code">
              <?php
              foreach ($Events_Helper->get_phonecodes() as $key => $phone_code) : ?>
                <option value="<?= $key; ?>"><?= $phone_code; ?></option>
              <?php
              endforeach; ?>
            </select>
          </label>
        </div>

        <div class="form-group">
          <label>
            <?= __('Telephone', TEXT_DOMAIN); ?>
            <input type="text" name="telephone" class="telephone" />
          </label>
        </div>
      </div>

      <div class="modal-footer">
        <?= generate_element(
          [
            'url' => '',
            'title' => __('Submit', TEXT_DOMAIN),
            'data-attrs' => 'data-event-id="' . $args['id'] . '"'
          ],
          'primary modal-submit',
          'a'
        ); ?>
        <?= generate_element(
          [
            'url' => '',
            'title' => __('Close', TEXT_DOMAIN),
            'data-attrs' => 'data-event-id="' . $args['id'] . '"'
          ],
          'secondary modal-close',
          'a'
        ); ?>
      </div>
    </div>
  </form>
</div>