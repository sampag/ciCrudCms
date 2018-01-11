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

	public function index()
	{
		
			$comment_count = $this->db->count_all('comment');
			if($comment_count > 1){
				$comment = heading('Comments', 4);
				$count = '<span class="badge badge-danger">'.$comment_count.'</span> Items';
			}else{
				$comment = heading('Comment', 4);
				$count = '<span class="badge badge-danger">'.$comment_count.'</span> Item';
			}

			$data = array(
				'header' => $this->load->view('admin/header','', TRUE),
				'javascript' => $this->load->view('admin/javascript','', TRUE),
				'comments' => $this->comment_model->get_all(),
				'comment' => $comment,
				'count' => $count,
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

	public function comment_approved($id)
	{
		

			$id = $this->uri->segment(3);

			$status = array(
				'comment_approved' => TRUE,
			);

			$this->comment_model->approved($id, $status);

			redirect('admin/comment');

		
	}

}