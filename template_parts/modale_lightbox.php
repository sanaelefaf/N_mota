<div class="containerLightbox">
    <div class="lightbox-content">
        <div class="lightbox-image-container">
            <img class="lightbox-image" src="<?php echo get_the_content(); ?>" alt="Image de la lightbox">
        </div>
        <div class="lightbox-details">
            <span class="reference"></span>
            <span class="categorie"></span>
        </div>
    </div>
    <div class="close">
        <!-- Bouton pour fermer la lightbox -->
        <svg xmlns="http://www.w3.org/2000/svg" width="23" height="24" viewBox="0 0 23 24" fill="none"><!-- afficher une image vectorielle -->
            <!-- Icône de fermeture (à ajouter) -->
           
            <line x1="1" y1="1" x2="22" y2="22" stroke="#fff" stroke-width="2" />
    <line x1="1" y1="22" x2="22" y2="1" stroke="#fff" stroke-width="2" />
</svg>
            
        </svg>
    </div>
    <div class="previous">
        <!-- Bouton pour afficher l'image précédente -->
        <svg xmlns="http://www.w3.org/2000/svg" width="27" height="16" viewBox="0 0 27 16" fill="none">
            <!-- Icône de flèche précédente (flèche blanche) -->
            <path d="M26 7H5M12 14l-7-7 7-7" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        <span>Précédente</span>
    </div>
    <div class="next">
        <span>Suivante</span>
        <!-- Bouton pour afficher l'image suivante -->
        <svg xmlns="http://www.w3.org/2000/svg" width="27" height="16" viewBox="0 0 27 16" fill="none">
            <!-- Icône de flèche suivante (flèche blanche) -->
            <path d="M1 7h21M14 14l7-7-7-7" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </div>
</div>

