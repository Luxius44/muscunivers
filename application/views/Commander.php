<?php  require "header.php"?>
<?php 
    $i=-1;
    $quantite=0;
    $total=0;
    $erreur="";
    if ( isset($error)) {
        $erreur=$error;
    }
?>


<title>Muscunivers | Commande</title>

<a href="javascript:history.back(1)"><img src="<?=$cheminImage.DIRECTORY_SEPARATOR."fleche.png"?>" style="max-width:5%; max-height:5%; position:fixed; padding:1%;"></a>

<div class="cart_all">
    <div class="cart_left">
        <p class="login_error" style="font-size:20px;"><?=$erreur?></p>
        <h1>Confirmation Commande</h1>
        <hr class="cart_ligneCart">
            
        <?php foreach ( $products as $product) :?>
        <?php $i=$i+1;
              $quantite+=$_SESSION['panier_achat'][$i]['qtd'];
              $total+=$_SESSION['panier_achat'][$i]['qtd']*$product->getPrix();
        ?>
        <div class="cart_gridProduit">
            <div class="cart_Produit" style="height:220px;">
                <div class="cart_positionImg"><img src=<?=base_url()."assets/images/Products/".$product->getProdId().".jpg"?> style="height : 200px; width:170px;margin-bottom: 80px;"></div>
                <div class="cart_descriptionProduit">
                    <div class="cart_topBarProduit">
                        <h2 style="width:50%"><?=$product->getProdNom()?></h2>
                    </div>
                    <p>Prix : <?=$product->getPrix()?> €</p>
                    <div class="cart_positonQuantite">
                        <label for="quantite">Quantité : </label>
                        <p class="cart_numberButton" type="number"><?=$_SESSION['panier_achat'][$i]['qtd']?></p>

                    </div>
                    <div class="cart_positionPrix" id="totaux<?=$product->getProdId()?>"><p><?=$product->getPrix()*$_SESSION['panier_achat'][$i]['qtd']?>.00 €</p></div>
                </div>
            </div>  
        </div> 
        <?php endforeach; ?>

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
            <form action="<?=site_url("User/valider_commande")?>" method="post">
                <button class="cart_boutonCommander" type="submit">VALIDER</button>
            </div>
        </div>
        <div>
            <h2>ADRESSE DE LIVRAISON</h2>
            <hr class="cart_lignePaiement">
            <span>Adresse</span>
            <input class="input10" type="text" name="Adresse" required placeholder="12 Rue Maréchal Joffre"></input>
            <span>Ville</span>
            <input class="input10" type="text" name="Ville" required placeholder="Nantes"></input>
            <span>Code Postal</span>
            <input class="input10" type="text" name="Commune" required placeholder="44200"></input>
            <span>Pays</span>
            <input class="input10" type="text" name="Pays" required placeholder="France"></input>
            <input class="" type="text" name="prix" required hidden value="<?=$total?>"></input>
            <input class="" type="text" name="quantite" required hidden value="<?=$quantite?>"></input>
        </form>
        </div>
    </div>
</div>

<?php require "footer.php"?>
<?php require "footer2.php"?>