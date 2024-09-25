<?php require "header.php"?>
<?php 
if (isset($error)){
    $erreur = $error;
}

?>


<title>Muscunivers | Profile</title>
<?php
$erreur = null;
if (isset($error)) {
    $erreur = $error;
}
?>
<div class="compte_body">
<a href="javascript:history.back(1)"><img src="<?=$cheminImage.DIRECTORY_SEPARATOR."fleche.png"?>" style="max-width:5%; max-height:5%; position:fixed; padding:1%;"></a>
    <div class="compte_positionTitre">
        <h1 class="compte_titre">Bienvenue <?= $client->getCliPrenom()?></h1>
    </div>
    <div class="compte_ligneTransition"></div>
    
<div class="compte_posInfo">
        <div class="compte_positionInfo2">
            <div class="compte_positionTitreInfo">
                <h2>Mes informations</h2>
                <form action="<?=site_url("user/modificationNomPrenom")?>" method="post">
            </div>
            <div class="login_error">
            <?=$erreur?>
            </div>
            <div class="compte_information">
                <div class="compte_positionLabel">
                    <label for="prenom">Prénom</label>
                    <p id="prenom"><input type="text" id="CliPrenom" name="CliPrenom" required value="<?= $client->getCliPrenom()?>"></p>
                </div>
                <div class="compte_positionLabel">
                    <label for="nom">Nom</label>
                    <p id="nom"><input type="text" id="CliNom" name="CliNom" required value="<?= $client->getCliNom()?>"></p>
                </div>
                <div class="compte_posButton">
                    <input type="submit" value="Appliquer" style="margin-left:112px;">
                </div>
                </form>
                <div class="compte_posButton">
                </div>
                <div class="compte_positionLabel">
                    <label for="mail">Mail</label>
                    <p id="mail"> <?= $client->getEmail()?></p>
                    <form action="<?=site_url("user/nouveauMail_redirection")?>">
                        <div class="compte_posButton">    
				            <input type="submit" value="Modifier">
                        </div>
                </div>
                </form>
                <div class="compte_positionLabel">
                    <label for="mdp">Mot de passe</label>
                    <p id="mot de passe">*****</p>
                    <form action="<?=site_url("user/nouveauMotDePasse_redirection")?>">
                        <div class="compte_posButton">     
				            <input type="submit" value="Modifier">
                        </div>    
                </div>
                </form>
            </div>
        </div>
    </div>
</div>