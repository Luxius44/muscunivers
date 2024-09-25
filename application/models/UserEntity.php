<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class UserEntity
{

    private $CliId;
    private $Email;
    private $CliNom;
    private $CliPrenom;
    private $CliMotDePasse;
    private $CliDateDeNaissance;
    private $CompteVerifie;
    private $Panier;
    private $Statut;
    
    public function isValidPassword(string $password):bool {
        return password_verify($password,$this->CliMotDePasse);
    }

    
    public function getCliId()
    {
        return $this->CliId;
    }

   
    public function setCliId(Int $Id)
    {
        $this->CliId = $Id;
    }

    public function getEmail()
    {
        return $this->Email;
    }

    
    public function setEmail($email)
    {
        $this->Email =$email;
    }

    
    public function getCliNom()
    {
        return $this->CliNom;
    }

   
    public function setClinom(string $Clinom)
    {
        $this->CliNom = $Clinom;
    }

    public function getCliPrenom()
    {
        return $this->CliPrenom;
    }

   
    public function setCliPrenom(string $Cliprenom)
    {
        $this->CliPrenom = $Cliprenom;
    }

    public function getCliPassword()
    {
        return $this->CliMotDePasse;
    }

    public function setClipassword($CliPassword)
    {
        $this->CliMotDePasse = $CliPassword;
    }

    public function getCliDateDeNaissance()
    {
        return $this->CliDateDeNaissance;
    }
    
    public function setCliDateDeNaissance($CliDateDeNaissance)
    {
        $this->CliDateDeNaissance = $CliDateDeNaissance;
    }

    public function getCompteVerifie() {
        return $this->CompteVerifie;
    }

    public function setCompteVerifie(bool $bool) {
        $this->CompteVerifie=$bool;
    }

    public function getPanier() {
        return $this->Panier;
    }

    public function setPanier(string $cookie) {
        $this->Panier=$cookie;
    }

    public function getStatut() {
        return $this->Statut;
    }

    public function setStatut(string $statut) {
        $this->statut=$statut;
    }

}
