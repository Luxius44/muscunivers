<?php

require_once APPPATH . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . "OrderProductEntity.php";

class OrderProductModel extends CI_Model
{
	public function remplirCommande(int $id){
        if ( isset($_SESSION["panier_achat"])){
            foreach ($_SESSION["panier_achat"] as $product) {
                $data=array('CmdId'=>$id,'ProdID'=>$product['id'],'Quantite'=>$product['qtd']);
                try{
                    $db_debug=$this->db->db_debug;
                    //$this->db->db_debug = FALSE;
                    $this->db->insert('ProduitCommander',$data);
                    $this->db->db_debug=$db_debug;
                }catch(Exception $e){};
            }
        }
    }

    function findAll(int $cmdId):array{
        $this->db->select('*');
		$q = $this->db->get_where('ProduitCommander',array('CmdId'=>$cmdId));
		$response = $q-> custom_result_object("OrderProductEntity");
		return $response;
    }

    function findById($id){
        $this->db->select('*');
		$q = $this->db->get_where('ProduitCommander',array('ProdId'=>$id));
		$response = $q->row(0,"OrderProductEntity");
		return $response;
    }

    function add(OrderProductEntity $prod){
        $cmdId=$prod->getCmdId();
        $prodId=$prod->getProdID();
        $quantite=$prod->getQuantite();
        $data=array('CmdId'=>$cmdId,'ProdID'=>$prodId,'Quantite'=>$quantite);
                try{
                    $db_debug=$this->db->db_debug;
                    //$this->db->db_debug = FALSE;
                    $this->db->insert('ProduitCommander',$data);
                    $this->db->db_debug=$db_debug;
                }catch(Exception $e){};

    }

    function modification(OrderProductEntity $prod){
        $cmdId=$prod->getCmdId();
        $prodId=$prod->getProdID();
        $quantite=$prod->getQuantite();
        $data=array('CmdId'=>$cmdId,'ProdID'=>$prodId,'Quantite'=>$quantite);
        try{
			$db_debug=$this->db->db_debug;
			$this->db->db_debug = FALSE;
			$this->db->set($data);
			$this->db->where('ProdID',$prodId);
			$this->db->update('ProduitCommander');
			$this->db->db_debug=$db_debug;
		}catch(Exception $e){}
    }

    function supprime(int $id):bool{
		$this->db->delete('ProduitCommander',array('ProdId' => $id));
		return $this->db->affected_rows()!=0;
	}

    function supprimeByCmdId($cmdId){
        $this->db->delete('ProduitCommander',array('CmdID' => $cmdId));
		return $this->db->affected_rows()!=0;
    }
}
