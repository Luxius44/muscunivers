<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php
if (isset($error)){
	$errors=$error;
}else{
	$errors="";
}
?>


<?php require "headerAdmin.php"?>
<title>Muscunivers | Panneau Admin</title>
<a href="<?= site_url('admin/ajoutClient_redirect/')?>">ajout client</a>
<form action="<?=site_url("admin/rechercheEmail")?>">
	<label >
		<div><?=$errors;?></div>
		<input type="email" name="rechercheEmail" id="rechercheEmail" required placeholder="Rentrer une adresse mail">
		<input type="submit" value="RECHERCHER">
	</label>
</form>
	<table>
		<tr>
			<th> CliId </th>
			<th> Email </th>
			<th> CliNom </th>
			<th> CliPrenom </th>
			<th> CliMotDePass </th>
			<th> CliDateDeNaissance </th>
			<th> CompteVerifie </th>
			<th> Panier </th>
			<th> Statut </th>
            <th> modification </th>
		</tr>
		<?php foreach ($users as  $user): ?>
		<tr>
			<td><?= $user->getCliId()?></td>
			<td><?= $user->getEmail()?></td>
			<td><?= $user->getCliNom()?></td>
			<td><?= $user->getCliPrenom()?></td>
            <td><?= $user->getCliPassword()?></td>
            <td><?= $user->getCliDateDeNaissance()?></td>
			<td><?= $user->getCompteVerifie()?></td>
			<td><?= $user->getPanier()?></td>
			<td> <?= $user->getStatut()?></td>
			<td><a href="<?= site_url('admin/modificationClient_redirect/'.$user->getCliId())?>"> update </a></td>
			<td><a href="<?= site_url('admin/suppressionClient/'.$user->getCliId())?>"> delete </a></td>
		</tr>
		<?php endforeach;?>
	</table>

</body>
</html>	