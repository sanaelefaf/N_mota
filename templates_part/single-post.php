
<a href="<?php echo esc_url(get_permalink()); ?>">
<div class="containerPrincipalSingle">
    <div class="containerSingle">
        <div class="detailsPhoto">
            <h2><?php echo get_the_title(); ?></h2>
            <div class="infosPhoto">
                <p><?php echo 'RÉFÉRENCE: ' . $reference . '<br>'; ?></p>
                <p><?php echo 'CATÉGORIE: ' . $taxo_categorie[0]->name . '<br>'; ?></p>
                <p><?php echo 'FORMAT: ' . $taxo_format[0]->name . '<br>'; ?></p>
                <p><?php echo 'TYPE: ' . $type . '<br>'; ?></p>
                <p><?php echo 'ANNÉE: ' . $taxo_annee[0]->name . '<br>'; ?></p>
            </div>
        </div>
        <img src="<?php echo $photo_url; ?>" alt="<?php the_title_attribute(); ?>"><br>
    </div>

    <!-- Création de la partie navigation -->

    <div class="contactBtn">
        <!-- Votre code de navigation ici -->
    </div>

    <!-- Intégration de la partie photos apparentées -->

    <p class="imgAppTitle">Vous aimerez aussi</p>
    <div class="containerPrincipalImg">
        <?php
        $categories = get_the_terms(get_the_ID(), 'categorie');
        if ($categories && !is_wp_error($categories)) {
            $category_ids = wp_list_pluck($categories, 'term_id');

            $args = array(
                'post_type' => 'photo',
                'posts_per_page' => 2,
                'post__not_in' => array(get_the_ID()),
                'tax_query' => array(
                    array(
                        'taxonomy' => 'categorie',
                        'field' => 'term_id',
                        'terms' => $category_ids,
                    ),
                ),
            );

            $related_photos = new WP_Query($args);

            if ($related_photos->have_posts()) {
                while ($related_photos->have_posts()) {
                    $related_photos->the_post();
                    $photo_url = get_field('photo');
                    ?>
                    <div class="containerImg">
                        <?php get_template_part('templates-part/related-photo'); ?>
                    </div>
                    <?php
                }
                wp_reset_postdata();
            }
        }
        ?>
    </div>
    <button type="button" class="buttonAllPhoto">
        <a href="<?php echo home_url(); ?>#galleryPhoto">Toutes les photos</a>
    </button>
</div>
</a>