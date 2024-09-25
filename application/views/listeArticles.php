<?php require "header.php"?>
<title>Muscunivers | Liste </title>
    
    <div class="pageArticle_titre"><h1 >TROUVEZ LE PRODUIT QUI CONVIENT LE MIEUX A VOS BESOINS</h1></div>
    <div class = "conteneurGrille">
      <articles>
          <?php
            while ($ProductsIterator->valid()) {
              $product = $ProductsIterator->current();
              $img=$product->getProdId();
              echo "<a href = '".site_url("Product/produit/".$product->getProdId())."'style = 'text-decoration : none';>
                    <div class = article>
                      <img class = 'image' src =".$cheminImage.DIRECTORY_SEPARATOR."Products".DIRECTORY_SEPARATOR.$img.".jpg>
                      <span class = 'listeArticlesNom'>".$product->getProdNom()."</span><span class = 'listeArticlesPrix'>".$product->getPrix()." €</span>
                    </div>
                    </a>";
              $ProductsIterator->next();
              }
          ?>
        </articles>
    </div>
    <?php
    	$nbPages = ceil($nbrProducts/12)
    ?>
    <div class = "nombrePagesArticles">

      <?php if ($currentPage <= 1){
        echo '<a href = ""><button disabled class = "switchLeftPage"> < </button> </a>';
      }else{
        echo '<a href = '.($currentPage-1).'><button class = "switchLeftPage"> < </button> </a>';
      }
      ?>

      <span>Page <?=$currentPage?> sur <?=$nbPages?></span>


      <?php if ($currentPage >= $nbPages){
        echo '<a href = ""><button disabled class = "switchRightPage"> > </button> </a>';
      }else{
        echo '<a href = '.($currentPage+1).'><button class = "switchRightPage"> > </button> </a>';
      }
      ?>
    </div>
</body>
</html>
<?php require "footer.php"?>
<?php require "footer2.php"?>

