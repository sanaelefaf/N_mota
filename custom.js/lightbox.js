jQuery(document).ready(function($) {
    // Fonction pour ouvrir la lightbox avec les données
    function openLightbox(photoIndex) {
        const photo = photos[photoIndex];
        $('#lightbox-image').attr('src', photo.url);
        $('#lightbox-title').text(photo.name);
        $('#lightbox-overlay').show();
        currentPhotoIndex = photoIndex;
    }

    // Fonction pour fermer la lightbox
    function closeLightbox() {
        $('#lightbox-overlay').hide();
    }

    // Tableau pour stocker les informations sur les photos
    var photos = [];

    // Index de la photo actuellement affichée
    var currentPhotoIndex = 0;

    // Écoutez le clic sur les images générées via AJAX
    $(document).on('click', '.photo-image.lightbox-trigger', function() {
        const photoId = $(this).data('photo-id');
        const photoIndex = photos.findIndex(photo => photo.id === photoId);
        if (photoIndex !== -1) {
            openLightbox(photoIndex);
        }
    });

    // Écoutez le clic sur le bouton de fermeture
    $('#lightbox-close').on('click', function() {
        closeLightbox();
    });

    // Écoutez le clic sur le bouton précédent
    $('#lightbox-previous').on('click', function() {
        if (currentPhotoIndex > 0) {
            openLightbox(currentPhotoIndex - 1);
        }
    });

    // Écoutez le clic sur le bouton suivant
    $('#lightbox-next').on('click', function() {
        if (currentPhotoIndex < photos.length - 1) {
            openLightbox(currentPhotoIndex + 1);
        }
    });

    
    // Appel AJAX pour récupérer les données des photos
    $.ajax({
        url: ajaxurl,
        type: "GET",
        data: {
            action: "get_photos_data"
        },
        success: function(response) {
            // Ajoutez les photos à votre tableau à partir des données JSON
            response.forEach(function(photoData) {
                photos.push(photoData);
            });
        },
        error: function(xhr, textStatus, errorThrown) {
            console.log("Erreur lors du chargement des données des photos : " + errorThrown);
        }
    });
});
