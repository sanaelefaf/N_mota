
</html>
<footer>
<div class="footer-line">
<hr class=line>
    <div class="footer-content">
</div>
        <?php
        wp_nav_menu( array(
            'theme_location' => 'footer', // Emplacement du menu de pied de page défini dans functions.php
            'menu_class'     => 'footer', // Classe CSS du menu
        ) );
        ?>

</footer>

<?php wp_footer(); ?>
</body>
</html>       