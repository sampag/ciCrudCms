<?php
defined('BASEPATH')OR exit('No direct script access allowed');

class System extends CI_Controller{

	public function __construct()
	{
		parent::__construct();

		//Check if admin
		if(! $this->ion_auth->is_admin() ){
			redirect('login');
		}
	}

	public function index()
	{	
		$attr_php = array(
			'src'   => 'assets/img/logo/350-x-200/php.png',
			'class' => 'img-responsive',
		);
		$php = img($attr_php);

		$attr_ci = array(
			'src'   => 'assets/img/logo/350-x-200/ci.png',
			'class' => 'img-responsive',
		);
		$ci = img($attr_ci);

		$attr_bs = array(
			'src'   => 'assets/img/logo/350-x-200/bs.png',
			'class' => 'img-responsive',
		);
		$bs = img($attr_bs);

		$attr_sql = array(
			'src'   => 'assets/img/logo/350-x-200/sql.png',
			'class' => 'img-responsive',
		);
		$sql = img($attr_sql);

		$data = array(
			'header'     => $this->load->view('admin/header', '', TRUE),
			'php'	     => $php,
			'ci'	     => $ci,
			'bs'	     => $bs,
			'sql'	     => $sql,
			'javascript' => $this->load->view('admin/javascript', '', TRUE),
			'footer'     => $this->load->view('admin/footer', '', TRUE),
		);

		$this->parser->parse('admin/system', $data);
	}

}