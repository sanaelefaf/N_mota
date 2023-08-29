<?php 
//FILTRES//
function load_photos() {
    $category = $_GET['categorie'];
    $format = $_GET['format'];
    $sort = $_GET['sort'];
    $page = $_GET['page'];

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

            echo '<div class="photo">';
            echo '<h2>' . get_the_title() . '</h2>'; 
            echo get_the_content(); 
            echo '</div>';
        }
        wp_reset_postdata();
    } else {
        echo 'Aucune photo trouvée.';
    }

    die();
}

add_action('wp_ajax_load_photos', 'load_photos');
add_action('wp_ajax_nopriv_load_photos', 'load_photos');
