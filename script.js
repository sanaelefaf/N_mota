// MODAL
document.addEventListener("DOMContentLoaded", function () {
    const navMenu = document.querySelector("#menu-header");
    
    if (navMenu) {
      const contactLink = document.createElement("li");
      contactLink.className = "menu-item";
      contactLink.innerHTML = '<a href="#" class="open_modal">Contact</a>';
      
      navMenu.appendChild(contactLink);
    }
    

    const modal = document.getElementById("contactModal");
    const modalTrigger = document.querySelector(".open_modal");
    const modalClose = document.getElementById("modalClose");
   
  
    function toggleModal() {
      if (modal.style.display === "block") {
        modal.style.display = "none";
      } else {
        modal.style.display = "block";
      }
    }

// Ajoutez un événement au clic sur le bouton "Contact" avec l'id "openContactModal"
const contactButton = document.getElementById("openContactModal");
if (contactButton) {
    contactButton.addEventListener("click", function (event) {
        event.preventDefault();
        toggleModal();
    });
}

  
    modalTrigger.addEventListener("click", function (event) {
      event.preventDefault();
      toggleModal();
    });
  
    modalClose.addEventListener("click", function () {
      toggleModal();
    });
  });

  //PHOTO
  jQuery(document).ready(function($) {
    // Fonction pour récupérer la valeur d'un cookie par son nom
    function getCookie(cookieName) {
        var name = cookieName + "=";
        var decodedCookie = decodeURIComponent(document.cookie);
        var cookieArray = decodedCookie.split(';');
        for (var i = 0; i < cookieArray.length; i++) {
            var cookie = cookieArray[i];
            while (cookie.charAt(0) === ' ') {
                cookie = cookie.substring(1);
            }
            if (cookie.indexOf(name) === 0) {
                return cookie.substring(name.length, cookie.length);
            }
        }
        return "";
    }

    var page = 1; // Numéro de page pour la pagination
    var loading = false; // Variable pour éviter les chargements multiples

    // Fonction pour charger les photos en fonction des filtres
    function loadPhotos() {
        if (loading) {
            return; // Ne chargez pas si une requête est déjà en cours
        }

        const categorie = $("#categorie").val();
        const format = $("#format").val();
        const sort = $("#sort").val();
        var alreadyDisplayedPosts = getCookie('already_displayed_posts').split(',');

        loading = true; // Marquer le chargement en cours

        // Requête AJAX vers le serveur
        $.ajax({
            url: ajaxurl,
            type: "GET",
            data: {
                action: "filter_photos",
                categorie: categorie,
                format: format,
                sort: sort,
                page: page,
                already_displayed_posts: alreadyDisplayedPosts
            },
            success: function(response) {
                $("#photo-list").append(response); 
                page++; // Augmenter le numéro de page pour la prochaine requête
                loading = false; // Marquer le chargement comme terminé

                // Mettez à jour les cookies pour suivre les articles déjà affichés
                alreadyDisplayedPosts = alreadyDisplayedPosts.concat(response.split(','));
                document.cookie = 'already_displayed_posts=' + alreadyDisplayedPosts.join(',');

                // Vérifier si toutes les images sont chargées
                if (totalImages > 0 && $("#photo-list .photo").length >= totalImages) {
                  $("#load-more").hide(); // Cacher le bouton "Afficher plus"
              }
            },
            error: function(xhr, textStatus, errorThrown) {
                console.log("Erreur lors du chargement des photos : " + errorThrown);
                loading = false; 
            }
        });
    }

    // Fonction pour filtrer les photos en fonction des critères de filtre
    function filterPhotos() {
        page = 1; // Réinitialiser le numéro de page lorsque les filtres changent
        $("#photo-list").empty(); // Vider la liste actuelle
        loadPhotos(); // Charger les photos avec les nouveaux filtres
// Charger les photos avec les nouveaux filtres
    }

    // Gestionnaire d'événement pour le changement des filtres
    $("#categorie, #format, #sort").change(function() {
        filterPhotos();
    });

    // Gestionnaire d'événement pour le bouton "Afficher plus"
    $("#load-more").click(function(e) {
        e.preventDefault();
        // Appel AJAX pour load_photos
        $.ajax({
          url: ajaxurl,
          type: "GET",
          data: {
              action: "load_photos",
              categorie: $("#categorie").val(),
              format: $("#format").val(),
              sort: $("#sort").val(),
              page: page
          },
          success: function(response) {
              $("#photo-list").append(response);
              page++;

              // Vérifier si toutes les images sont chargées
              if (totalImages > 0 && $("#photo-list .photo").length >= totalImages) {
                $("#load-more").hide(); // Cacher le bouton "Afficher plus"
            }
          },
          error: function(xhr, textStatus, errorThrown) {
              console.log("Erreur lors du chargement des photos : " + errorThrown);
          }
        });  
    });
    // Fonction pour initialiser le nombre total d'images disponibles
    function initTotalImages() {
      totalImages = $("#photo-list .photo").length;
  }

  // Appel initial pour initialiser le nombre total d'images
  initTotalImages();
});


//menu burger//

document.addEventListener('DOMContentLoaded', function() {
  const menuToggle = document.querySelector('.menu-toggle');
  const menu = document.getElementById("menu-header");

  menuToggle.addEventListener('click', function() {
    this.classList.toggle("active");
    menu.classList.toggle("show");
   
  });
});