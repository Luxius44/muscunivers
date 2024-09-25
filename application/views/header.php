<?php

$bonjour="";
if ( isset($_SESSION['user'])) {
    $bonjour="Bienvenue ".reset($_SESSION['user']);
}
$cheminImage = base_url()."assets/images";

function ItemNav($lien,$nom) : string{
    $section = "";
    $categorieURL = explode("/", $_SERVER['REQUEST_URI']);
    if (count($categorieURL)>3){
	$section = $categorieURL[3];
    }
    $title="";
    $class = "";
    if ($section == $lien):
        $class = "active";
    endif;
    return $title.'<li><a href='.site_url("home".DIRECTORY_SEPARATOR.$lien).' class="lien '.$class.'">'.$nom.'</a></li>';
}
?>
<!DOCTYPE html>
<html lang="fr">
    <head>          
        <meta charset="UTF-8">
        <link rel="shortcut icon" href="<?=$cheminImage?>/favicon.ico">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="<?=base_url()?>assets/css/site.css" type="text/css">
    </head>
    <body>
        <nav class = "navbar">
            <ul class="leftBox">
            	<li><a href =<?=site_url("home/index")?>>
            		<img id = "logoNavBar" src = "<?=$cheminImage?>/header/musculogo.png" >
            	    </a>
            	</li>
                <ul class = "menuDeroulant">
                    <li class="deroulant"><a class = "lienDeroulant" href="#"><img class = "imageDeroulant" src = "<?=$cheminImage?>/header/justify.png"></a></li>
                    <ul class="sousDeroulant">
                        <li><a class = "lien3" href="<?=site_url("home/musculation")?>">Musculation</a></li>
                        <li><a class = "lien3" href="<?=site_url("home/fitness")?>">Fitness</a></li>
                        <li><a class = "lien3" href="<?=site_url("home/complements")?>">Complements</a></li>
                        <li><a class = "lien3" href="<?=site_url("home/apropos")?>">A Propos</a></li>
                    </ul>
                </ul>
                <?=ItemNav("musculation","Musculation")?>
                <?=ItemNav("fitness","Fitness")?>
                <?=ItemNav("complements","Complements")?>
                <?=ItemNav("apropos","A Propos")?>
            </ul>
            <ul class = "rightBox">
            <p><h4><?=$bonjour?></h4></p>
            <li>
                <a href = <?=site_url("user/login")?>>
            		<img class = "imageNavBar" src = "<?=$cheminImage?>/header/icon_account_white.png" >
            	</a>
            </li>
            <li>
                <a href = <?=site_url("user/cart")?>>
                    <img class = "imageNavBar" src = "<?=$cheminImage?>/header/icon_cart_white.png" >
                </a>
                <?php 
                    $nb=0;
                    if (isset($_SESSION['panier'])) {
                        foreach ($_SESSION['panier'] as $product) {
                            $nb+=$product['qtd'];
                        } 
                    }
                ?>
            </li>
            <p class="nbPanier"><?=$nb?><p>
            </ul>
        </nav>
