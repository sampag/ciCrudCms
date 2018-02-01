<?php
defined('BASEPATH')OR exit('No direct script access allowed');

class Post_group_admin extends CI_Controller{

	public function __construct()
	{
		parent::__construct();

		if(! $this->ion_auth->is_admin() ){
			redirect('login');
		}
	}

	private function error_page()
	{
		$this->load->view('admin/header');
		$this->load->view('admin/error');
		$this->load->view('admin/javascript');
		$this->load->view('admin/footer');
	}

	private function header()
	{	
		$this->load->view('admin/header');
	}

	/*
	* Sub header for group post
	*/
	private function pills_header()
	{	
		$user            = $this->ion_auth->user()->row();
		$count_all		 = $this->post_model->countAll();
		$count_mine      = $this->post_model->countMine($user->id);
		$count_published = $this->post_model->countPublished();
		$count_trash     = $this->post_model->countTrash();

		$data = array(
			'count_all'       => $count_all,
			'count_mine'      => $count_mine,
			'count_published' => $count_published,
			'count_trash'     => $count_trash,
		);

		$this->load->view('admin/group_header', $data);
	}
	/**
	* Restore multiple post
	*/
	public function restore_multiple()
	{
		$group              = $this->uri->segment(3);
		$page               = $this->uri->segment(4);
		$restore            = $this->input->post('restore', TRUE);
		$post               = $this->input->post('post', TRUE);

		if($restore){
			foreach($post as $id){
				$this->post_model->restoreMultiplePost($id); // Restore handler
			}

			if(is_numeric($page)){
				redirect('admin/post-list/'.$group.'/'.$page);
			}else{
				redirect('admin/post-list/'.$group);
			}
		}else{
			if(is_numeric($page)){
				redirect('admin/post-list/'.$group.'/'.$page);
			}else{
				redirect('admin/post-list/'.$group);
			}
		} // Restore
	}

	/*
	* Trash multiple post function
	*/
	public function trash_multiple()
	{
		$id          = $this->input->post('post_trash');
		$group       = $this->uri->segment(3);
		$page        = $this->uri->segment(4);
		$list        = $this->uri->segment(2);

		if($this->input->post('postTrash')){
			foreach($id as $i){
				$this->post_model->trashMultiplePost($i);
			}

			if(is_numeric($page)){
				redirect('admin/'.$list.'/'.$group.'/'.$page);
				
			}else{
				redirect('admin/'.$list.'/'.$group);
			}
		}else{
			if(is_numeric($page)){
				redirect('admin/'.$list.'/'.$group.'/'.$page);
			}else{
				redirect('admin/'.$list.'/'.$group);
			}
		}
	}

	/*
	* Group trash post
	*/
	public function trash()
	{
		$per_page = ( $this->uri->segment(4) ) ? $this->uri->segment(4): 0;

		$config = array(
			'base_url'        =>     base_url('admin/post-list/trash'),
			'total_rows'      => 	 $this->post_model->countTrash(),
			'per_page'        =>     8,
			'uri_segment'     =>     4,
			'last_link'       =>     false,
			'first_link'      =>     false,
			'prev_link'       =>     '<span aria-hidden="true">&laquo;</span>',
			'next_link'       =>     '<span aria-hidden="true">&raquo;</span>',
			'full_tag_open'   =>     '<ul class="pagination pagination-sm">',
			'full_tag_close'  =>     '</ul>',
			'first_tag_open'  =>     '<li>',
			'first_tag_close' =>   	 '</li>',
			'last_tag_open'   =>     '<li>',
			'last_tag_close'  =>     '</li>',
			'next_tag_open'   =>     '<li>',
			'next_tag_close'  =>     '</li>',
			'prev_tag_open'   =>     '<li>',
			'prev_tag_close'  =>     '</li>',
			'cur_tag_open'    =>     '<li class="active"><span>',
			'cur_tag_close'   =>     '</span></li>',
			'num_tag_open'    =>     '<li>',
			'num_tag_close'   =>     '</li>',
		);

		$this->pagination->initialize($config);
		$trash_data = $this->post_model->getTrash($config['per_page'], $per_page);

		if(! $trash_data){
			$data = array(
				'header'       => $this->header(),
				'pills_header' => $this->pills_header(),
				'item' 		   => $trash_data,
				'pagination'   => $this->pagination->create_links(),
				'javascript'   => $this->load->view('admin/javascript', '', TRUE),
				'footer'       => $this->load->view('admin/footer', '', TRUE),
			);

			$this->parser->parse('admin/group_trash', $data);
		}else{
			$data = array(
				'header'       => $this->header(),
				'pills_header' => $this->pills_header(),
				'item' 		   => $trash_data,
				'pagination'   => $this->pagination->create_links(),
				'javascript'   => $this->load->view('admin/javascript', '', TRUE),
				'footer'       => $this->load->view('admin/footer', '', TRUE),
			);

			$this->parser->parse('admin/group_trash', $data);
		}
	}

	/*
	* Group all post
	*/

	public function all()
	{
		$per_page = ( $this->uri->segment(4) ) ? $this->uri->segment(4): 0;

		$config = array(
			'base_url'        =>     base_url('admin/post-list/all'),
			'total_rows'      => 	 $this->post_model->countAll(),
			'per_page'        =>     8,
			'uri_segment'     =>     4,
			'last_link'       =>     false,
			'first_link'      =>     false,
			'prev_link'       =>     '<span aria-hidden="true">&laquo;</span>',
			'next_link'       =>     '<span aria-hidden="true">&raquo;</span>',
			'full_tag_open'   =>     '<ul class="pagination pagination-sm">',
			'full_tag_close'  =>     '</ul>',
			'first_tag_open'  =>     '<li>',
			'first_tag_close' =>   	 '</li>',
			'last_tag_open'   =>     '<li>',
			'last_tag_close'  =>     '</li>',
			'next_tag_open'   =>     '<li>',
			'next_tag_close'  =>     '</li>',
			'prev_tag_open'   =>     '<li>',
			'prev_tag_close'  =>     '</li>',
			'cur_tag_open'    =>     '<li class="active"><span>',
			'cur_tag_close'   =>     '</span></li>',
			'num_tag_open'    =>     '<li>',
			'num_tag_close'   =>     '</li>',
		);

		$this->pagination->initialize($config);
		$all_data = $this->post_model->getAll($config['per_page'], $per_page);

		if(! $all_data){
			$data = array(
				'header'       => $this->header(),
				'pills_header' => $this->pills_header(),
				'item' 		   => $this->post_model->getAll($config['per_page'], $per_page),
				'pagination'   => $this->pagination->create_links(),
				'javascript'   => $this->load->view('admin/javascript', '', TRUE),
				'footer'       => $this->load->view('admin/footer', '', TRUE),
			);

			$this->parser->parse('admin/group_all', $data);
		}else{
			$data = array(
				'header'       => $this->header(),
				'pills_header' => $this->pills_header(),
				'item' 		   => $all_data,
				'pagination'   => $this->pagination->create_links(),
				'javascript'   => $this->load->view('admin/javascript', '', TRUE),
				'footer'       => $this->load->view('admin/footer', '', TRUE),
			);

			$this->parser->parse('admin/group_all', $data);
		}
	}

	/*
	* Group by users post
	*/
	public function mine()
	{	

		$per_page = ( $this->uri->segment(4) ) ? $this->uri->segment(4): 0;
		$user       = $this->ion_auth->user()->row();
		
		$config = array(
			'base_url'        =>     base_url('admin/post-list/mine/'),
			'total_rows'      => 	 $this->post_model->countMine($user->id),
			'per_page'        =>     8,
			'uri_segment'     =>     4,
			'last_link'       =>     false,
			'first_link'      =>     false,
			'prev_link'       =>     '<span aria-hidden="true">&laquo;</span>',
			'next_link'       =>     '<span aria-hidden="true">&raquo;</span>',
			'full_tag_open'   =>     '<ul class="pagination pagination-sm">',
			'full_tag_close'  =>     '</ul>',
			'first_tag_open'  =>     '<li>',
			'first_tag_close' =>   	 '</li>',
			'last_tag_open'   =>     '<li>',
			'last_tag_close'  =>     '</li>',
			'next_tag_open'   =>     '<li>',
			'next_tag_close'  =>     '</li>',
			'prev_tag_open'   =>     '<li>',
			'prev_tag_close'  =>     '</li>',
			'cur_tag_open'    =>     '<li class="active"><span>',
			'cur_tag_close'   =>     '</span></li>',
			'num_tag_open'    =>     '<li>',
			'num_tag_close'   =>     '</li>',
		);

		$this->pagination->initialize($config);
		$mine_data = $this->post_model->getMine($config['per_page'], $per_page, $user->id);

		if(! $mine_data){
			$data = array(
				'header'       => $this->header(),
				'pills_header' => $this->pills_header(),
				'item'         => $mine_data,
				'pagination'   => $this->pagination->create_links(),
				'javascript'   => $this->load->view('admin/javascript', '', TRUE),
				'footer'       => $this->load->view('admin/footer', '', TRUE),

			);

			$this->parser->parse('admin/group_mine', $data);
		}else{
			$data = array(
				'header'       => $this->header(),
				'pills_header' => $this->pills_header(),
				'item'         => $mine_data,
				'pagination'   => $this->pagination->create_links(),
				'javascript'   => $this->load->view('admin/javascript', '', TRUE),
				'footer'       => $this->load->view('admin/footer', '', TRUE),

			);

			$this->parser->parse('admin/group_mine', $data);
		}
	}

	/*
	* Group published post
	*/

	public function published()
	{
		$per_page = ( $this->uri->segment(4) ) ? $this->uri->segment(4): 0;
		
		$config = array(
			'base_url'        =>     base_url('admin/post-list/published/'),
			'total_rows'      => 	 $this->post_model->countPublished(),
			'per_page'        =>     8,
			'uri_segment'     =>     4,
			'last_link'       =>     false,
			'first_link'      =>     false,
			'prev_link'       =>     '<span aria-hidden="true">&laquo;</span>',
			'next_link'       =>     '<span aria-hidden="true">&raquo;</span>',
			'full_tag_open'   =>     '<ul class="pagination pagination-sm">',
			'full_tag_close'  =>     '</ul>',
			'first_tag_open'  =>     '<li>',
			'first_tag_close' =>   	 '</li>',
			'last_tag_open'   =>     '<li>',
			'last_tag_close'  =>     '</li>',
			'next_tag_open'   =>     '<li>',
			'next_tag_close'  =>     '</li>',
			'prev_tag_open'   =>     '<li>',
			'prev_tag_close'  =>     '</li>',
			'cur_tag_open'    =>     '<li class="active"><span>',
			'cur_tag_close'   =>     '</span></li>',
			'num_tag_open'    =>     '<li>',
			'num_tag_close'   =>     '</li>',
		);

		$this->pagination->initialize($config);
		$published_data = $this->post_model->getPublished($config['per_page'], $per_page);

		if(! $published_data){
			$data = array(
				'header'       => $this->header(),
				'pills_header' => $this->pills_header(),
				'item'    	   => $published_data,
				'pagination'   => $this->pagination->create_links(),
				'javascript'   => $this->load->view('admin/javascript', '', TRUE),
				'footer'       => $this->load->view('admin/footer', '', TRUE),

			);

			$this->parser->parse('admin/group_published', $data);
		}else{
			$data = array(
				'header'       => $this->header(),
				'pills_header' => $this->pills_header(),
				'item'    	   => $published_data,
				'pagination'   => $this->pagination->create_links(),
				'javascript'   => $this->load->view('admin/javascript', '', TRUE),
				'footer'       => $this->load->view('admin/footer', '', TRUE),

			);

			$this->parser->parse('admin/group_published', $data);
		}
	}




} // end of class