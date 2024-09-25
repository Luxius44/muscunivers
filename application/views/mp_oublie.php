<!DOCTYPE html>
<?php require "header.php"?>

<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$erreur = null;
if (isset($error)) {
    $erreur = $error;
}
?>

<title>Muscunivers | Login</title>
    <body class="login_body">
        <form class="login_form" action="<?=site_url("user/mail_mp")?>" method="post">
            <h1 class="login_h1"><u class="login_u">Renseignez votre e-mail</u></h1>
            <div class="login_error">
            </div>
            <div class="login_error">
            <?=$erreur?>
            </div>
            <div class="login_centrage">
                <label class="login_label">E-MAIL 
                <input class="login_label_input" type="email" required name="login" id="login" 
                onfocusin="document.getElementById('login').style.backgroundColor='grey';
                document.getElementById('login').style.color='white';"

                onfocusout="document.getElementById('login').style.backgroundColor='white';
                document.getElementById('login').style.color='black';"></label></div>

            <div class="login_centrage"><input class="login_bouton_connexion" type="submit"  value="Valider"></div>
            <div class="login_compte">
            </div>
        </form>
</body>
