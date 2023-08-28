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
  
    modalTrigger.addEventListener("click", function (event) {
      event.preventDefault();
      toggleModal();
    });
  
    modalClose.addEventListener("click", function () {
      toggleModal();
    });
  });
  
  //PHOTOS


// Votre code JavaScript continue ici
jQuery(document).ready(function($) {
  var page = 1; // Numéro de page pour la pagination

  // Fonction pour charger les photos en fonction des filtres
  function loadPhotos() {
      const category = $("#category").val();
      const format = $("#format").val();
      const sort = $("#sort").val();

      $.ajax({
          url: ajaxurl,
          type: "GET",
          data: {
              action: "load_photos",
              category: category,
              format: format,
              sort: sort,
              page: page,
          },
          success: function(response) {
              $("#photo-list").append(response);
              page++; // Augmenter le numéro de page pour la prochaine requête
          },
          error: function(xhr, textStatus, errorThrown) {
              console.log("Erreur lors du chargement des photos : " + errorThrown);
          }
      });
  }

  // Gestionnaire d'événement pour le changement des filtres
  $("#category, #format, #sort").change(function() {
      page = 1; // Réinitialiser le numéro de page lorsque les filtres changent
      $("#photo-list").empty(); // Vider la liste actuelle
      loadPhotos();
  });

  // Gestionnaire d'événement pour le bouton "Voir plus"
  $("#load-more").click(function(e) {
      e.preventDefault();
      loadPhotos();
  });

  // Appel initial pour charger les photos
  loadPhotos();
});
