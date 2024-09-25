<?php require "header.php"?>
<?php
$erreur = null;
if (isset($error)) {
    $erreur = $error;
}
?>
<title>Muscunivers | Profile</title>

<div class="compte_body">
<a href="javascript:history.back(1)"><img src="<?=$cheminImage.DIRECTORY_SEPARATOR."fleche.png"?>" style="max-width:5%; max-height:5%; position:fixed; padding:1%;"></a>
    <div class="compte_positionTitre">
        <h1 class="compte_titre">Modification mail</h1>
    </div>
    <div class="compte_ligneTransition"></div>

<div class="compte_posInfo">
    <div class="compte_positionInfo2">
        <div class="compte_positionTitreInfo">
            <h2>Mes informations</h2>
            <form action="<?=site_url('user/nouveau_mail')?>" method="post">
        </div>
        <div class="login_error">
            <?=$erreur?>
        </div>
        <div class="compte_information">
            <div class="compte_positionLabel">
                <label for="prenom">Nouvelle adresse e-mail :</label>
                <input  class="login_label_input" type="email" id="email" name="email" required>
            </div>
            <div class="compte_posButton">
            <input type="submit" value="Valider">
            </div>
        </div>
    </div>
</div>
