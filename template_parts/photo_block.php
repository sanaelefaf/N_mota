<!-- single post -->

<?php

    //recuparations données dynamiquement

    $photo_id = get_the_ID();
    $photo_url = get_post_meta($post->ID, 'photo', true);
    $type = get_field('type'); // Type  ACF
    $reference = get_field('reference'); // Reference  ACF
    $taxo_categorie = get_the_terms($photo_id, 'categorie');
    $taxo_format = get_the_terms($photo_id, 'format');
    $taxo_annee = get_the_terms($photo_id, 'annee');
    $photo_permalink = get_permalink(); 
 ?>

<div class="photo" data-photo-id="<?php echo $photo_id; ?>" data-photo-url="<?php echo $photo_url; ?>" data-categorie="<?php echo esc_html($taxo_categorie[0]->name)?> " data-reference="<?php echo esc_attr($reference); ?>">
  <a href="<?php echo $photo_permalink; ?>" class="photo-link">
     <?php the_post_thumbnail('medium'); // Contenu de la photo ?>

      <!-- Détails photos-->
     <div class="photo-details">

         <div class="photo-title">
             <?php the_title(); ?>
         </div> 
                           

         <div class="photo-category">
                <?php echo esc_html($taxo_categorie[0]->name)?>
         </div> 

         <!-- Icones -->  
         <div class="eye-icon">
                <i class="fa fa-eye"></i>
          </div>

          <div class="fullscreen-icon" data-photo-url="<?php echo esc_url($photo_url); ?>" data-type="<?php echo esc_attr($type); ?>" data-reference="<?php echo esc_attr($reference); ?>" data-categorie="<?php echo isset($current_photo_category) ? esc_attr($current_photo_category->name) : ''; ?>">
             <i class="fa fa-expand"></i>
          </div>
        </div>
   </a>
</div>