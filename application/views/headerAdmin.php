<?php
$cheminImage = base_url()."assets/images";

function ItemNavA($lien,$nom) : string{
    $title="";
    $class = "";
    if ($_SERVER['REQUEST_URI'] == base_url().'/index.php/Admin'.$lien):
        $title = "<title>Muscunivers | Admin";
        $class = "active";
    endif;
    return $title.'<li><a href='.site_url("Admin/".$lien).' class="lien '.$class.'">'.$nom.'</a></li>';
}
?>
<!DOCTYPE html>
<html lang="fr">
    <head>          
        <meta charset="UTF-8">
        <link rel="shortcut icon" href="<?=$cheminImage?>/favicon.ico">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="<?=base_url()?>/assets/css/site.css" type="text/css">
    </head>
    <body>
        <nav class = "navbar">
            <ul class="leftBox">
            	<li><a href =<?=site_url("Admin/accueilAdmin_redirect")?>>
            		<img id = "logoNavBar" src = "<?=$cheminImage?>/header/musculogo.png" >
            	    </a>
            	</li>
                <?=ItemNavA("admin_redirect","Produits")?>
                <?=ItemNavA("adminClient_redirect","Clients")?>
                <?=ItemNavA("adminCommande_redirect","Commandes")?>
                <?=ItemNavA("boutique_redirect","Retour Boutique")?>
            </ul>
        </nav>
