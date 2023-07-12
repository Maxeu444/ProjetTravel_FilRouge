function editInfo() {
  // Récupérer les éléments HTML à modifier
  let editBtn = document.getElementById("editBtn");
  let deleteBtn = document.getElementById("deleteBtn");
  let saveBtn = document.getElementById("saveBtn");

  let lastnameH3 = document.getElementById("lastnameH3");
  let firstnameH3 = document.getElementById("firstnameH3");
  let emailH3 = document.getElementById("emailH3");

  let lastnameDiv = document.getElementById("lastnameDiv");
  let firstnameDiv = document.getElementById("firstnameDiv");
  let emailDiv = document.getElementById("emailDiv");

  // Afficher les champs de saisie
  lastnameDiv.style.display = "block";
  firstnameDiv.style.display = "block";
  emailDiv.style.display = "block";

  // Masquer les H3
  lastnameH3.style.display = "none";
  firstnameH3.style.display = "none";
  emailH3.style.display = "none";

  // Afficher le bouton "Enregistrer"
  saveBtn.style.display = "block";

  // Masquer le bouton "Modifier" et le bouton "Supprimer"
  editBtn.style.display = "none";
  deleteBtn.style.display = "none";
}

document.addEventListener('DOMContentLoaded', function () {
  const form = document.querySelector('.account-update-form');
  if (form) {
    form.addEventListener('submit', function (event) {
      event.preventDefault(); // Empêcher la soumission par défaut du formulaire
      form.submit(); // Soumettre le formulaire manuellement
    });
  } else {
    console.error("Le formulaire avec la classe 'account-update-form' n'a pas été trouvé.");
  }
});

function deleteAccount() {
  document.location.href = `http://localhost:8000/account/delete`;
}

// Sélectionnez tous les boutons
const buttons = document.querySelectorAll('.section');

// Ajoutez un écouteur d'événement à chaque bouton
buttons.forEach(button => {
    button.addEventListener('click', function(event) {
        // Empêche le comportement par défaut (la navigation)
        event.preventDefault();

        // Récupère l'URL à partir de l'attribut data-path
        const url = button.dataset.path;


        // Faites une requête AJAX vers l'URL
        fetch(url)
            .then(response => response.text())
            .then(data => {
                // Injectez le contenu de la réponse dans le conteneur
                document.getElementById('contentContainer').innerHTML = data;
            });
    });
});
