<div class="filters">
   
    <select id="category" name="category">
        <option value="">Catégorie</option>
        <option value="reception">Réception</option>
        <option value="mariage">Mariage</option>
        <option value="concert">Concert</option>
        <option value="television">Télévision</option>
    </select>
    
    <select id="format" name="format">
        <option value="">Format</option>
        <option value="paysage">Paysage</option>
        <option value="portrait">Portrait</option>
    </select>
  
    <select id="sort" name="sort">
    <option value="desc">Trier par</option>
        <option value="desc">Plus récentes</option>
        <option value="asc">Plus anciennes</option>
    </select>
</div>

<div id="photo">
<div id="#photo-list">


<?php
$args = array(
    'post_type' => 'attachment',
    'posts_per_page' => 12,
    'post_status' => 'inherit',
    'post_mime_type' => 'image',
);

$query = new WP_Query($args);

if ($query->have_posts()) {
    while ($query->have_posts()) {
        $query->the_post();
        $image = wp_get_attachment_image_src(get_the_ID(), 'thumbnail'); // Changez la taille d'image si nécessaire
        $image_url = $image[0];
        $image_alt = get_post_meta(get_the_ID(), '_wp_attachment_image_alt', true);
        
        echo '<div class="photo">';
        echo '<img src="' . esc_url($image_url) . '" alt="' . esc_attr($image_alt) . '">';
        echo '</div>';
    }
    wp_reset_postdata();
  
} else {
    echo 'Aucune photo trouvée.';
}
?>
</div>

<a href="#" id="load-more">Voir plus</a>

</div>

