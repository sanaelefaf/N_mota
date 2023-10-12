

<?php
// ACTION AJAX : Charger les photos
function load_photos() {
    // Récupérer les paramètres de la requête Ajax
    $category = isset($_GET['categorie']) ? $_GET['categorie'] : '';
    $format = isset($_GET['format']) ? $_GET['format'] : '';
    $sort = isset($_GET['sort']) ? $_GET['sort'] : '';
    $page = isset($_GET['page']) ? intval($_GET['page']) : 2; 
     // Initialisation le tableau pour suivre les articles déjà affichés
    $already_displayed_posts = array();


  //Ctableau d'arguments $args qui sera utilisé pour effectuer une requête via WP_Query
  $args = array(
     'post_type' => 'photos',
     'posts_per_page' => 8,
     'paged' => 2, // le numéro de page actuel pour la pagination
     'order' => 'DESC',//ordre de tri
     'post__not_in' => $already_displayed_posts,//articles déjà affichés exclus
   
    );

 //requêtes de taxonomie personnalisée 

 $tax_queries = array();//tableau stocker taxonomies


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

 //ordre trie
 if ($sort === 'asc') {
     $args['order'] = 'ASC';
     
    }

 // Trie par date de publication
 $args['orderby'] = 'date';

 //EXECUTE REQUETE 
 $query = new WP_Query($args);


 
   if ($query->have_posts()) {
     ob_start();

     $counter = 0; // Initialiser le compteur

     while ($query->have_posts())//parcourir les elements du post 
       {
          $query->the_post(); //ccéder au prochain article dans la liste des résultats de la requête.
          $already_displayed_posts[] = $photo_id;//ajoute l'ID de l'article actuel à un tableau $already_displayed_posts, qui est utilisé pour suivre les articles déjà affichés.
       

          get_template_part('template_parts/photo_block');

        
         $counter++;// incrémente le compteur pour suivre le nombre d'articles affichés.
       }

      // Appel à la fonction JavaScript une seule fois après avoir chargé toutes les images
     if ($counter > 0) {
          echo '<script>setupLightbox();</script>';
        }
     wp_reset_postdata();
    } 
    else {
      echo 'Aucune photo trouvée.';
    }

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
    // Initialisation le tableau pour suivre les articles déjà affichés
    $already_displayed_posts = array();


 $args = array(
     'post_type' => 'photos',
     'posts_per_page' => 8,
     'paged' => $page, // numéro de page actuel pour la pagination
     'order' => 'DESC',
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

 // Trie par date de publication
 $args['orderby'] = 'date';

 $query = new WP_Query($args);

 if ($query->have_posts()) {
     ob_start();

     while ($query->have_posts()) {
        $query->the_post();


     get_template_part('template_parts/photo_block');

                
    }

    // Appel à la fonction JavaScript une seule fois après avoir chargé toutes les images
    
    echo '<script>setupLightbox();</script>';
     
    wp_reset_postdata();
    } 
    else {
     echo 'Aucune photo trouvée.';
    }
    // Arrête l'exécution de WordPress après cette réponse AJAX
    die();
}


add_action('wp_ajax_filter_photos', 'filter_photos');
add_action('wp_ajax_nopriv_filter_photos', 'filter_photos');
add_action('wp_ajax_load_photos', 'load_photos');
add_action('wp_ajax_nopriv_load_photos', 'load_photos');
