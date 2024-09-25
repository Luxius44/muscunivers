<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="package/images/favicon.ico">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300&display=swap" rel="stylesheet">
   
</head>
    <body>
        <div class="body">
        <img src="<?=$cheminImage?>/Muscuniverslogo.png" alt="Logo de muscunivers" style="height: 150px; width: 150px; margin-top:-1%;margin-bottom:-3%;">
         <ul class="principal">
            <li class = "imgFooter">
                <h1>Nos Magasins</h1>
                <a href="https://www.google.fr/maps/place/Protein+Shop+33/@44.8901067,-0.5055512,16.25z/data=!4m9!1m2!2m1!1sBoutique+musculaiton!3m5!1s0xd552ee1228db5e5:0x1212449fb1fd4655!8m2!3d44.8904463!4d-0.5037406!15sChRCb3V0aXF1ZSBtdXNjdWxhdGlvbpIBDG51dHJpdGlvbmlzdOABAA" style="color:black;">Bordeaux</a>
                <a href="https://www.google.fr/maps/place/Gym+Wear's/@47.2354018,-1.5342281,20.75z/data=!4m5!3m4!1s0x4805eef19ca76781:0xd408c3dea7f782dc!8m2!3d47.2354293!4d-1.5343823" style="color:black;">Nantes</a>
            </li>
            <li class = "imgFooter">
                <h1>Mieux nous connaître</h1>
                <a href="<?=site_url("user/apropos/1")?>" style="color:black;">Qui sommes-nous ?</a>
                <a href="<?=site_url("user/apropos/2")?>" style="color:black;">Nous contacter</a>
            </li>   
            <li class = "imgFooter">
                <h1>Compte</h1>
                <a href="<?=site_url("user/login")?>" style="color:black;">Votre compte</a>
                <a href="<?=site_url("user/cart")?>" style="color:black;">Votre panier</a>
                    
            </li>
         </ul>
         <hr width="800px" size="1px" noshade="noshade">
         <div class="postion">
         <ul class="lePlusBas">
            <li class = "imgFooter">
                <a href="<?=site_url("/home/mentions")?>" style="color:black;">Mentions légales</a>
            </li>
            <li class = "imgFooter">
                <a href="<?=site_url("/home/confidentialite")?>" style="color:black;">Confidentialité</a>
            </li>
            <li class = "imgFooter">
                <a href="<?=site_url("/home/cgu")?>" style="color:black;">C.G.U</a>
            </li>
         </ul>
        </div>
        </div>
        </body>
</html>
