<html lang="en">
<?php require "headerAdmin.php"?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Muscunivers | Panneau Admin</title>
</head>
<body>
<p>Ajout Commande</p>
<form action=<?=site_url("admin/ajoutCommande")?> method="post"><br>
CliId<input type="number" id="CliId" name="CliId" required ><br>
AdresseLivraison<input type="text" id="AdresseLivraison" name="AdresseLivraison" required><br>


<input type="submit"  value="Ajouter">
</body>
</html>