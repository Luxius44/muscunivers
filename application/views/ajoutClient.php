<html lang="en">
<?php require "headerAdmin.php"?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Muscunivers | Panneau Admin</title>
</head>
<body>
<p>Ajout Client</p>
<form action=<?=site_url("admin/ajoutClient")?> method="post"><br>
CliId<input type="number" id="CliId" name="CliId" required ><br>
Email<input type="text" id="Email" name="Email" required><br>
CliNom<input type="text" id="CliNom" name="CliNom" required><br>
CliPrenom<input type="text" id="CliPrenom" name="CliPrenom" required><br>
CliMotDePass<input type="text" id="CliMotDePass" name="CliMotDePass" required><br>
CliDateDeNaissance<input type="date" id="CliDateDeNaissance" name="CliDateDeNaissance" required><br>
CompteVerifie<input type="number" id="CompteVerifie" name="CompteVerifie" required><br>
Panier<input type="text" id="Panier" name="Panier" ><br>
Statut<input type="text" id="Statut" name="Statut" required><br>

<input type="submit"  value="Ajouter">
</body>
</html>