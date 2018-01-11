<?php
defined('BASEPATH')OR exit('No direct script access allowed');

class Csrf extends CI_Controller{

	public function __construct()
	{
		parent::__construct();

		if(! $this->ion_auth->is_admin() ){

			redirect('login');
		}
		
	}

	public function index()
	{
	
		$csrf = array(
	        'name' => $this->security->get_csrf_token_name(),
	        'hash' => $this->security->get_csrf_hash()
		);
		$this->output
		->set_content_type('application/json')
		->set_output(json_encode($csrf));
		
	}

}