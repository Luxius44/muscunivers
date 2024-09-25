<html lang="en">
<?php require "headerAdmin.php"?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Muscunivers | Panneau Admin</title>
</head>
<body>
<p>Modification Client</p>
<form action=<?=site_url("admin/modification_Client")?> method="post">
CliId : <?= $client->getCliId()?><br>
Email<input type="email" id="Email" name="Email" required value="<?= $client->getEmail()?>"><br>
CliNom<input type="text" id="CliNom" name="CliNom" required value="<?= $client->getCliNom()?>"><br>
CliPrenom<input type="text" id="CliPrenom" name="CliPrenom" required value="<?= $client->getCliPrenom()?>"><br>
CliMotDePass<input type="text" id="CliMotDePass" name="CliMotDePass" required value="<?= $client->getCliPassword()?>"><br>
CliDateDeNaissance<input type="text" id="CliDateDeNaissance" name="CliDateDeNaissance" required value="<?= $client->getCliDateDeNaissance()?>"><br>
CompteVerifie<input type="number" id="CompteVerifie" name="CompteVerifie" required value="<?= $client->getCompteVerifie()?>"><br>
Panier<input type="text" id="Panier" name="Panier" value="<?= $client->getPanier()?>"><br>
Statut<input type="text" id="Statut" name="Statut" value="<?= $client->getStatut()?>"><br>
<input type="number" id="CliId" name="CliId" required value="<?= $client->getCliId()?>" readonly="readonly" hidden>
<input type="submit"  value="Modifier">
</body>
</html>