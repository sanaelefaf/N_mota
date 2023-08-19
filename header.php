<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nathalie Mota</title>
    <?php wp_head() ?>
   
<body>
<header>
    
    
    <nav id="nav">
    <div class="logo">
        <a href="<?php echo esc_url(home_url('/')); ?>">
        <img class="cat"src="<?php echo get_template_directory_uri() . '/img/Nathalie_Mota.png'; ?>" alt="">
            
        </a>
    </div> 
    <?php
    wp_nav_menu( array(
        'theme_location' => 'header', // Emplacement du menu défini dans functions.php
        'menu_class'     => 'header', // Classe CSS du menu
    ) );
    ?>
    </nav>
</header>
