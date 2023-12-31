<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nathalie Mota</title>
    <?php wp_head() ?>
    <script>
    var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
</script>
</head>
   
<body>

 <header class="sticky-header">
     
      <nav id="nav">  
          <!-- LOGO-->
          <div class="logo">
              <a href="<?php echo esc_url(home_url('/')); ?>">
                 <img class="cat"src="<?php echo get_template_directory_uri() . '/assets/images/Nathalie_Mota.png.webp'; ?>" alt="">
              </a>

              <!--Menu burger -->

               <button class="menu-toggle" aria-label="Toggle menu">
                  <span class="burger-bar top-bar"></span>
                  <span class="burger-bar middle-bar"></span>
                 <span class="burger-bar bottom-bar"></span>
             </button>
         </div> 

         <div class="nav">
              <!-- NAV-->
             <?php
             wp_nav_menu( array(
             'theme_location' => 'header', // Emplacement du menu défini dans functions.php
             'menu_class'     => 'header', // Classe CSS du menu
             ) );
             ?>

             <!--Modale contact-->
             <div id="contactModal" class="modal">
                 <?php get_template_part( 'template_parts/modale' ); ?>
             </div>
         </div>         
     </nav>
  </header>
