<!DOCTYPE html>
<?php require "header.php"?>

<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$erreur = null;
$alert="hidden";
$disabled = "";


if (isset($_COOKIE["cooldown"])){
    $disabled = "disabled";
    $erreur = "Attendez 5 minutes avant de renvoyer un mail";
}
if (isset($error)) {
    $erreur = $error; // Erreur
}
if (isset($alerte)){ // Pop up validation email
    $alert="";
}


?>
    <title>Muscunivers | Confirmation</title>
    <div id="alert" class="alert-box callout success" <?=$alert?>>
        Email envoyé avec succès !
    </div>

    <body class="login_confirmation">
        <form class="login_form" action="<?=site_url("user/verif_mail")?>" method="post">
            <h1 class="login_h1"><u class="login_u">Entrée la clé reçu par mail</u></h1>
            <div class="login_error">
            <?=$erreur?>
            </div>
            <div class="login_centrage">
                <label class="login_label">Clé 
                <input class="login_label_input" type="text" required name="cle" id="cle" 
                onfocusin="document.getElementById('login').style.backgroundColor='grey';
                document.getElementById('login').style.color='white';"

                onfocusout="document.getElementById('login').style.backgroundColor='white';
                document.getElementById('login').style.color='black';"></label></div>
            <div class="login_centrage">
                <input class="login_bouton_connexion" type="submit"  value="CONFIRMATION"></div>
                <a class = "<?=$disabled?> lienBlanc" style="margin-left:35%;" href="<?=site_url("user/renvoie_mail")?>">Renvoyer email confirmation</a>
            <div class="login_compte">
            </div>
        </form>
</body>