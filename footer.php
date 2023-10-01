
</html>
<footer>
<div class="footer-line">
<hr class=line>
    <div class="footer-content">

    <?php get_template_part( 'template_parts/modale_lightbox' ); ?>
</div>


        <?php
        wp_nav_menu( array(
            'theme_location' => 'footer', // Emplacement du menu de pied de page défini dans functions.php
            'menu_class'     => 'footer', // Classe CSS du menu
        ) );
        ?>





</footer>

<?php wp_footer(); ?>

<SCRipt>

    
</SCRipt>
</body>
</html>       