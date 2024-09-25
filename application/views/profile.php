<?php require "header.php"?>

<title>Muscunivers | Profile</title>



<div class="compte_body">

    <div class="compte_positionTitre">
        <h1 class="compte_titre">Bienvenue <?= $user->getCliPrenom()?></h1> 
        <div style="margin-left:40%;">

            <?php if ($user->getStatut()=="Admin") {?>
                <a href="<?=site_url("Admin/accueilAdmin_redirect")?>"><button class="compte_bouton">Page Admin</button></a>
            <?php }?>
            
            <?php if ($user->getCompteVerifie()==0){?>
                <a href="<?=site_url("user/verification")?>"><button class="compte_bouton">Vérifier votre adresse e-mail</button></a>
            <?php }; ?>
            
            <a href="<?=site_url("user/logout")?>"><button class="compte_bouton">Déconnexion</button></a>
        </div>
    </div>
    <div class="compte_ligneTransition"></div>
    
<div class="compte_posInfo">
        <div class="compte_positionInfo2">
            <div class="compte_positionTitreInfo">
                <h2>Mes informations</h2>
            </div>
            <div class="compte_information">
                <div class="compte_positionLabel">
                    <label for="prenom">Prénom</label>
                    <p id="prenom"><?= $user->getCliPrenom()?></p>
                </div>
                <div class="compte_positionLabel">
                    <label for="nom">Nom</label>
                    <p id="prenom"><?= $user->getCliNom()?></p>
                </div>
                <div class="compte_positionLabel">
                    <label for="mail">Mail</label>
                    <p id="mail"> <?= $user->getEmail()?></p>
                </div>
                <div class="compte_positionLabel">
                    <label for="mdp">Mot de passe</label>
                    <p id="mdp">*****</p>
                </div>
            </div>
            <div class="compte_posButton">
            <form action="<?=site_url("user/modificationProfil_redirection")?>">    
				<input type="submit" value="MODIFIER">
            </div>
        </div>
    </div>
</div>
