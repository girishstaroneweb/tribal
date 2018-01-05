<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
	function __construct()
	{
	  	parent::__construct();
	  	$this->load->model('alldata','model'); 
	}
	public function index()
	{
		$this->load->view('header.php');
		$this->load->view('dashboard.php');
		$this->load->view('footer.php');
	}
}
