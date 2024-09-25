<html lang="en">
<?php require "headerAdmin.php"?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Muscunivers | Panneau Admin</title>
</head>
<body>
<p>Modification Commande</p>
<form action=<?=site_url("admin/modification_Commande")?> method="post"><br>
CmdId : <?= $cmd->getCmdId()?><br>
CliId<input type="text" id="CliId" name="CliId" required value="<?= $cmd->getCliId()?>" readonly="readonly"><br>
DateCommande<input type="text" id="DateCommande" name="DateCommande" required value="<?= $cmd->getDateCommande()?>"><br>
AdresseLivraison<input type="text" id="AdresseLivraison" name="AdresseLivraison" required value="<?= $cmd->getAdresseLivraison()?>"><br>
Statut<input type="text" id="Statut" name="Statut" required value="<?= $cmd->getStatut()?>">
<input type="number" id="CmdId" name="CmdId" required value="<?= $cmd->getCmdId()?>" readonly="readonly" hidden><br>

<input type="submit"  value="Ajouter">
</body>
</html>