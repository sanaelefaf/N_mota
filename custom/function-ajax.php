

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
            $photo_url = get_field('photo'); //  l'URL de la photo depuis ACF
            $type = get_field('type'); //le type depuis ACF
            $reference = get_field('référence'); //  la référence depuis ACF

            // Ajoutez un lien vers le modèle photo-post.php avec l'ID de l'article en tant que paramètre
        $photo_permalink = esc_url(add_query_arg('photo_id', $photo_id, get_permalink()));
        
        echo '<a href="' . $photo_permalink . '" class="photo-link">';
        echo '<div class="photo" data-photo-id="' . $photo_id . '" data-photo-url="' . $photo_url . '" data-type="' . $type . '" data-reference="' . $reference . '">';
        echo get_the_content(); // Contenu de la photo
        echo '</div>';
        echo '</a>';
        }
        wp_reset_postdata();
    } else {
        echo 'Aucune photo trouvée.';
    }

    die();
}

// ACTION AJAX : Charge le contenu d'un article unique
function load_single_post_content() {
    $post_id = $_POST['post_id'];

    // WP_Query pour obtenir le contenu de l'article unique (single-post.php)
    $args = array(
        'post_type' => 'photos',
        'p' => $post_id,
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();

            
            echo '<div class="single-post-content">';
            echo '<h2>' . get_the_title() . '</h2>';
            echo get_the_content();
            echo '</div>';
            
        }
        wp_reset_postdata();
    } else {
        echo 'Aucun contenu trouvé pour cet article.';
    }

    die();
}

//actions AJAX
add_action('wp_ajax_load_photos', 'load_photos');
add_action('wp_ajax_nopriv_load_photos', 'load_photos');
add_action('wp_ajax_load_single_post_content', 'load_single_post_content');
add_action('wp_ajax_nopriv_load_single_post_content', 'load_single_post_content');
