<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php
if ($users!=null){
    $mail=$users->getEmail();
}

if (isset($error)){
	$errors=$error;
}else{
	$errors=$mail;
}
?>


<?php require "headerAdmin.php"?>
<title>Muscunivers | Panneau Admin</title>
<a href="<?= site_url('admin/ajoutClient_redirect/')?>">ajout client</a>
<form action="<?=site_url("Admin/rechercheEmail")?>">
	<label >
		<div><?=$errors;?></div>
		<input type="email" name="rechercheEmail" id="rechercheEmail" required>
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
		<tr>
			<td><?= $users->getCliId()?></td>
			<td><?= $users->getEmail()?></td>
			<td><?= $users->getCliNom()?></td>
			<td><?= $users->getCliPrenom()?></td>
            <td><?= $users->getCliPassword()?></td>
            <td><?= $users->getCliDateDeNaissance()?></td>
			<td><?= $users->getCompteVerifie()?></td>
			<td><?= $users->getPanier()?></td>
			<td> <?= $users->getStatut()?></td>
			<td><a href="<?= site_url('admin/modificationClient_redirect/'.$users->getCliId())?>"> update </a></td>
			<td><a href="<?= site_url('admin/suppressionClient/'.$users->getCliId())?>"> delete </a></td>
		</tr>
	</table>

</body>
</html>	