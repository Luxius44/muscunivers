<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {


	public function __construct()
	{
		parent::__construct();
		//Si besoin por debuguer
		//$this->output->enable_profiler(TRUE);
		$this->load->helper('url');
		$this->load->library('session');
	}

	public function index() {
		$this->load->view('home');
	}

	function musculation(){
		$this->load->view('musculation');
	}

	function fitness(){
		$this->load->view('fitness');
	}

	function complements(){
		redirect("Product/complements/1/1");
	}

	function apropos(){
		$this->load->view('apropos');
	}

	/*****************
		FOOTER
	*****************/

	function cgu(){
		$this->load->view('cgu');
	}

	function confidentialite(){
		$this->load->view('confidentialite');
	}

	function mentions(){
		$this->load->view('mentions');
	}
}