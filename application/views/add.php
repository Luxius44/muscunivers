<?php require "header.php"?>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$erreur = null;
if (isset($error)) {
    $erreur = $error;
}
?>
    <title>Muscunivers | S'enregistrer</title>
    <body class="login_body">
    <form class="login_form" action=<?=site_url("user/addUser")?> method="post">
        <h1 class="login_h1"><u class="login_u">INSCRIPTION</u></h1>
        <div class="login_error">
        <?=$erreur?>
        </div>
        <div class="login_centrage">
            <label class="login_label">Nom
                <input  class="login_label_input" type="text" id="nom" name="nom" required>
            </label>
        </div>
        <div class="login_centrage">
            <label class="login_label">Prénom
                <input  class="login_label_input" type="text" id="prenom" name="prenom" required>
            </label>
        </div>
        <div class="login_centrage">
                <label class="login_label">Date de Naissance
                    <input  class="login_label_input" type="date" id="date" name="date" required>
                </label>
        </div>
        <div class="login_centrage">
            <label class="login_label">E-Mail
                <input  class="login_label_input" type="email" id="email" name="email" required>
            </label>
        </div>
        <div class="login_centrage">
            <label class="login_label">Password
                <input  class="login_label_input" type="password" id="password" name="password" required>
            </label>
        </div>
        <div class="login_centrage">
            <input class="login_bouton_connexion" type="submit"  value="S'ENREGISTRER">
        </div>
    </form>
</body>