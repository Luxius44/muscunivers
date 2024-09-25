<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.DIRECTORY_SEPARATOR.'models'.DIRECTORY_SEPARATOR."ProductEntity.php";
class Admin extends CI_Controller{

//Dans certaines fonctions de cette classe,
//on charge la bibliothèque "form validation" a chaque input pour s'assurer que l'utilisateur rentre bien ses informations 
//Avec le bon nombre de caractères.


    public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
        $this->load->model('ProductModel');
        $this->load->model('UserModel');
        $this->load->model('OrderModel');
        $this->load->model('OrderProductModel');
        $this->load->library('session');
        $this->load->driver('cache');
	}


function accueilAdmin_redirect(){
    if ( $_SESSION["user"]["Statut"]=="Admin") {
        $this->load->view('pageAdminHome');
    } else {
        redirect("home");
    }
}


function boutique_redirect(){
    redirect('home');
}
//--------------------------------------------------------------------Produid------------------------------------------------------------------------------------------//


    //Fonction qui modifie les informations du produit dans la base de donnée 
    //en fonction des informations rentrées dans la page "modificationProduit". 
    function modificationProduit(){
        if ( $_SESSION["user"]["Statut"]=="Admin") {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('ProdId', 'ProdId','required');
            $this->form_validation->set_rules('ProdNom', 'ProdNom','required|max_length[31]');
            $this->form_validation->set_rules('ProdDesc', 'ProdDesc','required');
            $this->form_validation->set_rules('Stock', 'Stock','required');
            $this->form_validation->set_rules('Prix', 'Prix','required');
            $this->form_validation->set_rules('CatId', 'CatId','required');

            if ($this->form_validation->run() == FALSE){
                $id=$this->input->post('ProdId');
                redirect('admin/modificationProduit_redirect/'.$id);
            }
            else{
                $id=$this->input->post('ProdId');
                $product=new ProductEntity;
                $product->setProdId($this->input->post('ProdId'));
                $product->setProdNom($this->input->post('ProdNom'));
                $product->setProdDesc($this->input->post('ProdDesc'));
                $product->setStock($this->input->post('Stock'));
                $product->setPrix($this->input->post('Prix'));
                $product->setCatId($this->input->post('CatId'));
                $product=$this->ProductModel->modification_produit($id,$product);
                $this->cache->file->clean();
                redirect('admin/admin_redirect');
            }
        } else {
            redirect("home");
        }
    }

    //Fonction qui ajoute un produit dans la base de donnée
    //En fonction des informations rentrées sur la page "ajoutProduit".
    function ajoutProduit(){
        if ( $_SESSION["user"]["Statut"]=="Admin") {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('ProdId', 'ProdId','required');
            $this->form_validation->set_rules('ProdNom', 'ProdNom','required|max_length[31]');
            $this->form_validation->set_rules('ProdDesc', 'ProdDesc','required');
            $this->form_validation->set_rules('Stock', 'Stock','required');
            $this->form_validation->set_rules('Prix', 'Prix','required');
            $this->form_validation->set_rules('CatId', 'CatId','required');

            if ($this->form_validation->run() == FALSE){
                redirect('admin/ajoutProduit_redirect/');
            }
            else{
                $product=new ProductEntity;
                $product->setProdId($this->input->post('ProdId'));
                $product->setProdNom($this->input->post('ProdNom'));
                $product->setProdDesc($this->input->post('ProdDesc'));
                $product->setStock($this->input->post('Stock'));
                $product->setPrix($this->input->post('Prix'));
                $product->setCatId($this->input->post('CatId'));
                $product=$this->ProductModel->ajout($product);
                $this->cache->file->clean();
                redirect('admin/admin_redirect');
            }
        } else {
            redirect("home");
        }
    }

    //Fonction qui supprime un produit dans la base de donnée en fonction de l'id de celui-ci
    function suppressionProduit($id){
        if ( $_SESSION['user']['Statut']=="Admin") {
            $res = $this->ProductModel->supprime($id);
            $this->cache->file->clean();
            redirect('admin/admin_redirect');
        } else {
            redirect("home");
        }
	}

    //Fonction qui redirige vers la page "pageAdminProduit"
    //en lui envoyant tout les produits de la base de données.
    function admin_redirect(){
        if ( $_SESSION["user"]["Statut"]=="Admin") {
            $this->load->model('ProductModel');
            $products = $this->ProductModel->findAllMuscu();
            $data = array("prods"=>$products);
            $this->load->view('pageAdminProduit',$data);
        } else {
            redirect("home");
        }
	}

    //Fonction qui redirige vers la page "modificationProduit"
    //en lui envoyant le produit correspondant a l'id rentrée en paramètre.
	function modificationProduit_redirect($id){
        if ( $_SESSION["user"]["Statut"]=="Admin") {
            $product = $this->ProductModel->findById($id);
            $this->load->view("modificationProduit",array("product"=>$product));
        } else {
            redirect("home");
        }
	}

    //Fonction qui redirige vers la page "ajoutProduit"
	function ajoutProduit_redirect(){
        if ( $_SESSION["user"]["Statut"]=="Admin") {
            $this->load->view("ajoutProduit");
        } else {
            redirect("home");
        }
	}

/*--------------------------------------------------------------------Client------------------------------------------------------------------------------------------*/
    

    //Fonction qui modifie les informations du Client dans la base de donnée 
    //en fonction des informations rentrées dans la page "modificationClient". 
    function modification_Client(){
        if ( $_SESSION["user"]["Statut"]=="Admin") {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('CliId', 'CliId','required');
            $this->form_validation->set_rules('Email', 'Email','required|max_length[63]');
            $this->form_validation->set_rules('CliNom', 'CliNom','required|max_length[31]');
            $this->form_validation->set_rules('CliPrenom', 'CliPrenom','required|max_length[31]');
            $this->form_validation->set_rules('CliMotDePass', 'CliMotDePass','required');
            $this->form_validation->set_rules('CliDateDeNaissance', 'CliDateDeNaissance','required');
            $this->form_validation->set_rules('CompteVerifie', 'CompteVerifie','required');
            $this->form_validation->set_rules('Statut', 'Statut','required|max_length[31]');
            $this->form_validation->set_rules('Panier', 'Panier','max_length[63]');

            if ($this->form_validation->run() == FALSE){
                $id=$this->input->post('CliId');
                redirect('admin/modificationClient_redirect/'.$id);
            }
            else{
                $id=$this->input->post('CliId');
            $client=$this->UserModel->findById($id);

            $client->setEmail($this->input->post('Email'));
            $client->setClinom($this->input->post('CliNom'));
            $client->setCliPrenom($this->input->post('CliPrenom'));
            //Si le mot de passe n'est pas changé dans l'input, le mot de passe reste le même et n'est pas crypté de nouveau.
            if ($client->getCliPassword()==$this->input->post('CliMotDePass')){
                $client->setClipassword($this->input->post('CliMotDePass'));
            //Si le mot de passe est changé, on crypte le nouveau mot de passe avant de l'enregistrer dans la bd.  
            } else{
                $client->setClipassword(password_hash($this->input->post('CliMotDePass'), PASSWORD_DEFAULT));
            }

            $client->setCliDateDeNaissance($this->input->post('CliDateDeNaissance'));
            $client->setCompteVerifie($this->input->post('CompteVerifie'));
            $client->setPanier($this->input->post('Panier'));
            $client->setStatut($this->input->post('Statut'));
            $this->UserModel->modification_Client($id,$client);
            redirect('admin/adminClient_redirect');
            }
        } else {
            redirect("home");
        }
    }

    //Fonction qui ajoute un Client dans la base de donnée
    //En fonction des informations rentrées sur la page "ajoutClient".
    function ajoutClient(){
        if ( $_SESSION["user"]["Statut"]=="Admin") {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('CliId', 'CliId','required');
            $this->form_validation->set_rules('Email', 'Email','required|max_length[63]');
            $this->form_validation->set_rules('CliNom', 'CliNom','required|max_length[31]');
            $this->form_validation->set_rules('CliPrenom', 'CliPrenom','required|max_length[31]');
            $this->form_validation->set_rules('CliMotDePass', 'CliMotDePass','required');
            $this->form_validation->set_rules('CliDateDeNaissance', 'CliDateDeNaissance','required');
            $this->form_validation->set_rules('CompteVerifie', 'CompteVerifie','required');
            $this->form_validation->set_rules('Statut', 'Statut','required|max_length[31]');
            $this->form_validation->set_rules('Panier', 'Panier','max_length[63]');

            if ($this->form_validation->run() == FALSE){
                $id=$this->input->post('CliId');
                redirect('admin/ajoutClient_redirect/');
            }
            else{
                $client=new UserEntity;
                $client->setCliId($this->input->post('CliId'));
                $client->setEmail($this->input->post('Email'));
                $client->setClinom($this->input->post('CliNom'));
                $client->setCliPrenom($this->input->post('CliPrenom'));
                $client->setClipassword(password_hash($this->input->post('CliMotDePass'), PASSWORD_DEFAULT));
                $client->setCliDateDeNaissance($this->input->post('CliDateDeNaissance'));
                $client->setCompteVerifie($this->input->post('CompteVerifie'));
                $client->setPanier($this->input->post('Panier'));
                $client->setStatut($this->input->post('Statut'));
                $client=$this->UserModel->add($client);
                redirect('admin/adminClient_redirect');
            }
        } else {
            redirect("home");
        }
    }

    //Fonction qui supprime un produit dans la base de donnée en fonction de l'id de celui-ci
    function suppressionClient($id){
        if ( $_SESSION['user']['Statut']=="Admin") {
            $res = $this->UserModel->supprime($id);
            redirect('admin/adminClient_redirect');
        } else {
            redirect("home");
        }
	}

    //Fonction qui redirige vers la page "pageAdminClient".
    //En envoyant tout les Users a la page.
    function adminClient_redirect(){
        if ( $_SESSION["user"]["Statut"]=="Admin") {
            $this->load->model('UserModel');
            $users = $this->UserModel->findAll();
            $data = array("users"=>$users);
            $this->load->view('pageAdminClient',$data);
        } else {
            redirect("home");
        }
	}

    //Fonction qui redirige vers la page "modificationClient"
    //en lui envoyant le Client correspondant a l'id rentrée en paramètre.
    function modificationClient_redirect($id){
        if ( $_SESSION["user"]["Statut"]=="Admin") {
            $client=$this->UserModel->findById($id);
            $this->load->view('modificationClient',array("client"=>$client));
        } else {
            redirect("home");
        }
    }

    //Fonction qui redirige vers la page "ajoutClient".
    function ajoutClient_redirect(){
        if ( $_SESSION["user"]["Statut"]=="Admin") {
            $this->load->view('ajoutClient');
        } else {
            redirect("home");
        }
    }


/*--------------------------------------------------------------------Commande------------------------------------------------------------------------------------------*/

    //Fonction qui redirige vers la page "pageAdminCommande".
    //En envoyant toutes les Commandes a la page.
    function adminCommande_redirect(){
        if ( $_SESSION["user"]["Statut"]=="Admin") {
            $this->load->model('OrderModel');
            $cmd = $this->OrderModel->findAll();
            $data = array("cmd"=>$cmd);
            $this->load->view('pageAdminCommande',$data);
        } else {
            redirect("home");
        }
	}

    //Fonction qui ajoute une Commande dans la base de donnée
    //En fonction des informations rentrées sur la page "ajoutCommande".
    function ajoutCommande(){
        if ( $_SESSION["user"]["Statut"]=="Admin") {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('CliId', 'CliId','required');
            $this->form_validation->set_rules('AdresseLivraison', 'AdresseLivraison','required');
            

            if ($this->form_validation->run() == FALSE){
                redirect('admin/ajoutCommande_redirect/');
            }
            else{
                $id=$this->input->post('CliId');
                $adresse=$this->input->post('AdresseLivraison');              
                $Order=$this->OrderModel->createCommande($id,$adresse);
                redirect('admin/adminCommande_redirect');
            }
        } else {
            redirect("home");
        }
    }

    //Fonction qui redirige vers la page "ajoutClient".
    function ajoutCommande_redirect(){
        $this->load->view('AjoutCommande');
    }

    //Fonction qui modifie les informations de la Commande dans la base de donnée 
    //en fonction des informations rentrées dans la page "modificationCommande". 
    function modification_Commande(){
        if ( $_SESSION["user"]["Statut"]=="Admin") {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('CmdId', 'CmdId','required');
            $this->form_validation->set_rules('CliId', 'CliId','required|max_length[31]');
            $this->form_validation->set_rules('DateCommande', 'DateCommande','required');
            $this->form_validation->set_rules('AdresseLivraison', 'AdresseLivraison','required');
            $this->form_validation->set_rules('Statut', 'Statut','required');
            
            if ($this->form_validation->run() == FALSE){
                $id=$this->input->post('CmdId');
                redirect('admin/modificationCommande_redirect/'.$id);
            }
            else{
                $id=$this->input->post('CmdId');
                $Order=new OrderEntity;
                $Order->setCmdId($this->input->post('CmdId'));
                $Order->setCliId($this->input->post('CliId'));
                $Order->setDateCommande($this->input->post('DateCommande'));
                $Order->setAdresseLivraison($this->input->post('AdresseLivraison'));
                $Order->setStatut($this->input->post('Statut'));
                $Order=$this->OrderModel->modification_Commande($id,$Order);
                $this->cache->file->clean();
                redirect('admin/adminCommande_redirect');
            }
        } else {
            redirect("home");
        }
    }

    //Fonction qui redirige vers la page "modificationCommande"
    //en lui envoyant la commande correspondante a l'id rentrée en paramètre.
    function modificationCommande_redirect($cmdId){
        if ( $_SESSION["user"]["Statut"]=="Admin") {
            $cmd=$this->OrderModel->findById($cmdId);
            $this->load->view('ModificationCommande',array("cmd"=>$cmd));
        } else {
            redirect("home");
        }
    }

    //Fonction qui supprime un produit dans la base de donnée en fonction de l'id de celui-ci
    function suppression_Commande($cmdId){
        if ( $_SESSION['user']['Statut']=="Admin") {
            $this->OrderProductModel->supprimeByCmdId($cmdId);
            $res = $this->OrderModel->supprime($cmdId);
            $this->cache->file->clean();
            redirect('admin/adminCommande_redirect/');
        } else {
            redirect("home");
        }
    }


/*--------------------------------------------------------------------CommandeProduit------------------------------------------------------------------------------------------*/

    //Fonction qui redirige vers la page "pageAdminCommandeProduit".
    //En envoyant tous les Produit correspondant a l'id de la commande.
    function pageAdminCommandeProduit_redirect($cmdId){
        if ( $_SESSION["user"]["Statut"]=="Admin") {
            $this->load->model('OrderProductModel');
            $prod = $this->OrderProductModel->findAll($cmdId);
            $data = array("prod"=>$prod,"cmd"=>$cmdId);
            $this->load->view('pageAdminCommandeProduit',$data);
        } else {
            redirect("home");
        }
	}

    //Fonction qui redirige vers la page "ajoutClient".
    //En envoyant l'id de la commande correspondante.
    function ajoutCommandeProduit_redirect($cmdId){
        if ( $_SESSION["user"]["Statut"]=="Admin") {
            $this->load->view('ajoutCommandeProduit',array("cmdId"=>$cmdId));
        } else {
            redirect("home");
        }
    }

    //Fonction qui ajoute un Produit dans la commande passé en paramètre.
    //En fonction des informations rentrées sur la page "ajoutCommandeProduit".
    function ajoutCommandeProduit(){
        if ( $_SESSION["user"]["Statut"]=="Admin") {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('cmdId', 'cmdId','required');
            $this->form_validation->set_rules('prodId', 'prodId','required');
            $this->form_validation->set_rules('quantite', 'quantite','required');
            

            if ($this->form_validation->run() == FALSE){
                redirect('admin/ajoutCommandeProduit/');
            }
            else{
                $cmdId=$this->input->post('cmdId');
                $prodId=$this->input->post('prodId');
                $quantite=$this->input->post('quantite');
                $prod=new OrderProductEntity;
                $prod->setCmdId($cmdId);
                $prod->setProdId($prodId);
                $prod->setQuantite($quantite);         
                $Order=$this->OrderProductModel->add($prod);
                $this->cache->file->clean();
                redirect('admin/pageAdminCommandeProduit_redirect/'.$cmdId);
            }
        } else {
            redirect("home");
        }
    }

    //Fonction qui redirige vers la page "modificationCommandeProduit"
    //en lui envoyant le produit correspondant a l'id rentrée en paramètre.
    function modification_CommandeProduit_redirect($prodId){
        if ( $_SESSION["user"]["Statut"]=="Admin") {
            $cmd=$this->OrderProductModel->findById($prodId);
            $cmdId=$cmd->getCmdId();
            $cmdquantite=$cmd->getQuantite();
            $data=array("cmdId"=>$cmdId,"prodId"=>$prodId,"quantite"=>$cmdquantite);
            $this->load->view('modificationCommandeProduit',$data);
        } else {
            redirect("home");
        }
    }

    //Fonction qui modifie les informations du produit dans la commande 
    //en fonction des informations rentrées dans la page "modificationCommandeProduit".
    function modification_CommandeProduit(){
        if ( $_SESSION["user"]["Statut"]=="Admin") {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('cmdId', 'cmdId','required');
            $this->form_validation->set_rules('prodId', 'prodId','required');
            $this->form_validation->set_rules('quantite', 'quantite','required');
           

            if ($this->form_validation->run() == FALSE){
                $id=$this->input->post('cmdId');
                $prodId=$this->input->post('prodId');
                redirect('admin/modificationCommandeProduit_redirect/'.$id,$prodId);
            }
            else{
                $prod=new OrderProductEntity;
                $cmdId=$this->input->post('cmdId');
                $prod->setCmdId($this->input->post('cmdId'));
                $prod->setProdId($this->input->post('prodId'));
                $prod->setQuantite($this->input->post('quantite'));
                $prod=$this->OrderProductModel->modification($prod);
                $this->cache->file->clean();
                redirect('admin/pageAdminCommandeProduit_redirect/'.$cmdId);
            }
        } else {
            redirect("home");
        }
    }

    

    //Fonction qui supprime un produit de sa commande en fonction de l'id de celui-ci
    function suppression_CommandeProduit($prodId){
        if ( $_SESSION['user']['Statut']=="Admin") {
            $cmd=$this->OrderProductModel->findById($prodId);
            $cmdId=$cmd->getCmdId();
            $res = $this->OrderProductModel->supprime($prodId);
            $this->cache->file->clean();
            redirect('admin/pageAdminCommandeProduit_redirect/'.$cmdId);
        } else {
            redirect("home");
        }
	}

    //Fonction cherchant si une adresse mail donnée est dans la bd
    //Si oui, elle affiche pageAdminClientRecherche avec les informations de l'utilisateur
    //Sinon, elle affiche la page précédente avec une erreur.
    function rechercheEmail(){
        if ( $_SESSION["user"]["Statut"]=="Admin"){
            $this->load->library('form_validation');
            $this->form_validation->set_rules('rechercheEmail', 'rechercheEmail','required|valid_email');

            if ($this->form_validation->run() == FALSE){
                $error="* Veuillez renseigner une email valide";
                $this->load->view('pageAdminClient',array("error"=>$error,"users"=>array()));
            }
            else {
                $email = $this->input->get('rechercheEmail');
                $user = $this->UserModel->findByEmail($email);
                if ($user!=null){
                    $data= array("users"=>$user);
                    $this->load->view('pageAdminClientRecherche',$data);
                }else{
                    $tousLesUsers = $this->UserModel->findAll();
                    $error1="* Pas d'adresse mail reconnue";
                    $this->load->view('pageAdminClient',array("error"=>$error1,"users"=>$tousLesUsers));
                }
            }
    }
    }

    //Fonction qui retourne tous les produits de la catégorie demandée dans un tableau
    function categorie(int $categ){
        if ( $_SESSION["user"]["Statut"]=="Admin"){
            $products = $this->ProductModel->findByCateg($categ);
            $data = array("prods"=>$products);
            $this->load->view("pageAdminProduit",$data);
        }else{
            redirect("home");
        }
    }

}