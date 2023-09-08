

<?php


// ACTION AJAX : Charger les photos
function load_photos() {
    $category = isset($_GET['categorie']) ? $_GET['categorie'] : '';
    $format = isset($_GET['format']) ? $_GET['format'] : '';
    $sort = isset($_GET['sort']) ? $_GET['sort'] : '';
    $page = isset($_GET['page']) ? $_GET['page'] : 1; // Page par défaut : 1

    $args = array(
        'post_type' => 'photos',
        'posts_per_page' => 12,
        'paged' => $page,
        'post__not_in' => array(get_the_ID()),
    );

    $tax_queries = array();

    if (!empty($category)) {
        $tax_queries[] = array(
            'taxonomy' => 'categorie', 
            'field' => 'slug',
            'terms' => $category,
        );
    }

    if (!empty($format)) {
        $tax_queries[] = array(
            'taxonomy' => 'format', 
            'field' => 'slug',
            'terms' => $format,
        );
    }

    if (!empty($tax_queries)) {
        $args['tax_query'] = $tax_queries;
    }

    if ($sort === 'asc') {
        $args['order'] = 'ASC';
    }

    // Triez par date de publication
    $args['orderby'] = 'date';

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $photo_id = get_the_ID();
            $photo_url = get_field('photo'); // Exemple : Obtenez l'URL de la photo depuis ACF
            $type = get_field('type'); // Exemple : Obtenez le type depuis ACF
            $reference = get_field('référence'); // Exemple : Obtenez la référence depuis ACF
            $permalink = get_permalink(); //
            
            // Créez un élément de photo avec les attributs data requis
        echo '<a href="' . $permalink . '"><div class="photo" data-photo-id="' . $photo_id . '" data-photo-url="' . $photo_url . '" data-photo-permalink="' . $permalink . '" data-type="' . $type . '" data-reference="' . $reference . '">';
        echo get_the_content(); // Contenu de la photo
             echo ' <a href="' . $permalink . '"><img class="hoverEye"  src="' . get_theme_file_uri('/assets/images/iconEye.png') . '" alt="Icone Eye"> </a>
              <h2>' . $reference . '</h2>
              <h3>' . get_the_terms(get_the_ID(), 'categorie')[0]->name . '</h3>';
        echo '</div></a>';

        
        }
        wp_reset_postdata();
    } else {
        echo 'Aucune photo trouvée.';
    }

    die();
}


// Ajoutez vos actions AJAX
add_action('wp_ajax_load_photos', 'load_photos');
add_action('wp_ajax_nopriv_load_photos', 'load_photos');

