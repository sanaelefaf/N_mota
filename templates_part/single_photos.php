<!-- PHOTOS -->



<div id="photo-list" class="photo-grid">
    
   




</div>
<div id="load-more-container">
    <button id="load-more">Afficher plus</button>
</div>


<!-- Affiche articles photos en fonction des catégories et format -->
<div class="related-photos">
    <?php
    $current_category = isset($_GET['categorie']) ? $_GET['categorie'] : ''; // Récupération des valeurs
    $current_format = isset($_GET['format']) ? $_GET['format'] : '';
    $args_related = array(
        'post_type' => 'photo',
        'posts_per_page' => 12,
        'tax_query' => array( // Filtré via la catégorie en cours
            array(
                'taxonomy' => 'categorie',
                'field' => 'slug',
                'terms' => $current_category,
            ),
        ),
    );

    $query_related = new WP_Query($args_related);


    ?>
</div>

<?php get_footer(); ?>









