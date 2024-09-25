<?php require "header.php"?>

<title>Muscunivers | Nous contacter</title>


<html>
    <body class="nouscontacter">
    <form class="form" action="<?=site_url("user/nousContacter")?>" method="post">
            <div class="Form1">
                <div class="identite">
                    <div>Civilité *</div>
                    <select class="input1" required name="genre">
                        <option disabled selected></option>
                        <option value="Monsieur">Monsieur</option>
                        <option value="Madame">Madame</option>
                        <option value="Madame">Autre</option>
                    </select>
                </div>
                <div class="name">
                   <div>Prénom Nom *</div>
                    <input class="input2"type="text" id ="prenomNom" required name="prenomNom">
                </div>
            </div>
            <div>
                <div>Adresse email *</div>
                <input class="input" type="email" id="mail"required name="mail">
            </div>
            <div>
                <div>Titre du message *</div>
                <input class="input" type="text" id="titre" required name="titre">
            </div>
            <div>
               <div>Votre message *</div>            
               <textarea class="input3" type="text" id="contenu" required name="contenu"></textarea>
            </div>
            <input type="submit" value="Envoyer" class="login_bouton_connexion">
    </form>
    </body>
</html>
