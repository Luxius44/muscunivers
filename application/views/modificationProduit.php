<html lang="en">
<?php require "headerAdmin.php"?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Muscunivers | Panneau Admin</title>
</head>
<body>
<h1>Modification produit</h1>
<p>*Remplir tous les champs</p><br>
<form action=<?=site_url("admin/modificationProduit")?> method="post" class="admin_filtre">
<span>ProdId : <?= $product->getProdId()?></span>
<span>ProdNom<input type="text" id="ProdNom" name="ProdNom" required value="<?= $product->getProdNom()?>"></span>
<span>ProdDesc<input type="text" id="ProdDesc" name="ProdDesc" required value="<?= $product->getProdDesc()?>"></span>
<span>Stock<input type="number" id="Stock" name="Stock" required value="<?= $product->getStock()?>"></span>
<span>Prix<input type="number" id="Prix" name="Prix" required value="<?= $product->getPrix()?>"></span>
<span>CatId<input type="number" id="CatId" name="CatId" required value="<?= $product->getCatId()?>"></span>
<input type="number" id="ProdId" name="ProdId" required value="<?= $product->getProdId()?>" readonly="readonly" hidden></span>
<input type="submit"  value="Modifier">
</form>
</body>
</html>