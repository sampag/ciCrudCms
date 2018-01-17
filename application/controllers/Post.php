<?php
defined('BASEPATH')OR exit('No direct script access allowed');

class Post extends CI_Controller{

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

		$data = array(
			'header' => $this->load->view('admin/header','', TRUE),
			'categories' => $this->category_model->get_all(),
			'tags' => $this->tag_model->get_all(),
			'javascript' => $this->load->view('admin/javascript','', TRUE),
			'summernotejs' => '<script src="'.base_url('assets/libs/summernote/summernote.min.js').'"></script>',
			'footer' => $this->load->view('admin/footer','', TRUE),
		);

		$this->parser->parse('admin/post', $data);
	}

	// Update
	public function post_update($random_id_slug)
	{	
		$random_id_slug = $this->uri->segment(3);

		// Upload Image
		$config = array(
				'encrypt_name' => TRUE,
				'upload_path' => './assets/img/featured-img',
				'allowed_types' => 'png|jpg',
				'max_size' => '1000',
			);

		$this->upload->initialize($config);

		$rules = array(
			array(
				'field' => 'edit_post_title',
				'label' => 'Title',
				'rules' => 'required|strip_tags'
			),
			array(
				'field' => 'edit_post_content',
				'label' => 'Content',
				'rules' => 'strip_tags'
			),
		);

		$this->form_validation->set_rules($rules);

		if($this->form_validation->run() === FALSE){
			$this->session->set_flashdata('post_update_failed', validation_errors('<li><strong>Error </strong>', '</li>'));
			redirect('admin/post-edit/'.$random_id_slug);
		}else{

			//=====================================//
			$category = $this->input->post('edit_post_category', TRUE);
			//=====================================//
			if(! $category ){
				$post_uncategorized = 'uncategorized';
			}else{
				$post_uncategorized = NULL;
			}

			if($category == '0'){
				$post_uncategorized = 'uncategorized';
			}else{
				$post_category_id = $this->input->post('edit_post_category', TRUE);
			}

			$upload_feat_img = $this->upload->do_upload('edit_featured_img');
			
			$post = $this->post_model->get_single($random_id_slug);

			if(! $upload_feat_img){
				$post_featured_img = $post->post_featured_img;
			}else{
				$this->post_delete_featured_img($post->post_featured_img);
				$post_featured_img = $this->upload->data('file_name');
			}

			//=====================================//

			$title   = strip_tags(ucfirst($this->input->post('edit_post_title', TRUE)));   // Strip_Tag
			$content = strip_tags(ucfirst($this->input->post('edit_post_content', TRUE))); // Strip_Tag

			$data = array(
				'post_title'              => $title,
				'post_content'            => $content,
				'post_slug'               => url_title($title,'dash', TRUE), 
				'post_category_id'        => $post_category_id,
				'post_uncategorized_slug' => $post_uncategorized,
				'post_featured_img'       => $post_featured_img,
				'post_published'          => $this->input->post('edit_post_published', TRUE),
			);

			//=====================================//
			$user = $this->ion_auth->user()->row();

			if(! $post){
				redirect('admin/post-edit/'.$random_id_slug);
			}else{
				$id = $post->post_id;
			}

			$this->post_model->update_single($data, $id, $user->id);
			//=====================================//
			// Insert batch for post tags.
			$post_term_data = $this->input->post('edit_post_tag');
			
			$randomSlug = $this->post_model->get_single($random_id_slug); // By random ID.
			if(! $post_term_data){
				// Delete tag item
				$this->post_term_model->delete_item($randomSlug->post_id); 	
			}else{
				// Delete tag item
				$this->post_term_model->delete_item($randomSlug->post_id); 

				// Insert new
				$post_term = array();
					foreach($post_term_data as $key => $value){
						$post_term[$key]['term_tag_id']  = $value;
						$post_term[$key]['term_post_id'] = $randomSlug->post_id;
						$post_term[$key]['term_user_id'] = $user->id;
						$post_term[$key]['term_created'] = time();
					}

				$this->post_term_model->insert_tag($post_term);
			}
			//=======================================//
			$this->session->set_flashdata('post_update_success', '<li><strong>Successfully </strong> updated!</li>');
			redirect('admin/post-edit/'.$random_id_slug);
			//=====================================//
		}
	}

	// This function is for post_update only
	private function post_update_featured_img($img)
	{
		$config['image_library'] = 'gd2';
		$config['source_image'] = './assets/img/featured-img/'.$img;
		$config['quality'] = '100%';
		$config['maintain_ratio'] = TRUE;
		$config['new_image']    = './assets/img/featured-img';
		$config['width']         = 1500;
		$config['height']       = 1000;

		$this->image_lib->initialize($config);

		if ( ! $this->image_lib->resize())
		{	
			$resize = $this->image_lib->display_errors();	
		    $this->session->set_flashdata('resize_fail', $resize); 
		}else{
			$this->image_lib->resize();
		}
	}
	
	// This function is for post_update only 
	private function post_delete_featured_img($img)
	{		
		$feat_1500_x_1000 = 'assets/img/featured-img/1500-x-1000/'.$img;
		
		if(is_file($feat_1500_x_1000)){
			unlink($feat_1500_x_1000);
		}

		$feat_orig = 'assets/img/featured-img/'.$img;
		
		if(is_file($feat_orig)){
			unlink($feat_orig);
		}
			
	}


	// Add new entry in post.
	public function post_add()
	{
		$config = array(
				'encrypt_name' => TRUE,
				'upload_path' => './assets/img/featured-img',
				'allowed_types' => 'png|jpg',
				'max_size' => '1000',
				'max_width' => '1500',
				'max_height' => '1000',
			);

		$this->upload->initialize($config);

	    $this->upload->do_upload('post_featured_img');

		// Rules of object.
		$post_rules = array(
			array(
				'field' => 'post_title',
				'label' => 'Post title',
				'rules' => 'required|strip_tags'
				),
			array(
				'field' => 'post_tag[]',
				'label' => 'Post tag',
				'rules' => 'strip_tags'
				),
		);

		$this->form_validation->set_rules($post_rules);

		// Validate
		if( $this->form_validation->run() == FALSE ){

			$this->session->set_flashdata('failed', validation_errors('<li><strong>Error </strong>', '</li>'));

			redirect('admin/post');
		}else{

			// Insert entry for post data.
			$category = $this->input->post('post_category', TRUE);

			if(! $category ){
				$post_category = 'uncategorized';
			}else{
				$post_category = NULL;
			}

			if($category == '0'){
				$post_category = 'uncategorized';
			}else{
				$post_category_id = $this->input->post('post_category', TRUE);
			}

			$random_key = random_string('alnum', 30);
			$user = $this->ion_auth->user()->row();

			$title = strip_tags(ucfirst($this->input->post('post_title', TRUE)));

			$post_data = array(
				'post_random_id'          => $random_key,
				'post_title'              => $title,
				'post_content'            => ucfirst($this->input->post('post_content', TRUE)),
				'post_slug'               => url_title($title, 'dash', TRUE),
				'post_category_id'        => $this->input->post('post_category', TRUE),
				'post_uncategorized_slug' => $post_category,
				'post_published'          => $this->input->post('post_published', TRUE),
				'post_featured_img'       => $this->upload->data('file_name'),
				'post_created'            => time(),
				'post_created_gmt'        => time(),
				'user_id'                 => $user->id,
			);

			$this->post_model->insert_new($post_data);

			// Insert batch for post tags.
			$post_term_data = $this->input->post('post_tag');
			if(! $post_term_data){
					
			}else{
				$post_term = array();
					foreach($post_term_data as $key => $value){
						$post_term[$key]['term_tag_id'] = $value;
						$post_term[$key]['term_post_id'] = $this->db->insert_id();
						$post_term[$key]['term_created'] = time();
					}

				$this->post_term_model->insert_tag($post_term);
			}
		
			$this->session->set_flashdata('post_success', '<li><strong>Successfully added!</strong> new post.</li>');

			$random_id = $random_key;
			redirect('admin/post-edit/'.$random_id);
		}
	}

	private function featured_img_1500_x_1000($file_name)
	{	
		// Resize feature image automatically
		$config['image_library'] = 'gd2';
		$config['source_image'] = './assets/img/featured-img/'.$file_name;
		$config['quality'] = '100%';
		$config['maintain_ratio'] = TRUE;
		$config['new_image']    = './assets/img/featured-img/1500-x-1000';
		$config['width']         = 1500;
		$config['height']       = 1000;

		
		$this->image_lib->initialize($config);

		if ( ! $this->image_lib->resize())
		{	
			$resize = $this->image_lib->display_errors();	
		    $this->session->set_flashdata('resize_fail', $resize); 
		}else{
			$this->image_lib->resize();
		}
	}


	public function delete_post_paginated($id)
	{
		$group = $this->uri->segment(3);
		$page  = $this->uri->segment(4);
		$id    = $this->uri->segment(6);

		if($page){
			$pagination = $page;
		}

		$post = $this->post_model->getById($id);
		if($post){
			$this->delete_feat_img_file($post->post_featured_img);
		}

		$this->post_term_model->delete_item($id);
		$this->post_model->delete_item($id);
		$this->post_model->delete_comment($id);
		
		redirect('admin/post-list/'.$group.'/'.$pagination);
	}

	public function delete_post_none_paginated()
	{
		$group = $this->uri->segment(3);
		$id    = $this->uri->segment(5);

		if($group){
			$by_group = $group;
		}

		$post = $this->post_model->getById($id);
		if($post){
			$this->delete_feat_img_file($post->post_featured_img);
		}

		$this->post_term_model->delete_item($id);
		$this->post_model->delete_item($id);
		$this->post_model->delete_comment($id);
		
		redirect('admin/post-list/'.$group);
	}	


	private function delete_feat_img_file($file_name)
	{	

		$file = 'assets/img/featured-img/'.$file_name;
		if(is_file($file)){
			unlink($file);
		}

		$file_1500_x_1000 = 'assets/img/featured-img/1500-x-1000/'.$file_name;
		if(is_file($file_1500_x_1000)){
			unlink($file_1500_x_1000);
		}
			
	}

	private function error_page()
	{
		$this->load->view('admin/header');
		$this->load->view('admin/error');
		$this->load->view('admin/javascript');
		$this->load->view('admin/footer');
	}


	public function post_edit($random_id)
	{	
		//==========================================//
		$random_id = $this->uri->segment(3);
		$post      = $this->post_model->get_single($random_id);

		//==========================================//
		if(! $post){
			return $this->error_page(); 
		}

		$id            = $post->post_id; 
		$title         = $post->post_title;
		$content       = $post->post_content;
		$slug          = $post->post_slug;
		$category_id   = $post->post_category_id;
		$category_name = $post->category_name;
		$category_slug = $post->category_slug;
		$published     = $post->post_published;
		$featured_img  = $post->post_featured_img;
		$updation      = $post->post_updated;
		$gmt           = $post->post_created_gmt;

		//==========================================//
		if($featured_img){
			$this->featured_img_1500_x_1000($featured_img);
		}

		// Permalink
		$data_slug     = 'Permalink: '. anchor('post/'.$category_slug.'/'.$slug, base_url().'post/'.$category_slug.'/'. $slug, array('class' => 'po-link'));

		// Category
		if($category_id == '0'){
			$data_category = 'Uncategorized';
		}else{
			$data_category = $category_name;
		}

		// Published
		if($published == TRUE){
			$data_published = 'checked';
		}else{
			$data_published = NULL;
		}

		// Featured Image
		if($featured_img == NULL){
			$data_featured_img = '<div class="feat-img-def"><small>Set Feature Image</small></div>';
		}else{
			$img_prop = array(
				'src' => 'assets/img/featured-img/1500-x-1000/'.$featured_img,
				'class' => 'img-responsive',
			);
			$data_featured_img = img($img_prop);
		}

		// Post update time
		if($updation == NULL){
			$last_updated = NULL;
		}else{
			$last_updated = 'Last updated on '. date('F j, Y', strtotime($updation)) . ' @ '. date('h:i a', strtotime($updation));
		}

		// Comment
		$comment       = $this->comment_model->get_single($id);
		$comment_count = $this->comment_model->post_comment_count($id);

		if($comment){
			if($comment_count > 1){
				$data_comment_header = heading('Comments', 4);
				$data_count_comment = '<span class="badge badge-danger">'.$comment_count.'</span> Items';
			}else{
				$data_comment_header = heading('Comment', 4);
				$data_count_comment = '<span class="badge badge-danger">'.$comment_count.'</span> Item';
			}
		}else{
			$data_comment_header = '';
			$data_count_comment = '';
		}

			
		$data = array(
			'header'           => $this->load->view('admin/header','', TRUE),
			'javascript'       => $this->load->view('admin/javascript','', TRUE),
			'random_id'		   => $random_id,
			'post_title'       => $title,
			'post_content'     => $content,
			'permalink'        => $data_slug,
			'categories'       => $this->category_model->get_all(),
			'post_category'    => $data_category,
			'tags'             => $this->tag_model->get_all(),
			'published_status' => $data_published,
			'featured_img'     => $data_featured_img,
			'last_updated'     => $last_updated,
			'comment'          => $comment,
			'comment_count'    => $data_count_comment,
			'comment_header'   => $data_comment_header,
			'post_created_gmt' => $gmt,
			'id'               => $id,
			'footer'           => $this->load->view('admin/footer','', TRUE),
		);

		$this->parser->parse('admin/post_edit', $data);

	} // end of post_edit() method.




	// Filter uncategorized post.
	public function post_filter_uncategorized($uncategorized_slug)
	{
		$uncategorized_slug = $this->uri->segment(3);
		$page = ( $this->uri->segment(4) ) ? $this->uri->segment(4): 0;
		
		$config = array(
			'base_url'        =>     base_url('admin/post/uncategorized'),
			'total_rows'      => 	 $this->category_model->count_uncategorized(),
			'per_page'        =>     $this->settings_model->pagination(),
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

		$uncategorized_post = $this->category_model->uncategorized_post($config['per_page'], $page, $uncategorized_slug);

		if(! $uncategorized_post ){
			return $this->error_page();
		}

		$data = array(
			'header' => $this->load->view('admin/header','', TRUE),
			'uncategorized_post' => $uncategorized_post,
			'title' => 'Uncategorized',
			'pagination' => $this->pagination->create_links(),
			'count' => $this->category_model->count_uncategorized(),
			'javascript' => $this->load->view('admin/javascript','', TRUE),
			'footer' => $this->load->view('admin/footer','', TRUE),
		);

		$this->parser->parse('admin/filter_uncategorized', $data);
	}

	
	public function post_filter_author($id)
	{	
		$id = $this->uri->segment(3);
		$page = ( $this->uri->segment(4) ) ? $this->uri->segment(4): 0;
		
		$config = array(
			'base_url'        =>     base_url('admin/post-author/'.$id),
			'total_rows'      => 	 $this->author_model->author_post_count($id),
			'per_page'        =>     $this->settings_model->pagination(),
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

		$author_post = $this->author_model->get_author_post($config['per_page'], $page,$id);
		$post_count = $this->author_model->author_post_count($id);


		if(! $author_post){
			return $this->error_page();
		}else{
			foreach($author_post as $row):
				$name = $row->first_name.' '.$row->last_name;
			endforeach;


			$data = array(
				'header' => $this->load->view('admin/header','', TRUE),
				'author_post' => $author_post,
				'title' => $name,
				'count' => $post_count,
				'pagination' => $this->pagination->create_links(),
				'javascript' => $this->load->view('admin/javascript','', TRUE),
				'footer' => $this->load->view('admin/footer','', TRUE),
			);

			$this->parser->parse('admin/filter_author', $data);
		}
	}


	public function post_filter_author_paginated($page, $id)
	{
		$id = $this->uri->segment(3);
		$page = ( $this->uri->segment(4) ) ? $this->uri->segment(4): 0;
		
		$config = array(
			'base_url'        =>     base_url('admin/post-author/'.$id),
			'total_rows'      => 	 $this->author_model->author_post_count($id),
			'per_page'        =>     $this->settings_model->pagination(),
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

		$author_post = $this->author_model->get_author_post($config['per_page'], $page,$id);
		$post_count  = $this->author_model->author_post_count($id);


		if(! $author_post){
			return $this->error_page();
		}else{
			foreach($author_post as $row):
				$name = $row->first_name.' '.$row->last_name;
			endforeach;


			$data = array(
				'header' => $this->load->view('admin/header','', TRUE),
				'author_post' => $author_post,
				'title' => $name,
				'count' => $post_count,
				'pagination' => $this->pagination->create_links(),
				'javascript' => $this->load->view('admin/javascript','', TRUE),
				'footer' => $this->load->view('admin/footer','', TRUE),
			);

			$this->parser->parse('admin/filter_author', $data);
		}
	}

	public function post_filter_categorized($categorized_slug)
	{
		$categorized_slug = $this->uri->segment(3);
		$page = ( $this->uri->segment(4) ) ? $this->uri->segment(4): 0;
		$single_category = $this->category_model->categorized_single($categorized_slug);
		
		$config = array(
			'base_url'        =>     base_url('admin/post-category/'.$categorized_slug),
			'total_rows'      => 	 $this->category_model->count_categorized_item($single_category->post_category_id),
			'per_page'        =>     $this->settings_model->pagination(),
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
		$categorized_post = $this->category_model->categorized_post($config['per_page'], $page, $categorized_slug);
		
		if(! $categorized_post ){
			return $this->error_page();
			
		}

		foreach($categorized_post as $row):
				$title = $row->category_name;
				$id    = $row->post_category_id;
		endforeach;


		$data = array(
			'header' => $this->load->view('admin/header','', TRUE),
			'title'     => $title,
			'post_filter' => $categorized_post,
			'title' => $title,
			'pagination' => $this->pagination->create_links(),
			'javascript' => $this->load->view('admin/javascript','', TRUE),
			'footer' => $this->load->view('admin/footer','', TRUE),
		);

		$this->parser->parse('admin/filter_categorized', $data);
	}

	public function post_filter_uncategorized_paginated()
	{
		$categorized_slug = $this->uri->segment(3);
		$page = ( $this->uri->segment(4) ) ? $this->uri->segment(4): 0;
		$single_category = $this->category_model->categorized_single($categorized_slug);
		
		$config = array(
			'base_url'        =>     base_url('admin/post-category/'.$categorized_slug),
			'total_rows'      => 	 $this->category_model->count_categorized_item($single_category->post_category_id),
			'per_page'        =>     $this->settings_model->pagination(),
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
		$categorized_post = $this->category_model->categorized_post($config['per_page'], $page, $categorized_slug);
		
		if(! $categorized_post ){
			return $this->error_page();
			
		}

		foreach($categorized_post as $row):
				$title = $row->category_name;
				$id    = $row->post_category_id;
		endforeach;


		$data = array(
			'header' => $this->load->view('admin/header','', TRUE),
			'title'     => $title,
			'post_filter' => $categorized_post,
			'title' => $title,
			'pagination' => $this->pagination->create_links(),
			'javascript' => $this->load->view('admin/javascript','', TRUE),
			'footer' => $this->load->view('admin/footer','', TRUE),
		);

		$this->parser->parse('admin/filter_categorized', $data);
	}

	public function post_filter_tag($slug)
	{
		$slug = $this->uri->segment(3);
		$tag = $this->tag_model->get_single($slug);

		foreach($tag as $row){
			$tag_name = heading(' Post with <span class="text-primary">'. $row->tag_name.'</span> tag.', 5);
			$id = $row->tag_id;
			$post = $this->tag_model->get_post($id);
			$title = $row->tag_name;
		}

		if(! $tag){
			return $this->error_page();
		}


		$data = array(
			'header' => $this->load->view('admin/header','', TRUE),
			'javascript' => $this->load->view('admin/javascript','', TRUE),
			'tag' => $tag,
			'id' => $id,
			'post' => $post,
			'title' => $title,
			'count_tag' => $this->tag_model->count_filter_tag($id),
			'footer' => $this->load->view('admin/footer','', TRUE),
		);

		$this->parser->parse('admin/filter_tag', $data);
	}

	public function post_search()
	{
		$rules = array(
			array(
				'field' => 'search_post_title',
				'label' => 'Post title',
				'rules' => 'required|strip_tags|xss_clean'
			),
		);

		$this->form_validation->set_rules($rules);

		if($this->form_validation->run() == FALSE){
			redirect('admin/post-list/all');
		}else{

			$match = $this->input->post('search_post_title', TRUE);
			$url_match = str_replace(' ', ' ', $match);
			redirect('post/post-search-result/'. urlencode($url_match));
		}
	}


	public function post_search_result($match = NULL)
	{

		if($match == NULL){
			return $this->error_page();
		}

		$search_result = $this->post_model->search(str_replace('+', ' ', $match));
		$search_count = $this->post_model->count_search_item(str_replace('+', ' ', $match));

		if($search_count > 1){
			$result = 'Search results for '. "'".str_replace('+', ' ', $match)."'";
			$search_match = '<span class="badge badge-danger">'.$search_count.'</span> Items - ' . $result;
		}else{
			$result = 'Search result for '. "'".str_replace('+', ' ', $match)."'";
			$search_match = '<span class="badge badge-danger">'.$search_count.'</span> Item - '. $result;
		}

		$data = array(
			'header' => $this->load->view('admin/header','', TRUE),
			'posts' => $search_result,
			'match' => $search_match,
			'javascript' => $this->load->view('admin/javascript','', TRUE),
			'footer' => $this->load->view('admin/footer','', TRUE)
		);

		$this->parser->parse('admin/post_search', $data);
	}

	

}// Post class