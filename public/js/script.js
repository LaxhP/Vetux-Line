$("#new_edit_utilisateur").on('submit', function(){
    if($("#utilisateur_password").val() !== $("#verifpass").val()) {
        alert("Les deux mots de passe saisies sont différents");
        alert("Merci de renouveler l'opération");
        return false;
    }
})