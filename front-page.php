<!DOCTYPE html> 
<html lang="fr">
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
<div class="content">
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
                
             
                <div class="photo" data-photo-id="<?php echo $photo_id; ?>" data-photo-url="<?php echo $photo_url; ?>" data-categorie="<?php echo esc_html($taxo_categorie[0]->name)?> " data-reference="<?php echo esc_attr($reference); ?>">


                    <a href="<?php echo $photo_permalink; ?>" class="photo-link">
                        <?php the_content(); // Contenu de la photo ?>

                        <div class="photo-details">

                            <div class="photo-title"><?php the_title(); ?></div> 
                           

                                <div class="photo-category"><?php echo esc_html($taxo_categorie[0]->name)?></div> 
                         

                            <div class="eye-icon">
                                <i class="fa fa-eye"></i>
                            </div>

                            <div class="fullscreen-icon" data-photo-url="<?php echo esc_url($photo_url); ?>" data-type="<?php echo esc_attr($type); ?>" data-reference="<?php echo esc_attr($reference); ?>" data-categorie="<?php echo isset($current_photo_category) ? esc_attr($current_photo_category->name) : ''; ?>">
                                <i class="fa fa-expand"></i>
                            </div>
                        </div>
                    </a>
                </div>
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
<footer>
    <?php get_footer(); ?>
</footer>
</body>
</html>
