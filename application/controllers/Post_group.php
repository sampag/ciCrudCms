<?php
defined('BASEPATH')OR exit('No direct script access allowed');

class Post_group extends CI_Controller{

	public function __construct()
	{
		parent::__construct();

		if(! $this->ion_auth->is_admin() ){
			redirect('login');
		}
	}

	public function mine()
	{	
		$user       = $this->ion_auth->user()->row();
		$mine       = $this->post_model->getMine($user->id);
		$count_mine = $this->post_model->countMine($user->id);

		$ghead_data = array(
			'count_mine'   => '<span class="badge badge-danger">'.$count_mine.'</span>',
		);

		$data = array(
			'header'       => $this->load->view('admin/header', '', TRUE),
			'group_header' => $this->load->view('admin/group_header', $ghead_data, TRUE),
			'mine'         => $mine,
			'javascript'   => $this->load->view('admin/javascript', '', TRUE),
			'footer'       => $this->load->view('admin/footer', '', TRUE),

		);

		$this->parser->parse('admin/group_mine', $data);
	}



}