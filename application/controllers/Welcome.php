<?php

class Welcome extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
	}
	public function index()
	{
		if($this->session->username!='')
			redirect('home');
		else
			$this->load->view('welcome');
	}

}

?>