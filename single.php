<?php
/*
Template Name: Single Photo
*/
get_header();
?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

    <?php
    // Get specific article data
    $photo_id = get_the_ID();
    $photo_url = get_field('photo'); // URL of the photo from ACF
    $type = get_field('type'); // Type from ACF
    $reference = get_field('référence'); // Reference from ACF
    $taxo_categorie = get_the_terms($photo_id, 'categorie');
    $taxo_format = get_the_terms($photo_id, 'format');
    $taxo_annee = get_the_terms($photo_id, 'annee');
    $photo_permalink = get_permalink(); 
    ?>

    <div class="containerPrincipalSingle">
        <div class="containerSingle">
            <div class="detailsPhoto">
                <h2><?php the_title(); ?></h2>
                <div class="infosPhoto">
                    <p><?php echo 'RÉFÉRENCE: ' . esc_html($reference) . '<br>'; ?></p>
                    <p><?php echo 'CATÉGORIE: ' . esc_html($taxo_categorie[0]->name) . '<br>'; ?></p>
                    <p><?php echo 'FORMAT: ' . esc_html($taxo_format[0]->name) . '<br>'; ?></p>
                    <p><?php echo 'TYPE: ' . esc_html($type) . '<br>'; ?></p>
                </div>
            </div>

<a href="<?php echo esc_url($photo_permalink); ?>"class="photo-link">
            <div class="contentPhoto" data-photo-id="<?php echo esc_attr($photo_id); ?>"
                data-photo-url="<?php echo esc_url($photo_url); ?>" data-type="<?php echo esc_attr($type); ?>"
                data-reference="<?php echo esc_attr($reference); ?>"
                data-categorie="<?php echo esc_attr($taxo_categorie[0]->name); ?>">
                <?php the_content(); // Photo content ?>
            </div>
            </a>

        <div class="contactBtn">
            <div class="containerContact">
                <p> Cette photo vous intéresse ? </p>
                <button type="button" class="contactLink" data-reference="<?php echo esc_attr($reference); ?>">Contact
                </button>
            </div>
        </div>
    </div>

    <div class="navigationArrows">
        <?php
        $nextPost = get_next_post();
        $previousPost = get_previous_post();
        if (!empty($previousPost) || !empty($nextPost)) :
        ?>
            <div class="containerImgArrows">
                <?php
                $thumbnail_html = '';
                if (!empty($nextPost)) {
                    $thumbnail_html = get_the_post_thumbnail($nextPost->ID, 'thumbnail');
                } elseif (!empty($previousPost)) {
                    $thumbnail_html = get_the_post_thumbnail($previousPost->ID, 'thumbnail');
                }
                if (!empty($thumbnail_html)) {
                    echo '<div class="containerImgArrows">' . $thumbnail_html . '</div>';
                }
                ?>
            </div>
            <div class="arrowsContainer">
                <?php if (!empty($previousPost)) : ?>
                    <a href="<?php echo esc_url(get_permalink($previousPost->ID)); ?>"
                        class="arrowLink arrowLinkPrevious"
                        data-thumbnail="<?php echo esc_url(wp_get_attachment_image_url(get_post_thumbnail_id($previousPost->ID), 'thumbnail')); ?>">
                        <img class="arrowLeft"
                            src="<?php echo esc_url(get_theme_file_uri() . '/assets/images/arrowLeft.png'); ?>"
                            alt="Flèche précédent">
                    </a>
                <?php endif; ?>
                <?php if (!empty($nextPost)) : ?>
                    <a href="<?php echo esc_url(get_permalink($nextPost->ID)); ?>" class="arrowLink arrowLinkNext"
                        data-thumbnail="<?php echo esc_url(wp_get_attachment_image_url(get_post_thumbnail_id($nextPost->ID), 'thumbnail')); ?>">
                        <img class="arrowRight"
                            src="<?php echo esc_url(get_theme_file_uri() . '/assets/images/arrowRight.png'); ?>"
                            alt="Flèche suivant">
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
    <p class="imgAppTitle">Vous aimerez aussi</p>
<div class="containerPrincipalImg">
    <?php
    // Récupérez les catégories de la photo actuelle
    $current_photo_categories = wp_get_post_terms($photo_id, 'categorie', array('fields' => 'ids'));

    $args = array(
        'post_type' => 'photos',
        'posts_per_page' => 2,
        'post__not_in' => array($photo_id), // Exclure la photo actuelle
        'tax_query' => array(
            array(
                'taxonomy' => 'categorie',
                'field' => 'id', // Vous recherchez les IDs de la taxonomie ici
                'terms' => $current_photo_categories, // Utilisez les catégories de la photo actuelle
                'operator' => 'IN', // Assurez-vous que les catégories correspondent
            ),
        ),
    );

    $related_photos = new WP_Query($args);

    if ($related_photos->have_posts()) :
        while ($related_photos->have_posts()) : $related_photos->the_post();
    ?>
            <div class="containerImg">
    <a href="<?php echo esc_url(get_permalink()); ?>" data-photo-url="<?php echo esc_url(get_field('photo')); ?>" data-type="<?php echo esc_attr(get_field('type')); ?>" data-reference="<?php echo esc_attr(get_field('référence')); ?>">
        <?php the_content(); ?>
    </a>
</div>

    <?php
        endwhile;
        wp_reset_postdata(); // Réinitialisez les données des articles pour éviter les conflits
    else :
        echo 'Aucune photo apparentée trouvée.';
    endif;
    ?>
</div>

    <button type="button" class="buttonAllPhoto">
        <a href="<?php echo esc_url(home_url()); ?>#galleryPhoto">Toutes les photos</a>
    </button>

<?php endwhile; else : ?>
    <p>Aucun article trouvé.</p>
<?php endif; ?>

<?php get_footer(); ?>
