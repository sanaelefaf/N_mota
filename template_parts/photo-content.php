<!-- single-photo.php -->
<div class="photo-details">
    <h2><?php the_title(); ?></h2>
    <img src="<?php echo get_field('photo'); ?>" alt="<?php the_title_attribute(); ?>">
    <p><?php the_content(); ?></p>
</div>
