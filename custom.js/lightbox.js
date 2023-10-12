function setupLightbox() {
    // Récupération des éléments du DOM
    const lightboxContainer = document.querySelector(".containerLightbox");
    const lightboxImageContainer = lightboxContainer.querySelector(".lightbox-image-container");
    const lightboxReference = lightboxContainer.querySelector(".reference");
    const lightboxCategorie = lightboxContainer.querySelector(".categorie");
    const lightboxClose = lightboxContainer.querySelector(".close");
    const fullscreenIcons = document.querySelectorAll(".fa.fa-expand");
    const photoContainers = document.querySelectorAll(".photo");
    const prevButton = lightboxContainer.querySelector(".previous");
    const nextButton = lightboxContainer.querySelector(".next");
    let currentOpenPhoto = null;
    let originalGridImage = null;

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
        let currentPhotoIndex = 0;

        // Fonction pour afficher une photo dans la lightbox
        function openLightbox(photoContainer) {
            const imageId = photoContainer.getAttribute("data-photo-id");
            const imageUrl = photoContainer.getAttribute("data-photo-url");
            const reference = photoContainer.getAttribute("data-reference");
            const categorie = photoContainer.getAttribute("data-categorie");
            currentOpenPhoto = photoContainer;
            const photoContent = photoContainer.querySelector("img");
            const imageElement = document.createElement("img");
            imageElement.src = imageUrl + "?photoId=" + imageId;
            lightboxImageContainer.appendChild(imageElement);
            lightboxReference.textContent = reference;
            lightboxCategorie.textContent = categorie;
            originalGridImage = photoContent.cloneNode(true);

            if (photoContent) {
                const lightboxImageContainer = lightboxContainer.querySelector(".lightbox-image-container");
                const clonedImage = photoContent.cloneNode(true);
                lightboxImageContainer.innerHTML = '';
                lightboxImageContainer.appendChild(clonedImage);
            }

            lightboxContainer.classList.add("open");
        }

        // Fonction pour afficher la photo précédente
        function showPrevPhoto() {
            currentPhotoIndex--;
            if (currentPhotoIndex < 0) {
                currentPhotoIndex = photoContainers.length - 1;
            }
            const prevPhotoContainer = photoContainers[currentPhotoIndex];
            openLightbox(prevPhotoContainer);
        }

        // Fonction pour afficher la photo suivante
        function showNextPhoto() {
            currentPhotoIndex++;
            if (currentPhotoIndex >= photoContainers.length) {
                currentPhotoIndex = 0;
            }
            const nextPhotoContainer = photoContainers[currentPhotoIndex];
            openLightbox(nextPhotoContainer);
        }

        // Gestion du clic sur les icônes en plein écran
        fullscreenIcons.forEach(function (icon) {
            icon.addEventListener("click", function (event) {
                event.preventDefault();
                const photoContainer = icon.closest(".photo");

                if (photoContainer) {
                    const reference = photoContainer.getAttribute("data-reference");
                    const categorie = photoContainer.getAttribute("data-categorie");
                    openLightbox(photoContainer, reference, categorie);
                }
            });
        });

        // Gestion du clic sur les boutons "Précédent" et "Suivant"
        prevButton.addEventListener("click", showPrevPhoto);
        nextButton.addEventListener("click", showNextPhoto);

        // Gestion du clic sur le bouton de fermeture de la lightbox
        lightboxClose.addEventListener("click", function () {
            lightboxContainer.classList.remove("open");

            if (originalGridImage) {
                const lightboxImageContainer = lightboxContainer.querySelector(".lightbox-image-container");
                lightboxImageContainer.innerHTML = '';
                lightboxImageContainer.appendChild(originalGridImage);
            }
        });
    }
}

// Appel à la fonction setupLightbox au chargement du document
document.addEventListener("DOMContentLoaded", setupLightbox);
