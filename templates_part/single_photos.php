
<div id="photo">
    <div id="photo-list">
        <!--Zone pour afficher photos a l'aide boucle pour parcourir les articles-->
        <?php $displayed_posts_ids = array();// ID DES PHOTOS STOCKE DANS TABLEAU// 
        while (have_posts()) : the_post();
        $displayed_posts[] = get_the_ID(); ?>

            <h2><?php the_title(); ?></h2>
            <div class="photo-image">
                <?php the_post_thumbnail('large'); ?>
            </div>
            <div class="photo-description">
                <?php the_content(); ?>
            </div>
        <?php endwhile; 
        setcookie('displayed_posts_ids', json_encode($displayed_posts_ids), time() + 3600, '/');
        ?>
    </div>

</div>
<div class="popup">
    <!-- Contenu de la popup ici -->
</div>
<!-- Affiche articles photos en fonction des catégories et format-->
<div class="related-photos">
    <?php
    $current_category = isset($_GET['categorie']) ? $_GET['categorie'] : ''; //récuperation des valeurs
    $current_format = isset($_GET['format']) ? $_GET['format'] : '';
    $args_related = array(
        'post_type' => 'photo',
        'posts_per_page' => 12,
        'tax_query' => array( //filtré via catégo en cours//
            array(
                'taxonomy' => 'categorie',
                'field' => 'slug',
                'terms' => $current_category,
            ),
        ),
    );
    $query_related = new WP_Query($args_related);
    
    if ($query_related->have_posts()): //vérifie si les articles ont été trouvé//
        while ($query_related->have_posts()) :
            $query_related->the_post();
            // Afficher la photo apparentée ici
            ?>
            <div class="related-photo">
                <a href="<?php the_permalink(); ?>">
                    <?php the_post_thumbnail('thumbnail'); ?>
                </a>
            </div>
        <?php endwhile;
        wp_reset_postdata();// réinitialise données//

    endif; ?>
    
    
</div>






