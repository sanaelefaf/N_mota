
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

<div id="photo-list" class="photo-grid">
    <!-- Vos images et contenu existants -->
</div>

<!-- Lightbox -->
<div id="lightbox-overlay" style="display: none;">
    <button class="lightbox-close">Fermer</button>
    <button class="lightbox-next">Suivant</button>
    <button class="lightbox-prev">Précédent</button>

    <div id="lightbox-content">
        <img id="lightbox-image" src="" alt="">
        <div id="lightbox-info">
            <h2 id="lightbox-title"></h2>
            <!-- Boutons de navigation (précédent/suivant) ici -->
        </div>
    </div>
</div>

</div>


</footer>

<?php wp_footer(); ?>
</body>
</html>       