// MODAL CONTACT

document.addEventListener("DOMContentLoaded", function () {
    const navMenu = document.querySelector("#menu-header");//sélectionne un élément HTML avec l'ID #menu-header et le stocke dans la variable navMenu
    if (navMenu) { //vérifie si l'élément navMenu existe. Si l'élément avec l'ID #menu-header existe sur la page, le code à l'intérieur de cette condition sera exécuté.
      const contactLink = document.createElement("li");//nouvelle balise HTML <li> (élément de liste) est créée et stockée dans la variable contactLink.
      contactLink.className = "menu-item";//attribue la classe CSS "menu-item" à l'élément <li>
      contactLink.innerHTML = '<a href="#" class="open_modal">Contact</a>'; //Cela définit le contenu HTML de l'élément <li>
      
      navMenu.appendChild(contactLink);//ajoute l'élément contactLink (qui contient le lien "Contact") à la fin du menu de navigation représenté par l'élément navMenu.
    }
    
// selectionner les elements du DOM 
    const modal = document.getElementById("contactModal");
    const modalTrigger = document.querySelector(".open_modal");
    const modalClose = document.getElementById("modalClose");
   
  //fonction sera utilisée pour afficher ou masquer la fenêtre modale en fonction de son état actuel.
    function toggleModal() {
      if (modal.style.display === "block") // si l'élément modal est définie sur "block". Si c'est le cas, cela signifie que la fenêtre modale est actuellement affichée.
      {
        modal.style.display = "none"; //Si la fenêtre modale est actuellement affichée, cette ligne la masque en définissant la propriété display sur "none".
      } else {
        modal.style.display = "block"; // Si la fenêtre modale n'est pas affichée, cette ligne l'affiche en définissant la propriété display sur "block".
      }
    }

// Ajoute un événement au clic sur le bouton "Contact" avec l'id "openContactModal"
const contactButton = document.getElementById("openContactModal");
if (contactButton) {
    contactButton.addEventListener("click", function (event) { // gestionnaire evenement au click
        event.preventDefault();
        toggleModal(); // appelle la fonction toggleModal() pour afficher ou masquer la fenêtre modale lorsque le bouton "Contact" est cliqué.
    });
}

// ajoutent des écouteurs d'événements "click" pour afficher ou masquer la fenêtre modale lorsque les éléments correspondants sont cliqués.
  
    modalTrigger.addEventListener("click", function (event) {
      event.preventDefault();
      toggleModal();
    });
  
    modalClose.addEventListener("click", function () {
      toggleModal();
    });
  });







  ////////////////////////////////////////////////////////PHOTO///////////////////////////////////////

  //CHARGEMENT PHOTOS ET FILTRES

  jQuery(document).ready(function($) {
    
    
// gestion du chargement des photos en fonction des filtres sélectionnés par l'utilisateur

    var page = 1; // Numéro de page pour la pagination
    var loading = false; // Variable pour éviter les chargements multiples

    // Fonction pour charger les photos en fonction des filtres
    function loadPhotos() {
        if (loading) {
            return; // Ne chargez pas si une requête est déjà en cours
        }

        //récupèrent les valeurs des filtres sélectionnés par l'utilisateur depuis les éléments HTML avec les IDs #categorie, #format, et #sort
        const categorie = $("#categorie").val();
        const format = $("#format").val();
        const sort = $("#sort").val();
       

        loading = true; // Marquer le chargement en cours

        // Requête AJAX vers le serveur
        //e envoie des données telles que la catégorie sélectionnée, le format, le tri, le numéro de page, et les articles déjà affichés au serveur.
        $.ajax({
            url: ajaxurl,
            type: "GET",//requête HTTP sera de type GET. Cela signifie que vous demandez au serveur de vous fournir des données, sans apporter de modifications côté serveur.
            data://données qui seront incluses dans la requête GET. 
             {
                action: "filter_photos",
                categorie: categorie,
                format: format,
                sort: sort,
                page: page,
                
            },
            //fonction à exécuter lorsque la requête AJAX réussit
            success: function(response) {
                $("#photo-list").append(response); //contenu HTML
                page++; // Augmenter le numéro de page pour la prochaine requête, incrementation
                loading = false; // Marquer le chargement comme terminé

  

                // Vérifier si toutes les images sont chargées
                if (totalImages > 0 && $("#photo-list .photo").length >= totalImages) {//Cela vérifie si le nombre total d'images (totalImages) est supérieur à zéro, ce qui signifie qu'il y a des images à charger.
                 
              }
            },
            error: function(xhr, textStatus, errorThrown) {
                console.log("Erreur lors du chargement des photos : " + errorThrown);
                loading = false; 
            }
        });
    }

  // Afficher plus

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


///////////////////////////////////////// menu burger ///////////////////////

document.addEventListener('DOMContentLoaded', function() {
  const menuToggle = document.querySelector('.menu-toggle');
  const menu = document.getElementById("menu-header");

  menuToggle.addEventListener('click', function() {
    this.classList.toggle("active");
    menu.classList.toggle("show");
   
  });
});