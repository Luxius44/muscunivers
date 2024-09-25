<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class OrderProductEntity {

    private $CmdId;
    private $ProdID;
    private $Quantite;

    public function getCmdId() {
        return $this->CmdId;
    }

    public function getProdID() {
        return $this->ProdID;
    }

    public function getQuantite() {
        return $this->Quantite;
    }

    public function setCmdId(Int $CmdId ) {
        $this->CmdId=$CmdId;
    }

    public function setProdId(int $ProdID) {
        $this->ProdID=$ProdID;
    }

    public function setQuantite(int $quantite) {
        $this->Quantite=$quantite;
    }

}