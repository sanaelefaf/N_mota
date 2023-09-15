<?php
// photo-post.php

// Récupérez l'ID de la photo à partir de l'URL
$photo_id = isset($_GET['photo_id']) ? intval($_GET['photo_id']) : 0;

get_header();

if ($photo_id > 0) {
    // Utilisez WP_Query pour récupérer le contenu de l'article
    $args = array(
        'post_type' => 'photos',
        'p' => $photo_id,
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            // Affichez le contenu de l'article
            echo '<h2>' . get_the_title() . '</h2>';
            echo get_the_content();
        }
        wp_reset_postdata();
    } else {
        echo 'Aucun contenu trouvé pour cette photo.';
    }
} else {
    echo 'ID de photo non valide.';
}

get_footer();
?>
