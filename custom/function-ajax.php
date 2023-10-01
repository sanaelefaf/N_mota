

<?php
// ACTION AJAX : Charger les photos
function load_photos() {
    // Récupérer les paramètres de la requête Ajax
    $category = isset($_GET['categorie']) ? $_GET['categorie'] : '';
    $format = isset($_GET['format']) ? $_GET['format'] : '';
    $sort = isset($_GET['sort']) ? $_GET['sort'] : '';
    $page = isset($_GET['page']) ? intval($_GET['page']) : 2; 
   
// ...

$args = array(
    'post_type' => 'photos',
    'posts_per_page' => 12,
    'paged' => 2, // Utilisez le numéro de page actuel pour la pagination
    'order' => 'DESC',
    'post__not_in' => $already_displayed_posts,
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
    ob_start();

    $counter = 0; // Initialiser le compteur

    while ($query->have_posts()) {
        $query->the_post();


        // Si le compteur est inférieur ou égal à 12, passez à la prochaine itération (ignorer les 12 premières photos)
       
        $photo_id = get_the_ID();
        $type = get_field('type'); // le type depuis ACF
        $reference = get_field('reference'); // la référence depuis ACF
        $photo_url = get_post_meta($photo_id, 'photo', true);
        $taxo_categorie = get_the_terms($photo_id, 'categorie');
        $photo_permalink = get_permalink($photo_id);
        $already_displayed_posts[] = $photo_id;
        setcookie('already_displayed_posts', implode(',', $already_displayed_posts), time() + 3600, '/'); // Stocker les ID sous forme de chaîne séparée par des virgules

        ?>
        <div class="photo" data-photo-id="<?php echo $photo_id; ?>" data-photo-url="<?php echo $photo_url; ?>" data-categorie="<?php echo esc_html($taxo_categorie[0]->name)?> " data-reference="<?php echo esc_attr($reference); ?>" data-lightbox-trigger="true">
            <a href="<?php echo $photo_permalink; ?>" class="photo-link">
                <?php the_content(); // Contenu de la photo ?>
                <div class="photo-details">
                    <div class="photo-title"><?php the_title(); ?></div>
                    <div class="photo-category"><?php echo esc_html($taxo_categorie[0]->name)?></div>
                    <div class="eye-icon"><i class="fa fa-eye"></i></div>
                    <div class="fullscreen-icon" data-photo-url="<?php echo esc_url($photo_url); ?>" data-type="<?php echo esc_attr($type); ?>" data-reference="<?php echo esc_attr($reference); ?>" data-categorie="<?php echo isset($current_photo_category) ? esc_attr($current_photo_category->name) : ''; ?>"><i class="fa fa-expand"></i></div>
                </div>
            </a>
        </div>
        <?php
 $counter++;
    }

     // Appel à la fonction JavaScript une seule fois après avoir chargé toutes les images
     if ($counter > 0) {
        echo '<script>setupLightbox();</script>';
     }
    wp_reset_postdata();
} else {
    echo 'Aucune photo trouvée.';
}

// ...

    // Arrête l'exécution de WordPress après cette réponse AJAX
    die();
}

// ACTION AJAX : FILTRES
function filter_photos() {
    // Récupérer les paramètres de la requête Ajax
    $category = isset($_GET['categorie']) ? $_GET['categorie'] : '';
    $format = isset($_GET['format']) ? $_GET['format'] : '';
    $sort = isset($_GET['sort']) ? $_GET['sort'] : '';
    $page = isset($_GET['page']) ? intval($_GET['page']) : 1; 
   
// ...

$args = array(
    'post_type' => 'photos',
    'posts_per_page' => 12,
    'paged' => $page, // Utilisez le numéro de page actuel pour la pagination
    'order' => 'DESC',
    'post__not_in' => $already_displayed_posts,
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
    ob_start();

    

    while ($query->have_posts()) {
        $query->the_post();


        // Si le compteur est inférieur ou égal à 12, passez à la prochaine itération (ignorer les 12 premières photos)
       
        $photo_id = get_the_ID();
        $type = get_field('type'); // le type depuis ACF
        $reference = get_field('reference'); // la référence depuis ACF
        $photo_url = get_post_meta($photo_id, 'photo', true);
        $taxo_categorie = get_the_terms($photo_id, 'categorie');
        $photo_permalink = get_permalink($photo_id);
        $already_displayed_posts[] = $photo_id;
        setcookie('already_displayed_posts', implode(',', $already_displayed_posts), time() + 3600, '/'); // Stocker les ID sous forme de chaîne séparée par des virgules

        ?>
        <div class="photo" data-photo-id="<?php echo $photo_id; ?>" data-photo-url="<?php echo $photo_url; ?>" data-categorie="<?php echo esc_html($taxo_categorie[0]->name)?> " data-reference="<?php echo esc_attr($reference); ?>" data-lightbox-trigger="true">
            <a href="<?php echo $photo_permalink; ?>" class="photo-link">
                <?php the_content(); // Contenu de la photo ?>
                <div class="photo-details">
                    <div class="photo-title"><?php the_title(); ?></div>
                    <div class="photo-category"><?php echo esc_html($taxo_categorie[0]->name)?></div>
                    <div class="eye-icon"><i class="fa fa-eye"></i></div>
                    <div class="fullscreen-icon" data-photo-url="<?php echo esc_url($photo_url); ?>" data-type="<?php echo esc_attr($type); ?>" data-reference="<?php echo esc_attr($reference); ?>" data-categorie="<?php echo isset($current_photo_category) ? esc_attr($current_photo_category->name) : ''; ?>"><i class="fa fa-expand"></i></div>
                </div>
            </a>
        </div>
        <?php
    }

     // Appel à la fonction JavaScript une seule fois après avoir chargé toutes les images
    
        echo '<script>setupLightbox();</script>';
     
    wp_reset_postdata();
} else {
    echo 'Aucune photo trouvée.';
}

// ...

    // Arrête l'exécution de WordPress après cette réponse AJAX
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

            // Vous pouvez afficher ici le contenu de l'article unique selon vos besoins
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

// Ajoutez vos actions AJAX
add_action('wp_ajax_filter_photos', 'filter_photos');
add_action('wp_ajax_nopriv_filter_photos', 'filter_photos');
add_action('wp_ajax_load_photos', 'load_photos');
add_action('wp_ajax_nopriv_load_photos', 'load_photos');
add_action('wp_ajax_load_single_post_content', 'load_single_post_content');
add_action('wp_ajax_nopriv_load_single_post_content', 'load_single_post_content');


