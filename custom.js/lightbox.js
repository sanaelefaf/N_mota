// Définition la fonction setupLightbox en haut de votre fichier JavaScript
function setupLightbox() {
    //Recuperation des éléments du DOM
    const lightboxContainer = document.querySelector(".containerLightbox");
    const lightboxImageContainer = lightboxContainer.querySelector(".lightbox-image-container");
    const lightboxReference = lightboxContainer.querySelector(".reference");
    const lightboxCategorie = lightboxContainer.querySelector(".categorie");
    const lightboxClose = lightboxContainer.querySelector(".close");
    const fullscreenIcons = document.querySelectorAll(".fa.fa-expand"); 
    const photoContainers = document.querySelectorAll(".photo"); 
    const prevButton = lightboxContainer.querySelector(".previous");
    const nextButton = lightboxContainer.querySelector(".next");
    let currentOpenPhoto = null; // variable pour suivre l'image ouverte dans la lightbox
let originalGridImage = null;//stocker une copie de l'image dans la grille d'image

    // Vérifie si les éléments existent avant d'exécuter le code
    if (
        lightboxContainer &&
        lightboxImageContainer &&
        lightboxReference &&
        lightboxCategorie &&
        lightboxClose &&
        fullscreenIcons.length > 0 &&
        photoContainers.length > 0 &&
        prevButton &&
        nextButton
    ) {
        let currentPhotoIndex = 0; // Index de la photo actuellement affichée

        //definbiton fonction 
        function openLightbox(photoContainer) {
            //Recuperation données de photocontainer : id, url, ref et categorie
            const imageId = photoContainer.getAttribute("data-photo-id");
            const imageUrl = photoContainer.getAttribute("data-photo-url");
            const reference = photoContainer.getAttribute("data-reference");
            const categorie = photoContainer.getAttribute("data-categorie");
            currentOpenPhoto = photoContainer;

            // Récupérer le contenu de la photo
            const photoContent = photoContainer.querySelector("img");

    
            //Création d'un nouvel élément imageElement de type <img> pour afficher l'image agrandie.
            const imageElement = document.createElement("img");
            //creation source image à l'aid de l'ID et URL
            imageElement.src = imageUrl + "?photoId=" + imageId;
           //info ref et catégorie mis à jour pour correspondre à la bonne photo
            lightboxImageContainer.appendChild(imageElement);
            lightboxReference.textContent = reference;
            lightboxCategorie.textContent = categorie;

// Copier l'image de la grille pour la restaurer plus tard
originalGridImage = photoContent.cloneNode(true);



            // Mise à jour le contenu de la lightbox avec le contenu de la photo
            if (photoContent) {
                const lightboxImageContainer = lightboxContainer.querySelector(".lightbox-image-container");
    
    // Cloner l'image de la grille et l'ajouter à la lightbox
    const clonedImage = photoContent.cloneNode(true);
    lightboxImageContainer.innerHTML = ''; // Effacer le contenu précédent
    lightboxImageContainer.appendChild(clonedImage);
}
            

            // Ajout  classe "open" pour afficher la lightbox
            lightboxContainer.classList.add("open");
        }


        //Navigation entre les photos

        function showPrevPhoto() {
            currentPhotoIndex--; //Decrementation de l'index de la photo actuel pour passer à laphoto precedente
           //  Si l'index devient négatif, cela signifie que nous avons atteint la première photo, donc nous réinitialisons currentPhotoIndex pour afficher la dernière photo.
            if (currentPhotoIndex < 0) { //
                currentPhotoIndex = photoContainers.length - 1;
            }
            //Maj de la photo avec le nouvel index calculé
            const prevPhotoContainer = photoContainers[currentPhotoIndex];
            openLightbox(prevPhotoContainer); //APPEL FONCTION
        }

        function showNextPhoto() {
            currentPhotoIndex++;
            if (currentPhotoIndex >= photoContainers.length) {
                currentPhotoIndex = 0;
            }
            const nextPhotoContainer = photoContainers[currentPhotoIndex];
            openLightbox(nextPhotoContainer);
        }
 

        //Boucle parcourir toutes les icones en plein ecran et gerer le clic sur celles ci
        fullscreenIcons.forEach(function (icon) {
            icon.addEventListener("click", function (event) {
                event.preventDefault();//empeche comportement par defaut du clic
               
                const photoContainer = icon.closest(".photo");
                //Trouve l'élément parent de classe "photo" le plus proche de l'icône en utilisant closest(). Cela permet de déterminer quelle photo a été cliquée pour être agrandie.
        
                //Si photoContainer existe, cela signifie qu'une photo a été trouvée, et ses attributs de référence et de catégorie sont extraits.

                if (photoContainer) {
                    const reference = photoContainer.getAttribute("data-reference"); 
                    const categorie = photoContainer.getAttribute("data-categorie"); 
                    openLightbox(photoContainer, reference, categorie);
                }
                //Appel de la fonction openLightbox pour afficher la photo agrandie en passant les données de référence et de catégorie.
               
            });
        });

        //gestionnaire clic sur precedentet suivant

        prevButton.addEventListener("click", showPrevPhoto);
        nextButton.addEventListener("click", showNextPhoto);

        //gestionnaire d'événement pour le bouton de fermeture (
        lightboxClose.addEventListener("click", function () {
            lightboxContainer.classList.remove("open");

           // Si originalGridImage existe, l'image de la grille est restaurée dans la lightbox.


            if (originalGridImage) {
                const lightboxImageContainer = lightboxContainer.querySelector(".lightbox-image-container");
                lightboxImageContainer.innerHTML = ''; 
                lightboxImageContainer.appendChild(originalGridImage);//ajoute l'image d'origine (c'est-à-dire l'image miniature) à la lightbox.
            }
            
        });
    }
}

// Appel à la fonction setupLightbox au chargement du document
document.addEventListener("DOMContentLoaded", setupLightbox);
