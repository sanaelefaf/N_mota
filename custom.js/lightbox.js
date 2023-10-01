// Définissez la fonction setupLightbox en haut de votre fichier JavaScript
function setupLightbox() {
    const lightboxContainer = document.querySelector(".containerLightbox");
    const lightboxImageContainer = lightboxContainer.querySelector(".lightbox-image-container");
    const lightboxReference = lightboxContainer.querySelector(".reference");
    const lightboxCategorie = lightboxContainer.querySelector(".categorie");
    const lightboxClose = lightboxContainer.querySelector(".close");
    const fullscreenIcons = document.querySelectorAll(".fa.fa-expand"); // Utilisez la classe "open-lightbox-icon"
    const photoContainers = document.querySelectorAll(".photo"); // Les conteneurs de vos photos
    const prevButton = lightboxContainer.querySelector(".previous");
    const nextButton = lightboxContainer.querySelector(".next");
    const lightboxTriggerElements = document.querySelectorAll("[data-lightbox-trigger='true']");

    // Vérifiez si les éléments existent avant d'exécuter le code
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

        function openLightbox(photoContainer) {
            const imageId = photoContainer.getAttribute("data-photo-id");
            const imageUrl = photoContainer.getAttribute("data-photo-url");
            const reference = photoContainer.getAttribute("data-reference");
            const categorie = photoContainer.getAttribute("data-categorie");

            // Récupérer le contenu de la photo
            const photoContent = photoContainer.querySelector("img");

            // Mettez à jour la source de l'image, la référence et la catégorie
            const imageElement = document.createElement("img");
            imageElement.src = imageUrl + "?photoId=" + imageId;
            lightboxImageContainer.innerHTML = ''; // Effacez le contenu précédent
            lightboxImageContainer.appendChild(imageElement);
            lightboxReference.textContent = reference;
            lightboxCategorie.textContent = categorie;

            // Mettez à jour le contenu de la lightbox avec le contenu de la photo
            if (photoContent) {
                const lightboxImageContainer = lightboxContainer.querySelector(".lightbox-image-container");
                lightboxImageContainer.innerHTML = ''; // Effacez le contenu précédent
                lightboxImageContainer.appendChild(photoContent);
            }

            // Ajoutez la classe "open" pour afficher la lightbox
            lightboxContainer.classList.add("open");
        }

        function showPrevPhoto() {
            currentPhotoIndex--;
            if (currentPhotoIndex < 0) {
                currentPhotoIndex = photoContainers.length - 1;
            }
            const prevPhotoContainer = photoContainers[currentPhotoIndex];
            openLightbox(prevPhotoContainer);
        }

        function showNextPhoto() {
            currentPhotoIndex++;
            if (currentPhotoIndex >= photoContainers.length) {
                currentPhotoIndex = 0;
            }
            const nextPhotoContainer = photoContainers[currentPhotoIndex];
            openLightbox(nextPhotoContainer);
        }

        fullscreenIcons.forEach(function (icon) {
            icon.addEventListener("click", function (event) {
                event.preventDefault();
               
                const photoContainer = icon.closest(".photo");
                if (photoContainer) {
                    const reference = photoContainer.getAttribute("data-reference"); 
                    const categorie = photoContainer.getAttribute("data-categorie"); // Récupérez la catégorie
                    openLightbox(photoContainer, reference, categorie);
                }
               
            });
        });

        prevButton.addEventListener("click", showPrevPhoto);
        nextButton.addEventListener("click", showNextPhoto);

        lightboxClose.addEventListener("click", function () {
            lightboxContainer.classList.remove("open");

            
        });
    }
}

// Appel à la fonction setupLightbox au chargement du document
document.addEventListener("DOMContentLoaded", setupLightbox);
