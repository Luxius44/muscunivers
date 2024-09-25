<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ProductEntity
{

    private $ProdID;
    private $ProdNom;
    private $ProdDesc;
    private $Stock;
    private $Prix;
    private $ProdCat;

    
    public function getProdId()
    {
        return $this->ProdID;
    }

   
    public function setProdId(Int $Id)
    {
        $this->ProdID = $Id;
    }

    public function getProdNom()
    {
        return $this->ProdNom;
    }

    
    public function setProdNom($Nom)
    {
        $this->ProdNom =$Nom;
    }

    
    public function getProdDesc()
    {
        return $this->ProdDesc;
    }

   
    public function setProdDesc(string $Desc)
    {
        $this->ProdDesc = $Desc;
    }

    public function getStock()
    {
        return $this->Stock;
    }

    public function setStock($stock)
    {
        $this->Stock = $stock;
    }

    public function getPrix()
    {
        return $this->Prix;
    }
    
    public function setPrix($prix)
    {
        $this->Prix = $prix;
    }

    public function getCatId()
    {
        return $this->ProdCat;
    }

   
    public function setCatId(Int $Catid)
    {
        $this->ProdCat = $Catid;
    }
}