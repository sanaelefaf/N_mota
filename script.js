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


jQuery(document).ready(function($) {
  var page = 1; // Numéro de page pour la pagination
  var offset = 0; // Offset pour paginer manuellement
  var loading = false; // Variable pour éviter les chargements multiples


  // Fonction pour charger les photos en fonction des filtres
  function loadPhotos() {
    if (loading) {
      return; // Ne chargez pas si une requête est déjà en cours
  }
      const categorie = $("#categorie").val();
      const format = $("#format").val();
      const sort = $("#sort").val();

      loading = true; // Marquer le chargement en cours

   //requete ajax vers ajaxurl
      $.ajax({
          url: ajaxurl,
          type: "GET",
          data: {
              action: "load_photos",
              categorie: categorie,
              format: format,
              sort: sort,
              page: page,
              offset: offset,
          },
          success: function(response) {
            const $response = $(response); // Convertit la réponse en un objet jQuery
                
                // Parcours de chaque élément .photo-item dans la réponse
                $response.find(".photo-info").each(function() {
                    const $photoInfo= $(this);
                    const photoUrl = $photoInfo.data("photo-url"); // Récupère la valeur de l'attribut data-photo-url
                    const photoPermalink = $photoInfo.data("photo-permalink"); // Obtenez le lien permanent de la photo
                    $photoItem.attr("data-photo-permalink", photoPermalink);

                    const $photoLink = $("<a>").attr("href", photoPermalink);

                    // Créez un élément de photo et placez-le à l'intérieur de la balise <a>
                    const $photoItem = $("<div>").addClass("photo");
                    $photoLink.append($photoItem);
                    
                    // Faites quelque chose avec l'URL de la photo, par exemple, l'afficher dans la console
                    console.log("URL de la photo : " + photoUrl);
                });

              $("#photo-list").append(response);
              page++; // Augmenter le numéro de page pour la prochaine requête
              offset += 12; 
              loading = false;
          },
          error: function(xhr, textStatus, errorThrown) {
              console.log("Erreur lors du chargement des photos : " + errorThrown);
              loading = false;
          }
      });
  }

  // Gestionnaire d'événement pour le changement des filtres
  $("#category, #format, #sort").change(function() {
      page = 1; // Réinitialiser le numéro de page lorsque les filtres changent
      offset = 0; // Réinitialiser l'offset
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


