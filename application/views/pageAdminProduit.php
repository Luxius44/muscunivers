<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php require "headerAdmin.php"?>
<div class="admin_filtre">
<a href="<?= site_url('admin/ajoutProduit_redirect/')?>">ajout Produit</a>
<label>Accès aux catégories :</label>
<a href="<?= site_url("admin/categorie/5")?>">Kits</a>
<a href="<?= site_url("admin/categorie/6")?>">Poids</a>
<a href="<?= site_url("admin/categorie/3")?>">Bancs</a>
<a href="<?= site_url("admin/categorie/2")?>">Stations</a>
<a href="<?= site_url("admin/categorie/7")?>">Accessoires</a>
<a href="<?= site_url("admin/categorie/4")?>">Lestes</a>
<a href="<?= site_url("admin/categorie/8")?>">Machines</a>
<a href="<?= site_url("admin/categorie/1")?>">Complements</a>
</div>
<title>Muscunivers | Panneau Admin</title>

	<table>
		<tr>
			<th> ProdId </th>
			<th> ProdNom </th>
			<th> ProdDesc </th>
			<th> Stock </th>
			<th> Prix </th>
			<th> CatId </th>
            <th> modification </th>
            <th> supression </th>
		</tr>
		<?php foreach ($prods as  $prod): ?>
		<tr>
			<td><?= $prod->getProdId()?></td>
			<td><?= $prod->getProdNom()?></td>
			<td><?= $prod->getProdDesc()?></td>
			<td><?= $prod->getStock()?></td>
            <td><?= $prod->getPrix()?></td>
            <td><?= $prod->getCatId()?></td>
			<td><a href="<?= site_url('admin/modificationProduit_redirect/'.$prod->getProdId())?>"> update </a></td>
			<td><a href="<?= site_url('admin/suppressionProduit/'.$prod->getProdId())?>"> delete </a></td>
		</tr>	
		<?php endforeach;?>
	</table>

</body>
</html>	
