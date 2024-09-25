<?php

#Controller 404 Error

class Errors extends CI_Controller {

    //Cette fonction affiche une page d'erreur 404 quand une page demandée par un client n'existe pas
    public function error404() {
        $this->output->set_status_header('404');
        $this->load->view('errors/custom404');
    }
    
}