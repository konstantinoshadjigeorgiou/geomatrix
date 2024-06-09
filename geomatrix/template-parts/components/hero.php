<?php
$heading = get_field('heading');
$description = get_field('description');
$image = get_field('image');
?>
<div class="container">
    <div class="hero__content">
        <div class="hero__hero">
            <div class="hero__inner">
                <div class="hero__media">
                    <img src="<?php echo $image; ?>" alt="<?php echo $image; ?>" />
                </div>
                <div class="hero__text">
                    <h1><?php echo $heading; ?></h1>
                    <?php echo $description; ?>
                </div>
            </div>
        </div>
    </div>
</div>