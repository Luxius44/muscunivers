<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php require "headerAdmin.php"?>
<title>Muscunivers | Panneau Admin</title>
<a href="<?= site_url('admin/ajoutCommandeProduit_redirect/'.$cmd)?>">ajout d'un produit dans la commande</a>
	<table>
		<tr>
			<th> CmdId </th>
			<th> ProdId </th>
			<th> Quantite </th>
		</tr>
		<?php foreach ($prod as $prod): ?>
		<tr>
			<td><?= $prod->getCmdId()?></td>
			<td><?= $prod->getProdId()?></td>
			<td><?= $prod->getQuantite()?></td>
			<td><a href="<?= site_url('admin/modification_CommandeProduit_redirect/'.$prod->getProdId())?>"> update </a></td>
			<td><a href="<?= site_url('admin/suppression_CommandeProduit/'.$prod->getProdId())?>"> delete </a></td>
			
		</tr>
		<?php endforeach;?>
	</table>

</body>
</html>	