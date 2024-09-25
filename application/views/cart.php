<?php  require "header.php"?>
<?php 
$i=-1;
$quantite=0;
$total=0;
$erreur="";
if (isset($error)) {
    $erreur=$error;
}
?>


<title>Muscunivers | Panier</title>
<div class="cart_all">
    <div class="cart_left">
        <p class="login_error"><?=$erreur?></p>
        <h1>Mes Articles</h1>
        <hr class="cart_ligneCart">
        <?php if ( sizeof($products)!=0) { ?>
            
        <?php foreach ( $products as $product) :?>
        <?php $i=$i+1;
              $quantite+=$_SESSION['panier'][$i]['qtd'];
              $total+=$_SESSION['panier'][$i]['qtd']*$product->getPrix();
        ?>
        <div class="cart_gridProduit">
            <div class="cart_Produit">
                <div class="cart_positionImg"><img src=<?=base_url()."assets/images/Products/".$product->getProdId().".jpg"?> style="height : 290px; width: 200px"></div>
                <div class="cart_descriptionProduit">
                    <div class="cart_topBarProduit">
                        <h2 style="width:50%"><?=$product->getProdNom()?></h2>
                        <div class="cart_PositionButton"><a href="<?=site_url("User/delete/".$product->getProdId()."")?>"><button class="cart_supprimerProduit">x</button></a></div>
                    </div>
                    <p>Prix : <?=$product->getPrix()?> €</p>
                    <p>Quantité restante : <?=$product->getStock()?></p>
                    <?php 
                        if ( $product->getStock()<$_SESSION['panier'][$i]['qtd']){
                            $_SESSION['panier'][$i]['qtd']=$product->getStock();
                        }
                    ?>
                    <div class="cart_positonQuantite">
                        <label for="quantite">Quantité : </label>
                        <form action=<?=site_url("User/modifcookie/".$product->getProdId()."")?> method="post">
                        <input class="cart_numberButton" onkeypress="return isNumeric(event)" oninput="return maxCheck<?=$product->getProdId()?>(this),isChange<?=$product->getProdId()?>(this)" type="number" id="quantite<?=$product->getProdId()?>" min="0" max="<?=$product->getStock()?>" value="<?=$_SESSION['panier'][$i]['qtd']?>" name="quantite" >

                    </div>
                    <div class="cart_positionPrix" id="totaux<?=$product->getProdId()?>"><p><?=$product->getPrix()*$_SESSION['panier'][$i]['qtd']?>.00 €</p></div>
                    <div class="cart_positionConfirmer">
                        <input type="submit" id="button<?=$product->getProdId()?>" hidden value="Confirmer"></input>
                        </form>
                    </div>
                </div>
                <script>
                    window.addEventListener('DOMContentLoaded', function() {
                    const quantite = document.getElementById('quantite<?=$product->getProdId()?>');
                    const zone = document.getElementById('totaux<?=$product->getProdId()?>');
                    quantite.addEventListener('input', function() {
                        let nb1Val = Number(quantite.value)*<?=$product->getPrix()?>;
                        zone.innerHTML = nb1Val+".00 €";
                    });
                });
                function maxCheck<?=$product->getProdId()?>(object) {
                    if ( parseInt(object.value) > parseInt(object.max)) {
                        object.value = <?=$product->getStock()?>
                    }
                }
                    
                function isNumeric (evt) {
                    var theEvent = evt || window.event;
                    var key = theEvent.keyCode || theEvent.which;
                    key = String.fromCharCode (key);
                    var regex = /[0-9]|\./;
                    if ( !regex.test(key) ) {
                        theEvent.returnValue = false;
                    if(theEvent.preventDefault) theEvent.preventDefault();
                    }
                }

                function isChange<?=$product->getProdId()?>(object){
                    if (parseInt(object.value)!=parseInt(<?=$_SESSION['panier'][$i]['qtd']?>)) {
                        document.getElementById('button<?=$product->getProdId()?>').hidden=false;
                    } else {
                        document.getElementById('button<?=$product->getProdId()?>').hidden=true;
                    }
                    
                }

                </script>
            </div>  
        </div> 
        <?php endforeach; ?>

        <?php }else { ?>
            <h1> Votre panier est vide </h1>
        <?php } ?>
    </div>
    <div class="cart_right">
        <h1>Paiement</h1>
        <hr class="cart_lignePaiement">
        <div class="cart_paiement">
            <h2>MA COMMANDE</h2>
            <div class="cart_commandeArticle">
                <div class="cart_nbArticles">
                    <p id="nbArticle"><?=$quantite?> article</p>
                </div>
                <div class="cart_prixArticle">
                    <p id="prixTotal"><?=$total?>.00 €</p>
                </div>            
            </div>
            <div class="cart_ligneCommande"></div>
            <div class="cart_commandeArticle">
                <div class="cart_total">
                    <h3>TOTAL</h3>
                </div>
                <div class="cart_prixTotal">
                    <p id="prixTotale"><?=$total?>.00 €</p>
                </div>
            </div>
            <div class="cart_commander">
                <a href="<?=site_url("User/commander")?>"><input class="cart_boutonCommander" type="button" value="COMMANDER"></a>
            </div>
        </div>
        <a href="<?=site_url("User/delete_all")?>" style="color:black; justify-content:center; display:flex;"> Vider panier </a>
    </div>
</div>

<?php require "footer.php"?>
<?php require "footer2.php"?>