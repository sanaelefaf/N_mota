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