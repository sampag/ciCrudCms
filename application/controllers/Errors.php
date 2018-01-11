<?php
defined('BASEPATH')OR exit('No direct script access allowed');

class Errors extends CI_Controller{

	public function __construct()
	{
		parent::__construct();

		if(! $this->ion_auth->is_admin()){
			redirect('login');
		}
	}

	public function index()
	{
		return $this->error_page();
		
	}

	private function error_page()
	{
		
		$this->load->view('admin/header');
		$this->load->view('admin/error');
		$this->load->view('admin/javascript');
		$this->load->view('admin/footer');
	}
}