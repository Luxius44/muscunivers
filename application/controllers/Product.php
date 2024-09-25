<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {


	public function __construct()
	{
		parent::__construct();
		//Si besoin por debuguer
		//$this->output->enable_profiler(TRUE);
		$this->load->helper('url');
		$this->load->model('ProductModel');
		$this->load->library('session');
		$this->load->driver('cache');
	}	
	
/*
* Les fonctions musculation, fitness et Complements ont pour but de charger la vue articles avec un nombre de produits et une liste de produits correspondant
* à la page et à la catégorie entrées en paramètres
* @param $categ =  un entier correspondant à un numéro de catégorie
* @param $page = un entier correspondant au numéro de la page demandé
*/

	function musculation(int $categ, int $page){
		if (!$products = $this->cache->file->get('Products'."$categ"."$page")){
			/*Si le cache ne contient pas la liste des produits correspondant à la catégorie et à la page recherchés, on cherche cette liste dans la base de données
			puis on la sauvegarde dans le cache sous le nom de fichier Product$Categ$Page */
			$products = $this->ProductModel->findAllbyPage($categ,$page);
			$this->cache->file->save('Products'."$categ"."$page", $products,1800);
			if (!$nbrProducts = $this->cache->file->get('NbrProducts'."$categ")){
				/*Si la catégorie n'a jamais été visitée, alors on récupère la somme de ses produits depuis la base de données et on sauvegarde 
				le résultat dans le cache*/
				$nbrProducts = $this->ProductModel->numberOfProductsByCat($categ);
				$this->cache->file->save('NbrProducts'."$categ", $nbrProducts,1800);
			}
		}else{
			$nbrProducts = $this->cache->file->get('NbrProducts'."$categ");
		}
		// On charge l'itérateur de produits pour parcourir la liste des produits (contrainte de M.Lanoix)
		$ProductsIterator = new ProductsIterator($products);
		$this->load->view('listeArticles',array('ProductsIterator'=>$ProductsIterator,'nbrProducts'=>$nbrProducts,'currentPage'=>$page));
	}


	function fitness(int $categ, int $page){
		if (!$products = $this->cache->file->get('Products'."$categ"."$page")){
			$products = $this->ProductModel->findAllbyPage($categ,$page);
			$this->cache->file->save('Products'."$categ"."$page", $products,1800);
			if (!$nbrProducts = $this->cache->file->get('NbrProducts'."$categ")){
				$nbrProducts = $this->ProductModel->numberOfProductsByCat($categ);
				$this->cache->file->save('NbrProducts'."$categ", $nbrProducts,1800);
			}
		}else{
			$nbrProducts = $this->cache->file->get('NbrProducts'."$categ");
		}
		$ProductsIterator = new ProductsIterator($products);
		$this->load->view('listeArticles',array('ProductsIterator'=>$ProductsIterator,'nbrProducts'=>$nbrProducts,'currentPage'=>$page));
	}

	function complements(int $categ, int $page){
		if (!$products = $this->cache->file->get('Products'."$categ"."$page")){
			$products = $this->ProductModel->findAllbyPage($categ,$page);
			$this->cache->file->save('Products'."$categ"."$page", $products,1800);
			if (!$nbrProducts = $this->cache->file->get('NbrProducts'."$categ")){
				$nbrProducts = $this->ProductModel->numberOfProductsByCat($categ);
				$this->cache->file->save('NbrProducts'."$categ", $nbrProducts,1800);
			}
		}else{
			$nbrProducts = $this->cache->file->get('NbrProducts'."$categ");
		}
		$ProductsIterator = new ProductsIterator($products);
		$this->load->view('listeArticles',array('ProductsIterator'=>$ProductsIterator,'nbrProducts'=>$nbrProducts,'currentPage'=>$page));
	}

	/*
	* La fonction produit charge la page pageArticle.php avec le produit correspondant à l'id entrée en paramètre
	* @param $idprod =  un entier correspondant à un numéro de produit
	*/
	function produit(int $idprod){
		$product=$this->ProductModel->findByID($idprod);
		$this->load->view('pageArticle',array('products'=>$product));
	} 


}
