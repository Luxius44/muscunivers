<html lang="en">
<?php require "headerAdmin.php"?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Muscunivers | Panneau Admin</title>
</head>
<body>
<h1>Ajout produit</h1>
<p>*Remplir tous les champs</p>
<form action=<?=site_url("admin/ajoutProduit")?> method="post">
ProdId<input type="number" id="ProdId" name="ProdId" required >
ProdNom<input type="text" id="ProdNom" name="ProdNom" required>
ProdDesc<input type="text" id="ProdDesc" name="ProdDesc" required>
Stock<input type="number" id="Stock" name="Stock" required>
Prix<input type="number" id="Prix" name="Prix" required>
CatId<input type="number" id="CatId" name="CatId" required>
<input type="submit"  value="Ajouter">
</body>
</html>