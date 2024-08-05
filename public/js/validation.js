// validation.js

document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const dateDebutAssuranceInput = document.getElementById('{{ form.dateDebutAssurance.vars.id }}');
    const dateFinAssuranceInput = document.getElementById('{{ form.dateFinAssurance.vars.id }}');

    form.addEventListener('submit', function(event) {
        const dateDebut = new Date(dateDebutAssuranceInput.value);
        const dateFin = new Date(dateFinAssuranceInput.value);

        if (dateFin < dateDebut) {
            event.preventDefault();
            alert('La date de fin d\'assurance ne doit pas être antérieure à la date de début d\'assurance.');
        }
    });
});
