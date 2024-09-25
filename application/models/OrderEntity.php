<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class OrderEntity 
{

    private $CmdId;
    private $CliId;
    private $DateCommande;
    private $AddresseLivraison;
    private $Statut;
    

    public function getCmdId(){
        return $this->CmdId;
    }

    public function getCliId() {
        return $this->CliId;
    }

    public function getDateCommande() {
        return $this->DateCommande;
    }

    public function getAdresseLivraison() {
        return $this->AddresseLivraison;
    }

    public function getStatut() {
        return $this->Statut;
    }

    public function setCmdId(Int $NewCmdId ) {
        $this->CmdId=$NewCmdId;
    }

    public function setCliId(Int $NewCliId ) {
        $this->CliId=$NewCliId;
    }

    public function setDateCommande($NewDateCommande) {
        $this->DateCommande=$NewDateCommande;
    }

    public function setAdresseLivraison(String $NewAdresseLivraison) {
        $this->AddresseLivraison=$NewAdresseLivraison;
    }

    public function setStatut(String $NewStatut) {
        $this->Statut=$NewStatut;
    }

}