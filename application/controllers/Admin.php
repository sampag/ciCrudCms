<?php
defined('BASEPATH')OR exit('No direct script access allowed');


class Admin extends CI_Controller{

	public function __construct()
	{
		parent::__construct();

		if(! $this->ion_auth->is_admin() ){
			redirect('login');
		}
	}

	public function index()
	{	

		$user = $this->ion_auth->user()->row();
		$name =  $user->first_name;
		$message = 'Welcome '.$name;

		// For Comment
		if($this->db->count_all('comment') > 1){

			$comment_meter = 'Comments';

		}else{

			$comment_meter = 'Comment';

		}

		// For Category, Tag, Post
		if($this->db->count_all('category') > 1 && $this->db->count_all('tag') > 1 && $this->db->count_all('post') > 1){

			$category_meter = 'Categories';
			$tag_meter = 'Tags';
			$post_meter = 'Posts';
			
		}else{

			$category_meter = 'Category';
			$tag_meter = 'Tag';
			$post_meter = 'Post';
			
		}

		$data = array(
			'header' => $this->header(),
			'javascript' => $this->load->view('admin/javascript','', TRUE),
			'footer' => $this->load->view('admin/footer','', TRUE),
			'user' => heading($message, 3),
			'recent_posts' => $this->post_model->recent_post(),
			'tag_count' => $this->db->count_all('tag'),
			'tag_meter' => $tag_meter,
			'cat_count' => $this->db->count_all('category'),
			'cat_meter' => $category_meter,
			'post_count' => $this->db->count_all('post'),
			'post_meter' => $post_meter,
			'comment_count' => $this->db->count_all('comment'),
			'comment_meter' => $comment_meter,
		);

		$this->parser->parse('admin/main', $data);
	}

	private function header()
	{	
		$setting = $this->settings_model->site_settings();

		$data = array(
				'site_title' => $setting->title,
			);

		$this->parser->parse('admin/header', $data);
	}


}