<?php

require_once APPPATH . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . "ProductEntity.php";

require_once APPPATH . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . "OrderEntity.php";

class OrderModel extends CI_Model
{
	//Fonction qui recherche dans la bd toutes les commandes et donne un résultat sous forme de tableaux
    function findAll():array{
		$this->db->select('*');
		$q = $this->db->get('Commande');
		$response = $q-> custom_result_object("OrderEntity");
		return $response;
	}

	//Fonction qui recherche une commande dans la bd grace à son id.
	//Si elle n'existe pas, le resultat est null
    function findById($CmdId):?OrderEntity{
		$this->db->select('*');
		$q = $this->db->get_where('Commande',array('CmdId'=>$CmdId));
		$response = $q->row(0,"OrderEntity");
		return $response;
	}
    
	//Fonction qui crée une commande  et l'insert dans la bd
	//On donne un id aléatoire a la commande
	public function createCommande(int $id, string $adresse):?OrderEntity{
		$this->load->helper('date');
		$rand=random_int(1,999999999);
		while($this->UserModel->findById($rand)!=null){
				$rand=random_int(1,999999999);
			}
        $cmdId=$rand;
        $CliId=$id;
        $Date=now();
		$formatdate=date('Y-m-d H:i:s', $Date);
		$datefinal=str_replace("/", "-", $formatdate);
		$DateCommande=$datefinal;
        $AddresseLivraison=$adresse;
        $Statut="En Préparation";
        
        $cmd=new OrderEntity;
        $cmd->setCmdId($cmdId);
        $cmd->setCliId($CliId);
        $cmd->setDateCommande($DateCommande);
        $cmd->setAdresseLivraison($AddresseLivraison);
        $cmd->setStatut($Statut);
        
        $data=array('CmdId'=>$cmdId,'CliId'=>$CliId,'DateCommande'=>$DateCommande,'AddresseLivraison'=>$AddresseLivraison,'Statut'=>$Statut);
        try{
			$db_debug=$this->db->db_debug;
			//$this->db->db_debug = FALSE;
			$this->db->insert('Commande',$data);
			$this->db->db_debug=$db_debug;
		}catch(Exception $e){}
		return $cmd;
	}

	//Fonction modifiant les information d'une commande et met à jour la bd
	function modification_Commande(int $id,OrderEntity $cmd):? OrderEntity{
		$cliId = $cmd->getCliId();
		$date = $cmd->getDateCommande();
		$addresse = $cmd->getAdresseLivraison();
		$statut = $cmd->getStatut();
		$data = array('CmdId' => $id,'CliId' => $cliId,'DateCommande'=> $date,'AddresseLivraison'=> $addresse,'Statut'=>$statut);
		try{
			$db_debug=$this->db->db_debug;
			$this->db->db_debug = FALSE;
			$this->db->set($data);
			$this->db->where('CmdId',$id);
			$this->db->update('Commande');
			$this->db->db_debug=$db_debug;
		}catch(Exception $e){};
		return $this->findById($id);
	}

	//Fonction supprimant une commande de la bd
	function supprime($cmdId){
		$this->db->delete('Commande',array('CmdId' => $cmdId));
		return $this->db->affected_rows()!=0;
	}
    

}
