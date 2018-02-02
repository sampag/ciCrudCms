<?php
defined('BASEPATH')OR exit('No direct script access allowed');

class Comment extends CI_Controller{

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

	public function index()
	{
			$per_page = ( $this->uri->segment(3) ) ? $this->uri->segment(3): 0;
			$comment_count = $this->comment_model->count_admin_comment();

			$config = array(
				'base_url'        =>     base_url('admin/comment'),
				'total_rows'      => 	 $comment_count,
				'per_page'        =>     6,
				'uri_segment'     =>     3,
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
			$comment_item = $this->comment_model->get_all($config['per_page'], $per_page);

			if(! $comment_item){
				return $this->error_page();
			}

			if($comment_count > 1){
				$comment = heading('Comment', 4);
				$count = '<span class="badge badge-danger">'.$comment_count.'</span> Items';
			}else{
				$comment = heading('Comment', 4);
				$count = '<span class="badge badge-danger">'.$comment_count.'</span> Item';
			}

			$data = array(
				'header' => $this->load->view('admin/header','', TRUE),
				'javascript' => $this->load->view('admin/javascript','', TRUE),
				'comments' => $comment_item,
				'comment' => $comment,
				'count' => $count,
				'pagination'   => $this->pagination->create_links(),
				'footer' => $this->load->view('admin/footer','', TRUE),
			);

			$this->parser->parse('admin/comment', $data);

	}

	public function comment_delete($id)
	{
	
			$id = $this->uri->segment(3);
			$this->comment_model->delete($id);
			redirect('admin/comment/');
		
	}

	public function comment_approved($comment_id)
	{
		$comment_id = $this->uri->segment(4);
		$group      = $this->uri->segment(2);

		$status = array(
			'comment_approved' => TRUE,
		);

		$approved = $this->comment_model->approved($comment_id, $status);

		if($approved){
			$this->comment_model->approved($comment_id, $status);
			redirect('admin/'.$group);
		}else{
			redirect('admin/'.$group);
		}

	}

	public function comment_approved_paginated($comment_id)
	{
		$comment_id    = $this->uri->segment(5);
		$group         = $this->uri->segment(2);
		$page          = $this->uri->segment(3);

		$status = array(
			'comment_approved' => TRUE,
		);

		$approved =	$this->comment_model->approved($comment_id, $status);

		if($approved){
			$this->comment_model->approved($comment_id, $status);

			redirect('admin/'.$group.'/'.$page);
		}else{
			redirect('admin/'.$group.'/'.$page);
		}
		
	}

}