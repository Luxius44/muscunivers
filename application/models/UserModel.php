<?php

require_once APPPATH . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . "UserEntity.php";

class UserModel extends CI_Model
{
	// Fonction qui renvoie tous les Users de la BD dans un array.
	function findAll():array{
		$this->db->select('*');
		$q = $this->db->get('Client');
		$response = $q-> custom_result_object("UserEntity");
		return $response;
	}

	// Fonction qui renvoie un User par rapport à l'émail
	// renseigné si il exsite, sinon renvoi null.
	function findByEmail($email):?UserEntity{
		$this->db->select('*');
		$q = $this->db->get_where('Client',array('Email'=>$email));
		$response = $q->row(0,"UserEntity");
		return $response;
	}

	// Fonction qui renvoie un User par rapport à l'Id
	// renseigné si il exsite, sinon renvoi null.
	function findById($id):?UserEntity{
		$this->db->select('*');
		$q = $this->db->get_where('Client',array('CliId'=>$id));
		$response = $q->row(0,"UserEntity");
		return $response;
	}
	
	//Fonction qui créé un User et rentre ses informations dans la base de donnée.
	//La fonction renvoie le User créé ou null si la bd renvoie une erreur.
	function add(UserEntity $client):?UserEntity{
		$nom = $client->getCliNom();
		$prenom = $client->getCliPrenom();
		$date = $client->getCliDateDeNaissance();
		$email = $client->getEmail();
		$password = $client->getCliPassword();
		$Id = $client->getCliId();
		$Panier = "";
		$CompteVerifie = false;
		$data = array('CliNom' => $nom,'CliPrenom' => $prenom,'CliDateDeNaissance'=> $date,'email'=> $email,'CliMotDePasse'=>$password,'CliId'=>$Id, 'Panier'=>$Panier, 'CompteVerifie'=>$CompteVerifie,'Statut'=>'Client');
		try{
			$db_debug=$this->db->db_debug;
			$this->db->db_debug = FALSE;
			$this->db->insert('Client',$data);
			$this->db->db_debug=$db_debug;
		}catch(Exception $e){}
		return $client;
	}

	//Fonction qui permet de mettre à jour les informations des clients
	//Le try catch est utilisé pour éviter les erreurs de la bd
	function modification_Client($id,UserEntity $client):? UserEntity{
		$nom = $client->getCliNom();
		$email = $client->getEmail();
		$prenom = $client->getCliPrenom();
		$date = $client->getCliDateDeNaissance();
		$password = $client->getCliPassword();
		$compteVerif = $client->getCompteVerifie();
		$panier = $client->getPanier();
		$data = array('CliNom' => $nom,'CliPrenom' => $prenom,'CliDateDeNaissance'=> $date,'email'=> $email,'CliMotDePasse'=>$password,'CliId'=>$id,'CompteVerifie'=>$compteVerif,'Panier'=>$panier);
		$data2 = $client; 
		try{
			$db_debug=$this->db->db_debug;
			$this->db->db_debug = FALSE;
			$this->db->set($data); 
			$this->db->set($data2); 
			$this->db->where('CliId',$id);
			$this->db->update('Client');
			$this->db->db_debug=$db_debug;
		}catch(Exception $e){}
		return $this->findById($id);
	}

	// Fonction qui formate la variable de session panier en string,
	// et envoie le résultat sur la BD.
	function EnvoieCookie() {
		$temp="";
		foreach ($_SESSION['panier'] as $product) {
			$temp=$temp.$product['id'].",".$product['qtd']."/";
		}
		$data=array('Panier'=>$temp);
		$this->db->set($data);
		$this->db->where('CliId',$_SESSION['user']['id']);
		$this->db->update('Client');
	}

	// Fonction qui récupère le Panier d'un User dans la BD, 
	// format la string obtenue pour la mettre en array,
	// met l'array dans une variable de session du user
	// et met le Panier du User dans la BD à null.
	function RecupCookie(UserEntity $user) {
		$temp=$user->getPanier();
		$temp=explode("/",$temp);
		$panier=array();

		for ($i=0; $i <count($temp)-1 ; $i++) { 
			$temp2=explode(",",$temp[$i]);
			$panier[]=array("id"=>$temp2[0],"qtd"=>$temp2[1]);
		}

		$_SESSION['panier']=$panier;

		$data=array('Panier'=>"");
		try {
		$db_debug=$this->db->db_debug;
		$this->db->db_debug = FALSE;
		$this->db->set($data);
		$this->db->where('CliId',$_SESSION['user']['id']);
		$this->db->update('Client');
		$db_debug=$this->db->db_debug;
		}catch(Exception $e){};
	}

	// Supprime le Client associé à l'Id si il existe.
	function supprime(int $id):bool{
		$this->db->delete('Client',array('CliId' => $id));
		return $this->db->affected_rows()!=0;
	}
}