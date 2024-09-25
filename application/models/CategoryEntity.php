<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class CategoryEntity {
    private int $CatId;
    private string $CatNom;
    private string $CatDesc;

    public function getCatId () {
        return $this->$CatId;
    }

    public function getCatNom () {
        return $this->$CatNom;
    }

    public function getCatDesc() {
        return $this->$CatDesc;
    }

    public function setCatId (Int $NewCatId) {
        $this->$CatId=$NewCatId;
    }

    public function setCatNom (String $NewCatNom) {
        $this->$CatNom=$NewCatNom;
    }

    public function setCatDesc(Stirng $NewCatDesc) {
        $this->$CatDesc=$NewCatDesc;
    }


}