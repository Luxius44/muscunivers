<html lang="en">
<?php require "headerAdmin.php"?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Muscunivers | Panneau Admin</title>
</head>
<body>
<p>Ajout Produit dans la commande</p>
<form action=<?=site_url("admin/ajoutCommandeProduit")?> method="post"><br>
cmdId<input type="number" id="cmdId" name="cmdId" required value="<?= $cmdId ?>" readonly="readonly"><br>
prodId<input type="text" id="prodId" name="prodId" required><br>
quantite<input type="text" id="quantite" name="quantite" required><br>

<input type="submit"  value="Ajouter">
</body>
</html>