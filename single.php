<?php 
/*
Template Name: Single Photo
*/
?>
<!DOCTYPE html> 
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nathalie motat</title>
    <?php wp_head(); ?>
<header>
<?php get_header();

?>
</header>
<body>
<?php if (have_posts()) : while (have_posts()) : the_post();//boucle WordPress qui parcourt les articles existants. La boucle continuera tant qu'il y aura des articles à traiter.
 ?>

    <?php
    // Recupere toute les données 
    $photo_id = get_the_ID();
    $photo_url = get_post_meta($post->ID, 'photo', true);// Récupère la valeur du champ personnalisé 'photo' de l'article en cours.
    $type = get_field('type'); 
    $reference = get_field('reference'); 
    $taxo_categorie = get_the_terms($photo_id, 'categorie');//les termes de la taxonomie 'categorie' associés à l'article actuel 
    $taxo_format = get_the_terms($photo_id, 'format');
    $taxo_annee = get_the_terms($photo_id, 'annee');
    $photo_permalink = get_permalink(); 
    ?>

    <div class="containerPrincipalSingle">
        <div class="containerSingle">
            <div class="detailsPhoto">
                <h2><?php the_title(); ?></h2>
                <div class="infosPhoto">
                    <!--- Affiche les infos nécéssaire ---->
                    <p><?php echo 'RÉFÉRENCE: ' . esc_html($reference) . '<br>'; ?></p>
                    <p><?php echo 'CATÉGORIE: ' . esc_html($taxo_categorie[0]->name) . '<br>'; //extrait le nom de la première catégorie associée à l'article?></p>
                    <p><?php echo 'FORMAT: ' . esc_html($taxo_format[0]->name) . '<br>'; ?></p>
                    <p><?php echo 'TYPE: ' . esc_html($type) . '<br>'; ?></p>
                    <p> <hr class="singleline"></p>
                </div>
            </div>
<!--- Photo associé ---->
<a href="<?php echo esc_url($photo_permalink); ?>"class="photo-link">
            <div class="contentPhoto" data-photo-id="<?php echo esc_attr($photo_id); ?>"
                data-photo-url="<?php echo esc_url($photo_url); ?>" data-type="<?php echo esc_attr($type); ?>"
                data-reference="<?php echo esc_attr($reference); ?>"
                data-categorie="<?php echo esc_attr($taxo_categorie[0]->name); ?>">
                <?php the_content(); // Photo content ?>
            </div>
            </a>
        
            </div>
        <div class="contactBtn">
            <div class="containerContact">
                <p> Cette photo vous intéresse ? </p>
                <button type="button"  id="openContactModal" class="contactLink" data-reference="<?php echo esc_attr($reference); ?>">Contact
                </button>

            </div>
      
  

    <div class="navigationArrows">
        <?php
        $nextPost = get_next_post();// recupere article suivant
        $previousPost = get_previous_post(); // art precedent
        if (!empty($previousPost) || !empty($nextPost)) ://si au moins l'un des articles précédents ou suivants existe. Si l'un des deux existe, le code suivant est exécuté.
        ?>
            <div class="containerImgArrows">
                <?php
                // détermine quelle miniature afficher en fonction de la disponibilité de l'article précédent ou suivant :
                
                $thumbnail_html = '';
                if (!empty($nextPost)) {
                    $thumbnail_html = get_the_post_thumbnail($nextPost->ID, 'thumbnail');//écupère la miniature de l'article suivant 
                } elseif (!empty($previousPost)) {
                    $thumbnail_html = get_the_post_thumbnail($previousPost->ID, 'thumbnail');// " precedent 
                }
                if (!empty($thumbnail_html)) //si la variable n'est pas vide // 
                {
                    echo '<div class="containerImgArrows">' . $thumbnail_html . '</div>';//vérifie si une miniature a été récupérée avec succès.
                }
                ?>
            </div>


            <div class="arrowsContainer">
                <?php if (!empty($previousPost)) ://Si une miniature a été récupérée, elle est affichée à l'intérieur du conteneur containerImgArrows. ?>
                    <a href="<?php echo esc_url(get_permalink($previousPost->ID)); ?>"
                        class="arrowLink arrowLinkPrevious"
                        data-thumbnail="<?php echo esc_url(wp_get_attachment_image_url(get_post_thumbnail_id($previousPost->ID), 'thumbnail')); 
                        //L'URL du lien est générée à partir de l'URL de l'article précédent, et il y a un attribut "data-thumbnail" qui stocke l'URL de la miniature de l'article précédent.
                        ?>">
                        
                        <img class="arrowLeft"
                            src="<?php echo esc_url(get_theme_file_uri() . '/assets/images/arrowLeft.png'); // AFfiche fleche?>"
                            alt="Flèche précédent">
                    </a>
                <?php endif; ?>

                <?php if (!empty($nextPost)) : //Cette ligne vérifie si un article précédent existe.?>
                    <a href="<?php echo esc_url(get_permalink($nextPost->ID)); ?>" class="arrowLink arrowLinkNext"
                        data-thumbnail="<?php echo esc_url(wp_get_attachment_image_url(get_post_thumbnail_id($nextPost->ID), 'thumbnail'));
                        //L'URL du lien est générée à partir de l'URL de l'article précédent, et il y a un attribut "data-thumbnail" qui stocke l'URL de la miniature de l'article précédent.
                        ?>">
                        
                        <img class="arrowRight"
                            src="<?php echo esc_url(get_theme_file_uri() . '/assets/images/arrowRight.png'); //Affiche fleche?>"
                            alt="Flèche suivant">
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
    </div>
    <div class="ligne">
      <hr class="singleline">
      </div>

      <!-- photo apparentés-->

    <p class="imgAppTitle">Vous aimerez aussi</p>
<div class="Principal">
<div class="containerPrincipalImg">
    <?php
   
    $current_photo_categories = wp_get_post_terms($photo_id, 'categorie', array('fields' => 'ids'));
    //récupère les termes (catégories) associés à la photo actuellement en cours de traitement 

    // definition des arguments pour la requete WP
    $args = array(
        'post_type' => 'photos',
        'posts_per_page' => 2,
        'post__not_in' => array($photo_id), // Exclure la photo actuelle
        'tax_query' => array(
            array(
                'taxonomy' => 'categorie',
                'field' => 'id', //Compare les IDs des termes.
                'terms' => $current_photo_categories, // Fait correspondre les termes actuels (catégories) de la photo avec les termes des photos liées.
                'operator' => 'IN', //opérateur IN pour rechercher les photos qui correspondent à l'une des catégories de la photo actuelle.
            ),
        ),
    );

    //exécute la requête WP_Query 
    $related_photos = new WP_Query($args);

    if ($related_photos->have_posts()) ://Vérifie si des photos liées ont été trouvées.
        while ($related_photos->have_posts()) : $related_photos->the_post();
        //parcourt les photos liées trouvées par la requête WP_Query.
    ?>
           

        <?php get_template_part( 'template_parts/photo_block' ); ?>
    


    <?php
        endwhile;
        wp_reset_postdata(); // Réinitialiser les données des articles pour éviter les conflits
    else :
        echo 'Aucune photo apparentée trouvée.';
    endif;
    ?>
</div>
</div>


<div class="button">
    <button type="button" class="buttonAllPhoto">
        <a href="<?php echo esc_url(home_url()); ?>#galleryPhoto">Toutes les photos</a>
    </button>
    </div>
<?php endwhile; else : ?>
    <p>Aucun article trouvé.</p>
<?php endif; ?>
<footer>
<?php get_footer(); ?>
</footer>
</body>
</html>