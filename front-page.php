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
        
           //Récupère les termes de la taxonomie "categorie" et les stocke dans la variable $categories.
            $categories = get_terms(array(
                'taxonomy' => 'categorie',
                'hide_empty' => false,
            ));
            ?>

            <select id="categorie" name="categorie">
                <option class="option" value="" >CATEGORIES</option>
                <?php
                // Boucle pour afficher les options du menu déroulant pour les catégories
                foreach ($categories as $categorie) {
                    // // Vérifie si une catégorie est sélectionnée dans l'URL, si oui, la marque comme "selected"
                    $selected = isset($_GET['categorie']) && $_GET['categorie'] === $categorie->slug ? 'selected' : '';
                    // Affiche une option du menu déroulant avec la valeur du slug de la catégorie comme "value" et le nom de la catégorie comme étiquette.
                    echo '<option value="' . esc_attr($categorie->slug) . '" ' . $selected . '>' . esc_html($categorie->name) . '</option>';
                }
                ?>
             
            </select>

            <?php
            //// Récupération des termes de taxonomie 'format' via get_terms
            $formats = get_terms(array(
                'taxonomy' => 'format',
                'hide_empty' => false,
            ));
            ?>
            <select id="format" name="format">
                <option value="">FORMATS</option>
                <?php
                //// Boucle pour afficher les options du menu déroulant pour les formats
                foreach ($formats as $format) {
                    //// Vérifie si un format est sélectionné dans l'URL, si oui, le marque comme "selected"
                    $selected = isset($_GET['format']) && $_GET['format'] === $format->slug ? 'selected' : '';
                    // Affiche une option du menu déroulant via slug uniques.
                    echo '<option value="' . esc_attr($format->slug) . '" ' . $selected . '>' . esc_html($format->name) . '</option>';
                } // esc_attr :fonction WordPress qui est utilisée pour échapper et sécuriser les données avant de les afficher dans une sortie HTML
                ?>
            </select>

            <select id="sort" name="sort">
            <option value="">TRIER PAR</option>
                <option value="desc" <?php echo isset($_GET['sort']) && $_GET['sort'] === 'desc' ? 'selected' : ''; ?>>Plus récentes</option> <!--- vérifie si le paramètre "sort" existe dans l'URL (via isset($_GET['sort'])) et si sa valeur est égale à "desc". Si c'est le cas, elle ajoute l'attribut "selected" à l'option !-->
                <option value="asc" <?php echo isset($_GET['sort']) && $_GET['sort'] === 'asc' ? 'selected' : ''; ?>>Plus anciennes</option>
            </select>
    
        </form>
            </section>

    <section class="hero">
    <div id="photo-list" class="photo-grid"> 
        <?php
        //  boucle WordPress de la fonction AJAX load_photos 
        //Ces variables sont utilisées pour stocker les valeurs des paramètres de filtre de l'URL (catégorie, format, tri et page).
        $category = isset($_GET['categorie']) ? $_GET['categorie'] : ''; // Condtitionelle via ? , Si le paramètre "categorie" existe dans l'URL, cette partie récupère sa valeur depuis $_GET['categorie']. sinon renvoie : ''
        $format = isset($_GET['format']) ? $_GET['format'] : '';
        $sort = isset($_GET['sort']) ? $_GET['sort'] : '';
        $page = isset($_GET['page']) ? $_GET['page'] : 1; // Page par défaut : 1
       

      // tableau d'arguments qui sera utilisé pour la requête WP_Query afin de récupérer les photos.
        $args = array(
            'post_type' => 'photos',
            'posts_per_page' => 8,
            'paged' => $page,//page actuelle
            'orderby' => 'rand', //aleatoire
           
   
        );

        //tableau qui sera utilisé pour stocker les requêtes de taxonomie basées sur les filtres de catégorie et de format sélectionnés par l'utilisateur.
        $tax_queries = array();

        //condition qui verifie si filtres catégo et format ont ete selectionnés
        //si oui on les ajoute a la requete en utilisant un tableau
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

        //vérifie si l'utilisateur a choisi de trier les photos par ordre croissant 
        if ($sort === 'asc') {
            $args['order'] = 'ASC';
        }

        //  date de publication
        $args['orderby'] = 'rand';

     //l'objet WP_Query qui est créé avec les arguments définis, prêt à exécuter la requête.
        $query = new WP_Query($args);

        //érifie si la requête a trouvé des photos correspondantes. 
        //Si c'est le cas, elle entre dans la boucle while pour afficher chaque photo.
        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                
        ?>
                 
                

                <?php get_template_part( 'template_parts/photo_block' ); ?>
               
        <?php
            }
            wp_reset_postdata();// réinitialise les données de la requête WP_Query pour éviter d'éventuels conflits avec d'autres requêtes ultérieures.
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
