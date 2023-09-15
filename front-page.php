<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap">
    <title>Nathalie motat</title>
    <?php wp_head(); ?> 
</head>
<body>
<header>
    <?php get_header(); ?>
</header>
<div class="event">
    <h1>PHOTOGRAPHE EVENT</h1>
</div>
<div>
    <div class="filters">
        <form action="" method="get">
            <?php
            //formulaire les taxonomies via get_terms
            $categories = get_terms(array(
                'taxonomy' => 'categorie',
                'hide_empty' => false,
            ));
            ?>

            <select id="categorie" name="categorie">
                <option class="option" value="" >Catégories</option>
                <?php
                foreach ($categories as $categorie) {
                    $selected = isset($_GET['categorie']) && $_GET['categorie'] === $categorie->slug ? 'selected' : '';
                    echo '<option value="' . esc_attr($categorie->slug) . '" ' . $selected . '>' . esc_html($categorie->name) . '</option>';
                }
                ?>
             
            </select>

            <?php
            $formats = get_terms(array(
                'taxonomy' => 'format',
                'hide_empty' => false,
            ));
            ?>
            <select id="format" name="format">
                <option value="">Formats</option>
                <?php
                foreach ($formats as $format) {
                    $selected = isset($_GET['format']) && $_GET['format'] === $format->slug ? 'selected' : '';
                    echo '<option value="' . esc_attr($format->slug) . '" ' . $selected . '>' . esc_html($format->name) . '</option>';
                }
                ?>
            </select>

            <select id="sort" name="sort">
                <option value="desc" <?php echo isset($_GET['sort']) && $_GET['sort'] === 'desc' ? 'selected' : ''; ?>>Plus récentes</option>
                <option value="asc" <?php echo isset($_GET['sort']) && $_GET['sort'] === 'asc' ? 'selected' : ''; ?>>Plus anciennes</option>
            </select>
    
        </form>
    </div>

    <section class="hero">
    <div id="photo-list" class="photo-grid"> 
        <?php
        //  boucle WordPress de la fonction AJAX load_photos 
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
                $photo_url = get_field('photo'); // l'URL de la photo depuis ACF
                $type = get_field('type'); // le type depuis ACF
                $reference = get_field('référence'); // la référence depuis ACF
                $already_displayed_posts[] = get_the_ID();

                //  l'ID de la page d'accueil
        $home_page_id = get_option('page_on_front');

        //  l'URL de la page d'accueil en utilisant l'ID
        $home_page_url = get_permalink($home_page_id);
                //  lien vers le modèle photo-post.php avec l'ID de l'article en tant que paramètre
                $photo_permalink = get_permalink($photo_id);
                
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
        ?>
        
    </div>
</section>

    

    <div id="load-more-container">
        <button id="load-more">Afficher plus</button>
    </div>
</div>
<footer>
    <?php get_footer(); ?>
</footer>
</body>
</html>
