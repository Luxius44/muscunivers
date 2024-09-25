<?php require "header.php"?>
<?php 
    $product=$products;
?>

<html>
    <a href="javascript:history.back(1)"><img src="<?=$cheminImage.DIRECTORY_SEPARATOR."fleche.png"?>" style="max-width:5%; max-height:5%; position:fixed; padding:1%;"></a>
    <div class = "articleLayout">
        <div class ="articleLayoutLeft">
            <div id = "zoom" style = "background-image: url('<?=$cheminImage.DIRECTORY_SEPARATOR."Products".DIRECTORY_SEPARATOR.$product->getProdId().".jpg"?>')"></div>
            <img id = "productImage" onmousemove="bigImg()" onmouseout = initImg() src ="<?=$cheminImage.DIRECTORY_SEPARATOR."Products".DIRECTORY_SEPARATOR.$product->getProdId().".jpg"?>">
            <title> Muscunivers | Produit </title>
            <script>
                let scale = 1000;
                let image = document.getElementById("productImage");
                let zoom = document.getElementById("zoom");
                function bigImg(){
                    let rectImage = image.getBoundingClientRect();
                    X= event.clientX - rectImage.x;
                    Y= event.clientY - rectImage.top - image.scrollTop;
                    zoom.style.left = X - zoom.offsetWidth/2+"px"
                    zoom.style.top = Y - zoom.offsetHeight/2+"px"
                    zoom.style.backgroundSize = scale+"px";
                    zoom.style.backgroundPosition = ((-X*scale) /   image.offsetWidth + 50)+"px "+((-Y *scale)/ image.offsetHeight + 50) +"px"
                }

                function initImg(){
                    zoom.style.left = 0+"px"
                    zoom.style.top = 0+"px"
                    zoom.style.backgroundPosition = "0px 0px"
                    zoom.style.backgroundSize = 100+"%";
                }
            </script>
            
        </div>
        <div class ="articleLayoutRight">
            <span class = 'articleLayoutDesc'><?=$product->getProdNom()?></span>
            <span class = 'articleLayoutDesc'><?=$product->getPrix()?> €</span>
            <span class = 'articleLayoutDesc'><?=$product->getProdDesc()?></span>
            <?php 
            $value="Ajouter au Panier";
            $disabled="";
            if ( $product->getStock()<=0) {
                $value="Produit Hors Stock";
                $disabled="disabled";
            }
            ?>
            <a href="<?=site_url("User/Panier/".$product->getProdId()."/".$product->getStock()."")?>"><input type="button" id = "addToCartButton" name = "addToCartButton" value='<?=$value?>' <?=$disabled?>></a>

        </div>
    </div>
<?php require "footer.php"?>
<?php require "footer2.php"?>
