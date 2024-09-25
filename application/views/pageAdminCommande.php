<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php require "headerAdmin.php"?>
<title>Muscunivers | Panneau Admin</title>
<a href="<?= site_url('admin/ajoutCommande_redirect')?>">ajout commande</a>
	<table>
		<tr>
			<th> CmdId </th>
			<th> CliId </th>
			<th> DateCommande </th>
			<th> AdresseLivraison </th>
			<th> Statut</th>
		</tr>
		<?php foreach ($cmd as  $cmd): ?>
		<tr>
			<td><?= $cmd->getCmdId()?></td>
			<td><?= $cmd->getCliId()?></td>
			<td><?= $cmd->getDateCommande()?></td>
			<td><?= $cmd->getAdresseLivraison()?></td>
			<td><?= $cmd->getStatut()?></td>
			<td><a href="<?= site_url('admin/modificationCommande_redirect/'.$cmd->getCmdId())?>"> update </a></td>
			<td><a href="<?= site_url('admin/pageAdminCommandeProduit_redirect/'.$cmd->getCmdId())?>"> inspecter la commande </a></td>
			<td><a href="<?= site_url('admin/suppression_Commande/'.$cmd->getCmdId())?>"> delete </a></td>
			
		</tr>
		<?php endforeach;?>
	</table>

</body>
</html>	