<!DOCTYPE html> 
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Nathalie motat</title>
    <?php wp_head(); ?> 
</head>
<body>
<header>
    <?php get_header(); ?>
</header>
<main>
<div class="event">
    <h1>PHOTOGRAPHE EVENT</h1>
</div>
<div class="content">
    <section class="filters">
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
            </section>

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
            'posts_per_page' => 8,
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

        //  date de publication
        $args['orderby'] = 'date';

        $query = new WP_Query($args);

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $photo_id = get_the_ID();
                $type = get_field('type'); // le type depuis ACF
                $reference = get_field('reference'); // la référence depuis ACF
                $already_displayed_posts[] = get_the_ID();
                $photo_url = get_post_meta($photo_id, 'photo', true);
               

                $home_page_id = get_option('page_on_front');
               
            
                $taxo_categorie = get_the_terms($photo_id, 'categorie');
                $home_page_url = get_permalink($home_page_id);
             
                $photo_permalink = get_permalink($photo_id);
        ?>
                
              
                

                <?php get_template_part( 'template_parts/photo_block' ); ?>
               
        <?php
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
    </main>
<footer>
    <?php get_footer(); ?>
</footer>
</body>
</html>
