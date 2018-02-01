<?php
defined('BASEPATH')OR exit('No direct script access allowed');

class Member extends CI_Controller{

	public function __construct()
	{
		parent::__construct();

		# multiple groups (by id) and check if all exist
		$group = 2;
		if (! $this->ion_auth->in_group($group)){
			redirect('login');
		}
		
	}

	public function index()
	{	

		$user = $this->ion_auth->user()->row();

		//===============
		// Posts
		//===============
		$recent_post = $this->member_model->get_recent_post($user->id);
		
		//===============
		// Meters
		//===============
		$post_count = $this->member_model->count_post($user->id);
		$category_count = $this->member_model->count_category();
		$tag_count = $this->member_model->count_tag();
		$comment_count = $this->member_model->count_comment($user->id);

		// Comment meter
		if($comment_count > 1){
			$comment_meter = ' Comments';
		}else{
			$comment_meter = ' Comment';
		}

		// Tag meter
		if($category_count > 1){
			$tag_meter = ' Tags';
		}else{
			$tag_meter = ' Tag';
		}

		// Category meter
		if($category_count > 1){
			$category_meter = ' Categories';
		}else{
			$category_meter = ' Category';
		}

		// Post meter
		if($post_count > 1){
			$post_meter = ' Posts';
		}else{
			$post_meter = ' Post';
		}


		//===============
		// Parsing data
		//===============
		$data = array(
			'header' => $this->header(),
			'post_meter' => $post_meter,
			'post_count' => $post_count,
			'category_meter' => $category_meter,
			'category_count' => $category_count,
			'tag_meter' => $tag_meter,
			'tag_count' => $tag_count,
			'comment_meter' => $comment_meter,
			'comment_count' => $comment_count,
			'recent_posts' => $recent_post,
			'javascript' => $this->load->view('member/javascript', '', TRUE),
			'footer' => $this->load->view('member/footer', '', TRUE),
			);

		$this->parser->parse('member/main', $data);

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
			redirect('member/post-edit/'.$random_id_slug);
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
				redirect('member/post-edit/'.$random_id_slug);
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
			redirect('member/post-edit/'.$random_id_slug);
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

	private function header()
	{	
		$user = $this->ion_auth->user()->row();

		$setting = $this->settings_model->site_settings();

		$logout = anchor('logout','<i class="fa fa-fw fa-power-off"></i> Log Out'); 
		$profile = $this->author_model->get_author_profile($user->id);
		

		if($profile->profile_user_avatar){
			$avatar = array(
					'src' => 'assets/img/avatar/100-x-100/'. $profile->profile_user_avatar,
					'class' => 'user-avatar img-circle',
				);

			$user_avatar = img($avatar);
		}else{
			$user_avatar = NULL;
		}

		// Site title
		if(! $setting->title){
			$title = 'Site Name';
		}else{
			$title = $setting->title;
		}

		// Site Tagline
		if(! $setting->tagline){
			$tagline = NULL;
		}else{
			$tagline = ' - '.$setting->tagline;
		}

		// Site icon
		if($setting->favicon == NULL){
			$favicon_16_x_16   = NULL;
			$favicon_32_x_32   = NULL;
			$favicon_180_x_180 = NULL;
		}else{
			$favicon_16_x_16_attr = array(
				'href' => 'assets/img/favicon/16-x-16/'.$setting->favicon,
		        'rel' => 'icon',
		        'type' => 'image/png',
		        'sizes' => '16x16'
			);

			$favicon_32_x_32_attr = array(
				'href' => 'assets/img/favicon/32-x-32/'.$setting->favicon,
		        'rel' => 'icon',
		        'type' => 'image/png',
		        'sizes' => '32x32'
			);

			$favicon_180_x_180_attr = array(
				'href' => 'assets/img/favicon/180-x-180/'.$setting->favicon,
		        'rel' => 'apple-touch-icon',
		        'type' => 'image/png',
		        'sizes' => '180x180'
			);

			$favicon_16_x_16   = link_tag($favicon_16_x_16_attr);
			$favicon_32_x_32   = link_tag($favicon_32_x_32_attr);
			$favicon_180_x_180 = link_tag($favicon_180_x_180_attr);

			$favicons = $favicon_16_x_16 . $favicon_32_x_32 . $favicon_180_x_180;

		}

		$data = array(
			'doctype' => doctype('html5'),
			'site_title' => $title,
			'tagline' => $tagline,
			'favicons' => $favicons,
			'user_avatar' => $user_avatar,
			'user' => $user->first_name.' '.$user->last_name,
			'logout' => $logout,
		);

		 $this->parser->parse('member/header', $data);
	}

	
	public function error_page()
	{
		$data = array(
			'header' => $this->header(),
			'javascript' => $this->load->view('member/javascript', ' ', TRUE),
			'footer' => $this->load->view('member/javascript', ' ', TRUE),
			);

		$this->parser->parse('member/error', $data);
	}
	
	public function post_edit($random_id)
	{
		$user = $this->ion_auth->user()->row();
		//==========================================//
		$random_id = $this->uri->segment(3);
		$post      = $this->member_model->get_single($random_id, $user->id);

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
		$gmt           = $post->post_created_gmt;
		$updation      = $post->post_updated;

		//==========================================//
		if($featured_img){
			$this->featured_img_1500_x_1000($featured_img);
		}

		$data_slug     = 'Permalink: '. anchor('post/'.$category_slug.'/'.$slug, base_url().'post/'.$category_slug.'/'. $slug, array('class' => 'po-link'));

		if($category_id == '0'){
			$data_category = 'Uncategorized';
		}else{
			$data_category = $category_name;
		}

		if($published == TRUE){
			$data_published = 'checked';
		}else{
			$data_published = NULL;
		}

		if($featured_img == NULL){
			$data_featured_img = base_url('assets/img/featured-img/set-featured-img.jpg');
		}else{
			$data_featured_img = base_url('assets/img/featured-img/1500-x-1000/'.$featured_img);
		}

		// Post update time
		if($updation == NULL){
			$last_updated = NULL;
		}else{
			$last_updated = 'Last updated on '. date('F j, Y', strtotime($updation)) . ' @ '. date('h:i a', strtotime($updation));
		}

		$comment       = $this->comment_model->get_single($id);
		$comment_count = $this->comment_model->post_comment_count($id);

		if($comment){
			if($comment_count > 1){
				$data_comment_header = heading('Comments', 4);
				$data_count_comment = '<span class="badge badge-danger">'.$comment_count.'</span> Items';
			}else{
				$data_comment_header = heading('Comment', 4);
				$count_post_comment = '<span class="badge badge-danger">'.$comment_count.'</span> Item';
			}
		}else{
			$data_comment_header = '';
			$data_count_comment = '';
		}


		//==========================================//
			
		$data = array(
			'header'           => $this->header(),
			'javascript'       => $this->load->view('member/javascript','', TRUE),
			'id'               => $id,
			'post_title'       => $title,
			'post_content'     => $content,
			'permalink'        => $data_slug,
			'categories'       => $this->category_model->get_all(),
			'post_category'    => $data_category,
			'tags'             => $this->tag_model->get_all(),
			'published_status' => $data_published,
			'featured_img'     => $data_featured_img,
			'comment'          => $comment,
			'comment_count'    => $data_count_comment,
			'comment_header'   => $data_comment_header,
			'last_updated'     => $last_updated,
			'footer'           => $this->load->view('member/footer','', TRUE),
		);

		$this->parser->parse('member/post_edit', $data);

	}

	public function post_create()
	{
		$data = array(
			'header' => $this->header(),
			'categories' => $this->category_model->get_all(),
			'tags' => $this->tag_model->get_all(),
			'javascript' => $this->load->view('member/javascript', '', TRUE),
			'footer' => $this->load->view('member/footer', '', TRUE),
			);

		$this->parser->parse('member/post', $data);
	}

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

		$rules = array(
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

		$this->form_validation->set_rules($rules);
	
		if($this->form_validation->run() === FALSE){
			$this->session->set_flashdata('failed', form_error('post_title', '', ''));

			redirect('member/post');

		}else{
			    //===========================
				// Insert entry for post data.
				//===========================
				$this->upload->do_upload('post_featured_img');

				$category = $this->input->post('post_category', TRUE);

				if(! $category ){
					$post_category = 'uncategorized';
				}else{
					$post_category = '';
				}

				if($category == '0'){
					$post_category = 'uncategorized';
				}else{
					$post_category_id = $this->input->post('post_category', TRUE);
				}

				$random_key = random_string('alnum', 20);

				$user = $this->ion_auth->user()->row();

				$post_data = array(
					'post_random_id' => $random_key,
					'post_title' => ucfirst($this->input->post('post_title', TRUE)),
					'post_content' => ucfirst($this->input->post('post_content', TRUE)),
					'post_slug' => url_title($this->input->post('post_title'), 'dash', TRUE),
					'post_category_id' => $this->input->post('post_category', TRUE),
					'post_uncategorized_slug' => $post_category,
					'post_published' => $this->input->post('post_published', TRUE),
					'post_featured_img' => $this->upload->data('file_name'),
					'post_created' => time(),
					'user_id' => $user->id,
				);

				$this->post_model->insert_new($post_data);


				//===========================
				// Insert batch for post tags.
				//===========================
			
				$post_term_data = $this->input->post('post_tag');
				

				if(! $post_term_data){
						
				}else{
					
					$post_term = array();

					
					foreach($post_term_data as $key => $value){
						$post_term[$key]['term_tag_id'] = $value;
						$post_term[$key]['term_post_id'] = $this->db->insert_id();
						$post_term[$key]['term_user_id'] = $user->id;
						$post_term[$key]['term_created'] = time();
					}

					$this->post_term_model->insert_tag($post_term);
				}

				//===========================
				// Success message after submit new post.
				//===========================
				$this->session->set_flashdata('post_success', '<li><strong>Successfully added!</strong> new post.</li>');

				//===========================
				// Redirect to specific URL after successfully validated and store the data.
				//===========================
				$random_id = $random_key;
				redirect('member/post-edit/'.$random_id);
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


	public function post_filter_uncategorized($slug)
	{
		$slug = $this->uri->segment(3);
		$page     = ( $this->uri->segment(4) ) ? $this->uri->segment(4): 0;
		$user = $this->ion_auth->user()->row();

		$config = array(
			'base_url'        =>     base_url('member/post/'. $slug),
			'total_rows'      => 	 $this->member_model->count_uncategorized_post($slug, $user->id),
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

		$uncategorized_post = $this->member_model->uncategorized_post($config['per_page'], $page, $slug, $user->id);

		if(! $uncategorized_post){
			return $this->error_page();
		}

		foreach($uncategorized_post as $row):
			$id = $row->post_category_id;
		endforeach;

		$count_item = $this->member_model->count_uncategorized_post( $slug, $user->id );

		$data = array(
			'header' => $this->header(),
			'uncategorized_post' => $uncategorized_post,
			'count' => $count_item,
			'pagination' => $this->pagination->create_links(),
			'javascript' => $this->load->view('member/javascript', '', TRUE),
			'footer' => $this->load->view('member/footer', '', TRUE),
		);

		$this->parser->parse('member/filter_uncategorized', $data);
	}

	public function post_filter_categorized($slug)
	{	
		$slug     = $this->uri->segment(3);
		$page     = ( $this->uri->segment(4) ) ? $this->uri->segment(4): 0;
		$user     = $this->ion_auth->user()->row();
		$category = $this->member_model->get_single_category($slug);

		if($category){
			$category_id = $category->category_id;
		}else{
			return $this->error_page();
		}

		$config = array(
			'base_url'        =>     base_url('member/post-category/'. $slug),
			'total_rows'      => 	 $this->member_model->count_categorized_post($user->id, $category_id),
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
		$post = $this->member_model->categorized_post($config['per_page'], $page, $slug, $user->id);

		if(! $post){
			return $this->error_page();
		}

		foreach($post as $row):
			$cat_title = $row->category_name;
			$cat_id    = $row->post_category_id;
		endforeach;
		$count_item = $this->member_model->count_categorized_post($user->id, $cat_id);
		
		
		$data = array(
			'header' => $this->header(),
			'post_filter' => $post,
			'title'       => $cat_title,
			'count'       => $count_item,
			'pagination'  => $this->pagination->create_links(),
			'javascript'  => $this->load->view('member/javascript','', TRUE),
			'footer'      => $this->load->view('member/footer','', TRUE),
		);

		$this->parser->parse('member/filter_categorized', $data);
	}

	public function post_filter_categorized_paginated($slug)
	{
		$slug     = $this->uri->segment(3);
		$page     = ( $this->uri->segment(4) ) ? $this->uri->segment(4): 0;
		$user     = $this->ion_auth->user()->row();
		$category = $this->member_model->get_single_category($slug);

		if($category){
			$category_id = $category->category_id;
		}else{
			return $this->error_page();
		}

		$config = array(
			'base_url'        =>     base_url('member/post-category/'. $slug),
			'total_rows'      => 	 $this->member_model->count_categorized_post($user->id, $category_id),
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
		$post = $this->member_model->categorized_post($config['per_page'], $page, $slug, $user->id);

		if(! $post){
			return $this->error_page();
		}else{
			foreach($post as $row):
				$cat_title = $row->category_name;
				$cat_id = $row->post_category_id;
			endforeach;

			$count_item = $this->member_model->count_categorized_post($user->id, $cat_id);
		}

		$data = array(
			'header' => $this->header(),
			'post_filter' => $post,
			'title'       => $cat_title,
			'count'       => $count_item,
			'pagination'  => $this->pagination->create_links(),
			'javascript'  => $this->load->view('member/javascript','', TRUE),
			'footer'      => $this->load->view('member/footer','', TRUE),
		);

		$this->parser->parse('member/filter_categorized', $data);
	}


	public function post_comment()
	{	
		$user = $this->ion_auth->user()->row();
		$comment = $this->member_model->get_comment($user->id);

		$data = array(
			'header' => $this->header(),
			'comments' => $comment,
			'javascript' => $this->load->view('member/javascript','', TRUE),
			'footer' => $this->load->view('member/footer','', TRUE),
		);

		$this->parser->parse('member/comment', $data);
	}

	public function delete_comment($id)
	{	
		$user = $this->ion_auth->user()->row();
		$id = $this->uri->segment(3);

		$delete_comment = $this->member_model->delete_comment($id, $user->id);

		if(! $delete_comment){
			redirect('member/comment');
		}

		redirect('member/comment');
	}

	public function post_filter_tag($slug)
	{	
		$slug     = $this->uri->segment(3);
		$page     = ( $this->uri->segment(4) ) ? $this->uri->segment(4): 0;
		$tag      = $this->tag_model->get_single_tag($slug);
		$user     = $this->ion_auth->user()->row();
		$user_id  = $user->id;

		if(! $tag){
			return $this->error_page();
		}

		$config = array(
			'base_url'        =>     base_url('member/post-tag/'. $slug),
			'total_rows'      => 	 $this->member_model->post_tag_count($tag->tag_id, $user->id),
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
		$post = $this->member_model->post_tag($config['per_page'], $page, $tag->tag_id, $user_id);
		$count = $this->member_model->post_tag_count($tag->tag_id, $user_id);

		if(! $post){
			return $this->error_page();
		}

		$data = array(
			'header' => $this->header(),
			'post' => $post,
			'title' => $tag->tag_name,
			'count' => $count,
			'pagination' => $this->pagination->create_links(),
			'javascript' => $this->load->view('member/javascript', '', TRUE),
			'footer' => $this->load->view('member/footer', '', TRUE),
		);

		$this->parser->parse('member/filter_tag', $data);
	}

	public function post_delete_none_paginated()
	{	
		$list       = $this->uri->segment(2);
		$group      = $this->uri->segment(3);
		$id         = $this->uri->segment(5);
		$file_name  = $this->uri->segment(6);

		if($file_name){
			 $this->delete_feat_img_file($file_name);
		}

		$user        = $this->ion_auth->user()->row();
		$delete_post = $this->member_model->delete_post($id, $user->id);
		$this->post_term_model->delete_item($id);

		if(! $delete_post){
			redirect('member/'.$list.'/'.$group);	
		}

		redirect('member/'.$list.'/'.$group);	
	}

	public function post_delete_paginated()
	{	
		$list       = $this->uri->segment(2);
		$group      = $this->uri->segment(3);
		$pagination = $this->uri->segment(4);
		

		if($pagination){
			$id     = $this->uri->segment(6);
			$page   = $this->uri->segment(4);
			$file_name  = $this->uri->segment(7);
		}else{
			$id         = $this->uri->segment(5);
			$file_name  = $this->uri->segment(6);
			$page       = NULL;
		}

		if($file_name){
			 $this->delete_feat_img_file($file_name);
		}

		$user        = $this->ion_auth->user()->row();
		$delete_post = $this->member_model->delete_post($id, $user->id);
		$this->post_term_model->delete_item($id);

		if(! $delete_post){
			redirect('member/'.$list.'/'.$group.'/'.$page);	
		}

		redirect('member/'.$list.'/'.$group.'/'.$page);	
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
	
	/**
	* Author's Profile
	* For more info read ion_auth_model line 937
	*/
	
	public function author_profile()
	{	
		$user = $this->ion_auth->user()->row();

		$profile = $this->author_model->get_author_profile($user->id);

		if($profile->profile_user_avatar){
			$user_img = img('assets/img/avatar/100-x-100/'. $profile->profile_user_avatar);
		}else{
			$user_img = '<div class="text-sm user-avatar-default">Set Profile Image</div>';
		}

		$data = array(
			'header' => $this->header(),
			'first_name' => $user->first_name,
			'last_name' => $user->last_name,
			'email' => $user->email,
			'user_img' => $user_img,
			'nickname' => $profile->profile_user_nickname,
			'bio_info' => $profile->profile_user_bio_info,
			'javascript' => $this->load->view('member/javascript', '', TRUE),
			'footer' => $this->load->view('member/footer', '', TRUE),
		);

		$this->parser->parse('member/author_profile', $data);
	}

	public function author_profile_update()
	{	
		// Upload Image
		$config = array(
				'encrypt_name' => TRUE,
				'upload_path' => './assets/img/avatar',
				'allowed_types' => 'png|jpg',
				'max_size' => '200',
			);

		$this->upload->initialize($config);

		$rules = array(
				array(
					'field' => 'first_name',
					'label' => 'First Name',
					'rules' => 'alpha|strip_tags'
					),
				array(
					'field' => 'last_name',
					'label' => 'Last Name',
					'rules' => 'alpha|strip_tags'
					),
				array(
					'field' => 'nickname',
					'label' => 'Nickname',
					'rules' => 'required|alpha|strip_tags'
					),
				array(
					'field' => 'email',
					'label' => 'Email',
					'rules' => 'required|valid_email|strip_tags'
					),
			);

		$this->form_validation->set_rules($rules);

		if($this->form_validation->run() === FALSE){

			$this->session->set_flashdata('failed', validation_errors('<li><strong>Error </strong>', '</li>'));
			redirect('member/profile');

		}else{
			
			$user = $this->ion_auth->user()->row();
			$user_data = array(
					'first_name' => $this->input->post('first_name', TRUE),
					'last_name'  => $this->input->post('last_name', TRUE),
					'email'      => $this->input->post('email', TRUE),
					'password'   => $this->input->post('new_password', TRUE),
				);

			$this->ion_auth->update($user->id, $user_data);
			//========================================//
			$user = $this->ion_auth->user()->row();
			$profile_data = $this->author_model->get_author_profile($user->id);
			$profile_picture = $this->upload->do_upload('profile_picture');

			if(! $profile_picture){
				$img_upload_file = $profile_data->profile_user_avatar;
			}else{
				$this->delete_profile_img_thumb($profile_data->profile_user_avatar);
				$this->delete_profile_img($profile_data->profile_user_avatar);
				$img_upload_file = $this->upload->data('file_name');

			}
			//========================================//
			$data = array(
				'profile_user_avatar' => $img_upload_file,
				'profile_user_nickname' => $this->input->post('nickname', TRUE),
				'profile_user_website' => $this->input->post('website', TRUE),
				'profile_user_bio_info' => $this->input->post('biographical_info', TRUE),
				);

			//========================================//
			$user = $this->ion_auth->user()->row();
			$this->author_model->update_author_profile($user->id, $data);
			
			$user_img = $this->author_model->get_author_profile($user->id);
			if(! $profile_picture){

			}else{
				$this->resize_profile_img($user_img->profile_user_avatar); // Resize
			}
			//========================================//
			$this->delete_profile_img($user_img->profile_user_avatar); // Avatar Delete
			$this->session->set_flashdata('success', '<li><strong>Successfully!</strong> updated</li>');
			redirect('member/profile');

		}
		
	}

	private function resize_profile_img($img)
	{
        $config['image_library'] = 'gd2';
		$config['source_image'] = './assets/img/avatar/'.$img;
		$config['quality'] = '100%';
		$config['maintain_ratio'] = TRUE;
		$config['new_image']    = './assets/img/avatar/100-x-100';
		$config['width']         = 100;
		$config['height']       = 100;

		$this->image_lib->initialize($config);

		if ( ! $this->image_lib->resize())
		{	
			$resize = $this->image_lib->display_errors();	
		    $this->session->set_flashdata('resize_fail', $resize); 
		}else{
			$this->image_lib->resize();
		}
	}

	private function delete_profile_img($img_name)
	{	
		$file = 'assets/img/avatar/'.$img_name;
		
		if(is_file($file)){
			unlink($file);
		}
			
	}

	private function delete_profile_img_thumb($img_name)
	{	
		$file = 'assets/img/avatar/100-x-100/'.$img_name;
		
		if(is_file($file)){
			unlink($file);
		}
			
	}

	// To be continued...
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
			redirect('member/post-list/all');
		}else{
			$match = $this->input->post('search_post_title', TRUE);
			$url_match = str_replace(' ', ' ', $match);
			redirect('member/post-search-result/'. urlencode($url_match));
		}
	}

	public function post_search_result($match = NULL)
	{

		if($match == NULL){
			return $this->error_page();
		}

		$page = ( $this->uri->segment(4) ) ? $this->uri->segment(4): 0;
		$user = $this->ion_auth->user()->row();


		$config = array(
			'base_url'        =>     base_url('member/post-search-result/'. $match),
			'total_rows'      => 	 $this->member_model->count_search_item($match, $user->id),
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

		$search_result = $this->member_model->search($config['per_page'], $page, str_replace('+', ' ', $match), $user->id);
		$search_count  = $this->member_model->count_search_item(str_replace('+', ' ', $match), $user->id);

		if($search_count > 1){
			$result = 'Search results for '. "'".str_replace('+', ' ', $match)."'";
			$search_match = $result;
		}else{
			$result = 'Search result for '. "'".str_replace('+', ' ', $match)."'";
			$search_match = $result;
		}

		$data = array(
				'header'       => $this->header(),
				'group_header' => $this->load->view('member/group_header','', TRUE),
				'posts'        => $search_result,
				'match'        => $search_match,
				'count'        => $search_count,
				'pagination'   => $this->pagination->create_links(),
				'javascript'   => $this->load->view('member/javascript','', TRUE),
				'footer'       => $this->load->view('member/footer','', TRUE)
			);

			$this->parser->parse('member/post_search', $data);
	}

	/*
	* Trash single post
	*/
	public function post_trash($random_id)
	{	
		$user = $this->ion_auth->user()->row();
		$random_id = $this->uri->segment(5);
		$group     = $this->uri->segment(3);
		$category  = $this->uri->segment(2);


		if(! $random_id){
			redirect('member/'.$category.'/'.$group);
		}else{
			$this->member_model->setTrash($random_id, $user->id);
			redirect('member/'.$category.'/'.$group);
		}
	}

	public function post_trash_paginated($random_id)
	{	
		$user = $this->ion_auth->user()->row();
		$random_id = $this->uri->segment(6);
		$group = $this->uri->segment(3);
		$page = $this->uri->segment(4);
		$category  = $this->uri->segment(2);

		if(! $random_id){
			redirect('member/'.$category.'/'.$group.'/'.$page);
		}else{
			$this->member_model->setTrash($random_id, $user->id);
			redirect('member/'.$category.'/'.$group.'/'.$page);
		}
	}

	/*
	* Restore single post
	*/
	public function post_restore($random_id)
	{
		$user = $this->ion_auth->user()->row();
		$random_id = $this->uri->segment(5);
		$group = $this->uri->segment(3);
		$setRestore = $this->post_model->setRestore($random_id, $user->id);

		if($setRestore){
			$this->post_model->setRestore($random_id, $user->id);
			redirect('member/post-list/'. $group);
		}else{
			redirect('member/post-list/'. $group);
		}
	}

	public function post_restore_paginated($random_id)
	{	
		$user = $this->ion_auth->user()->row();
		$random_id = $this->uri->segment(6);
		$page = $this->uri->segment(4);
		$group = $this->uri->segment(3);
		$setRestore = $this->post_model->setRestore($random_id, $user->id);

		if($setRestore){
			$this->post_model->setRestore($random_id, $user->id);
			redirect('member/post-list/'. $group.'/'.$page);
		}else{
			redirect('member/post-list/'. $group.'/'.$page);
		}
	}

	/**
	* Restore multiple post
	*/
	public function restore_multiple()
	{	
		$user               = $this->ion_auth->user()->row();
		$group              = $this->uri->segment(3);
		$page               = $this->uri->segment(4);

		$restore            = $this->input->post('restore', TRUE);
		$post               = $this->input->post('post', TRUE);

		if($restore){
			foreach($post as $id){
				$this->member_model->restoreMultiplePost($id, $user->id); // Restore handler
			}

			if(is_numeric($page)){
				redirect('member/post-list/'.$group.'/'.$page);
			}else{
				redirect('member/post-list/'.$group);
			}
		}else{
			if(is_numeric($page)){
				redirect('member/post-list/'.$group.'/'.$page);
			}else{
				redirect('member/post-list/'.$group);
			}
		} // Restore
	}

	/*
	* Trash multiple post function
	*/
	public function trash_multiple()
	{	
		$user       = $this->ion_auth->user()->row();
		$id          = $this->input->post('post_trash');
		$group       = $this->uri->segment(3);
		$page        = $this->uri->segment(4);
		$list        = $this->uri->segment(2);

		if($this->input->post('postTrash')){
			foreach($id as $i){
				$this->member_model->trashMultiplePost($i, $user->id);
			}

			if(is_numeric($page)){
				redirect('member/'.$list.'/'.$group.'/'.$page);
				
			}else{
				redirect('member/'.$list.'/'.$group);
			}
		}else{
			if(is_numeric($page)){
				redirect('member/'.$list.'/'.$group.'/'.$page);
			}else{
				redirect('member/'.$list.'/'.$group);
			}
		}
	}

} // Member class