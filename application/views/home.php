<?php require "header.php"?>
<title>Muscunivers</title>

<div class="home_bg">
        <div class="home_transition">
            <a class="btn-shine" target="_blank"><< Il n'est jamais trop tard pour se fixer de nouveaux objectifs >></a>
        </div>
    <div class="home_top">
        <div></div>
        <div class="home_decouverte_produit">
            <h2>Découvrez nos gammes de produits :</h2>
            <div class="home_position_liste">    
                <a href="#Musculation" >Musculation</a>
                <a href="#Fitness" >Fitness</a>
                <a href="#Complements">Compléments</a>
                <p></p>
                <p></p>
                <p id="Musculation"></p>
            </div>    
        </div>
    </div>
    </div>
    <div class="home_musculation">
        <h1 style="display:flex; justify-content:center;">Découvrez un large choix de produits de musculation</h1>
        <div class="home_case2">
            <div class="home_image">
                <img src="<?=$cheminImage?>/home/musculationhomec.jpg" style="max-width: 100%;max-height: 100%;">
            </div>
            <div class="home_text">
                <p>La rubrique musculation de notre site propose une large gamme de produits pour les passionnés de musculation.<br><br> Vous y trouverez des équipements de musculation en tout genre Poids, Bancs, Stations et bien plus encore.<br><br> Tous les produits sont de haute qualité et sélectionnés avec soin pour répondre aux besoins des sportifs de tous niveaux.<br><br> Nous avons également des marques reconnues ainsi que des nouveautés pour vous tenir à jour sur les dernières tendances en matière de musculation.<br><br> Naviguez sur notre site pour découvrir notre sélection complète et trouver les produits qui vous conviennent le mieux.</p>
            </div>
        </div>
        <div class="home_position_button">
        <a href="<?=site_url("home/musculation")?>"><button id=Fitness class="muscunivers_button home_button">DÉCOUVREZ MAINTENANT</button></a>
        </div>
    </div>
    <div class="home_fitness">
    <h1 style="display:flex; justify-content:center;">Découvrez un large choix de produits de fitness</h1>
        <div class="home_case2">
            <div class="home_image">
                <img src="<?=$cheminImage?>/home/fitnesshome.jpg"style="max-width: 100%;max-height: 100%;">
            </div>
            <div class="home_text">
                <p>La rubrique fitness de notre site est dédiée aux personnes qui cherchent à améliorer leur forme physique et leur bien-être.<br><br> Nous proposons une large sélection de produits pour tous les niveaux et tous les types d'exercices, allant des équipements de cardio, accessoires pour le yoga, le Pilates et autres activités de bien-être.<br><br> Vous pouvez trouver des marques reconnues ainsi que des nouveautés pour vous tenir à jour sur les dernières tendances en matière de fitness.<br><br> Naviguez sur notre site pour découvrir notre sélection complète et trouver les produits qui vous conviennent le mieux pour atteindre vos objectifs.</p>
            </div>
        </div>
        <div class="home_position_button" id="Complements">
        <a href="<?=site_url("home/fitness")?>"><button type="submit" class="muscunivers_button home_button">DÉCOUVREZ MAINTENANT</button></a>
        </div>
    </div>
</div>
<div class="home_complement">
        <h1></h1>
        <div class="home_position_button">
            <a href="<?=site_url("Product/complements/1/1")?>"><button class="muscunivers_button home_button">DÉCOUVREZ MAINTENANT</button></a>
        </div>
    </div>


<?php require "footer.php"?>
<?php require "footer2.php"?>

