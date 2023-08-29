<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap">
    <title>Nathalie motat</title>

</head>
<body>
<header>
<?php get_header(); ?>
</header>
<div class="event">
<h1>PHOTOGRAPHE EVENT</h1>
</div>
<div >
<div class="filters">
<form action="" method="get">
<?php    //creer formulaire et recuperer tax via get_terms//

        $categories = get_terms(array(
            'taxonomy' => 'categorie', 
            'hide_empty' => false,
        ));
        ?>
    
      
        <select id="categorie" name="categorie">
            <option value="">Catégories</option>
            <?php
            foreach ($categories as $categorie) {
                $selected = isset($_GET['categorie']) && $_GET['categorie'] === $categorie->slug ? 'selected' : '';//rècupere slug de la catégorie.
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
            <option value="">formats</option>
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

<?php echo get_template_part( 'templates_part/single_photos' ); ?>


</div>
<footer>
<?php get_footer(); ?>
</footer>
</body>
</html>


