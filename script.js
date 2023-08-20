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
  