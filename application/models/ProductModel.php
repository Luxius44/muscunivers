<?php

require_once APPPATH . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . "ProductEntity.php";
require_once APPPATH . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . "ProductsIterator.php";


class ProductModel extends CI_Model
{	
	//Pour éviter d'afficher tous les produits d'un coup,
	//nous avons décidé de mettre en place un systeme de page pour éviter des longs chargements
	// nous affichons 12 produits par page
	//Donc cette fonction prend en parametre l'id de la categorie et le numéro de page où l'on cherche
	// Cette fonction retourne la liste des produits dans un tableau
	function findAllbyPage(int $prodCat, int $page):array{
		$this->db->select('*');
		$this->db->where('ProdCat',$prodCat);
		$q = $this->db->get('Produit');
		$response = $q-> custom_result_object("ProductEntity");
		$response = array_slice($response,($page-1)*12,12); //Calcule permettant d'avoir les produits de la bonne page
		return $response;
	}
	//Fonction qui renvoie tous les produits contenu dans une catégorie dont l'id est entré en paramètre.
	function findByCateg(int $cat){
		$this->db->select('*');
		$this->db->where('ProdCat',$cat);
		$q = $this->db->get('Produit');
		$response = $q-> custom_result_object("ProductEntity");
		return $response;
	}

	//Fonction qui renvoie le nombre de produit contenu dans une catégorie dont l'id est entré en paramètre.
	function numberOfProductsByCat(int $prodCat):int{
		$this->db->select('*');
		$this->db->where('ProdCat',$prodCat);
		$q = $this->db->get('Produit');
		$response = $q->num_rows();
		return $response;
	}
	
	//Fonction qui renvoie un produit en fonction de l'id rentré en paramètre.
	function findByID(int $ID):? ProductEntity{
		$this->db->select('*');
		$this->db->where('ProdID',$ID);
		$q = $this->db->get('Produit');
		$response = $q->custom_result_object("ProductEntity")[0];
		return $response;
	}

	//Fonction qui retourne tous les produits de la base de donnée.
	function findAllMuscu():array{
		$this->db->select('*');
		$q = $this->db->get('Produit');
		$response = $q->custom_result_object("ProductEntity");
		return $response;
	}

	//Fonction qui permet de mettre à jour les informations des Produits
	//Le try catch est utilisé pour éviter les erreurs de la bd.
	function modification_produit($id,ProductEntity $product):? ProductEntity{
		$prodNom=$product->getProdNom();
		$prodDesc=$product->getProdDesc();
		$stock=$product->getStock();
		$prix=$product->getPrix();
		$ProdCat=$product->getCatId();
		$donnee=array('ProdID'=>$id,'ProdNom'=>$prodNom,'ProdDesc'=>$prodDesc,'Stock'=>$stock,'Prix'=>$prix,'ProdCat'=>$ProdCat);
		try{
			$db_debug=$this->db->db_debug;
			$this->db->db_debug = FALSE;
			$this->db->set($donnee);
			$this->db->where('ProdID',$id);
			$this->db->update('Produit');
			$this->db->db_debug=$db_debug;
		} catch(Exception $e){}
		return $this->findById($id);
	}

	//Fonction qui créé un Produit et rentre ses informations dans la base de donnée.
	//La fonction renvoie le Produit créé ou null si la bd renvoie une erreur.
	function ajout(ProductEntity $product):? ProductEntity{
		$prodId=$product->getProdId();
		$prodNom=$product->getProdNom();
		$prodDesc=$product->getProdDesc();
		$stock=$product->getStock();
		$prix=$product->getPrix();
		$ProdCat=$product->getCatId();
		$donnee=array('ProdID'=>$prodId,'ProdNom'=>$prodNom,'ProdDesc'=>$prodDesc,'Stock'=>$stock,'Prix'=>$prix,'ProdCat'=>$ProdCat);
		try{
			$db_debug=$this->db->db_debug;
			$this->db->db_debug = FALSE;
			$this->db->insert('Produit',$donnee);
			$this->db->db_debug=$db_debug;
		} catch (Exception $e) {}
		return $product;
	}
	
	// Fonction qui supprime un Produit avec l'Id mis en paramètre.
	function supprime(int $id): bool {
		$this->db->delete('Produit', array('ProdID' => $id));
		return $this->db->affected_rows()!=0;
	}

	// Fonction qui tente de modifier la quantite pour les produits
	// d'un array.
	function commande(array $panier):bool {
		try {
			foreach ($panier as $product) {
				$prod=$this->findByID($product['id']);
				if ($prod!=null) {
					$qtd=$prod->getStock()-$product['qtd'];
					if ($qtd>=0) {
						$prod->setStock($qtd);
						$this->modification_produit($product['id'],$prod);
					} else {
						return false;
					}
				}
			}
		} catch (\Throwable $th) {
			return false;
		}
		return true;
	}


}
