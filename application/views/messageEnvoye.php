<?php 
$cheminImage = base_url()."assets/images";
?>
<?php require "header.php"?>
<?php 
if (isset($message1)){
    $messages1=$message1;
}
if (isset($message2)){
    $messages2=$message2;
}
if (isset($message3)){
    $messages3=$message3;
}else{
    $messages3="";
}
?>
<title>Muscunivers | Message</title>



 <div class="pageMail_body">
    <div class="pageMail_posPhoto">
        <img src="<?=$cheminImage?>/Muscuniverslogo.png" alt="logo_muscunivers">
        </div>
        <div class="pageMail_posTexte">
        <h1><?=$messages1?></h1>
        <h2><?=$messages2?></h2>
        <h3><?=$messages3?></h3>
        <a href="<?=site_url("home/index")?>">Revenir à l'acceuil</a>
    </div>

</div>


<?php
?>