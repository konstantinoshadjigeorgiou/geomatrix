<form role="search" method="get" id="searchform" class="searchform" action="<?php echo esc_url(home_url('/')); ?>">
  <div>
    <label class="screen-reader-text" for="s"><?php echo __('Search for', TEXT_DOMAIN); ?>:</label>
    <div class="buttons">
      <input type="text" value="" name="s" id="s">
      <input type="submit" class="primary" id="searchsubmit" value="<?php echo __('Search', TEXT_DOMAIN); ?>">
    </div>
  </div>
</form>