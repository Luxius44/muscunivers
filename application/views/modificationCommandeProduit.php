<html lang="en">
<?php require "headerAdmin.php"?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Muscunivers | Panneau Admin</title>
</head>
<body>
<p>modification Produit dans la commande</p>
<form action=<?=site_url("admin/modification_CommandeProduit")?> method="post">
cmdId : <?= $cmdId?><br>
prodId : <?= $prodId?><br>
quantite<input type="text" id="quantite" name="quantite" required value="<?= $quantite ?>"><br>
<input type="number" id="cmdId" name="cmdId" required value="<?= $cmdId ?>" readonly="readonly" hidden>
<input type="text" id="prodId" name="prodId" required value="<?= $prodId ?>" readonly="readonly" hidden>
<input type="submit"  value="Modifier">
</body>
</html>