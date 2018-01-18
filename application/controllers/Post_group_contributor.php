<?php
defined('BASEPATH')OR exit('No direct script access allowed');

class Post_group_contributor extends CI_Controller{

	public function __construct()
	{
		parent::__construct();

		$group = 2;
		if (! $this->ion_auth->in_group($group)){
			redirect('login');
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

	private function pills_header()
	{	
		$user            = $this->ion_auth->user()->row();
		$count_all = $this->member_model->countAll();
		$count_mine      = $this->member_model->countMine($user->id);
		$count_published = $this->member_model->countPublished();

		$data = array(
			'count_all'       => $count_all,
			'count_mine'      => $count_mine,
			'count_published' => $count_published,
		);

		$this->load->view('member/group_header', $data);
	}

	private function error_page()
	{
		$this->load->view('member/header');
		$this->load->view('member/error');
		$this->load->view('member/javascript');
		$this->load->view('member/footer');
	}
	// All
	public function all()
	{
		$per_page = ( $this->uri->segment(4) ) ? $this->uri->segment(4): 0;

		$config = array(
			'base_url'        =>     base_url('member/post-list/all'),
			'total_rows'      => 	 $this->member_model->countAll(),
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
		$user     = $this->ion_auth->user()->row();
		$all_data = $this->member_model->getAll($config['per_page'], $per_page);

		if(! $all_data){
			$data = array(
				'header'       => $this->header(),
				'pills_header' => $this->pills_header(),
				'user_id'      => $user->id,
				'item'         => $all_data,
				'pagination'   => $this->pagination->create_links(),
				'javascript'   => $this->load->view('member/javascript', '', TRUE),
				'footer'       => $this->load->view('member/footer', '', TRUE),
			);

			$this->parser->parse('member/group_all', $data);
		}else{
			$data = array(
				'header'       => $this->header(),
				'pills_header' => $this->pills_header(),
				'user_id'      => $user->id,
				'item'         => $all_data,
				'pagination'   => $this->pagination->create_links(),
				'javascript'   => $this->load->view('member/javascript', '', TRUE),
				'footer'       => $this->load->view('member/footer', '', TRUE),
			);

			$this->parser->parse('member/group_all', $data);
		}
	}

	public function all_paginated()
	{

	}


	//================================================//

	public function mine()
	{	
		$per_page = ( $this->uri->segment(4) ) ? $this->uri->segment(4): 0;
		$user      = $this->ion_auth->user()->row();

		$config = array(
			'base_url'        =>     base_url('member/post-list/mine'),
			'total_rows'      => 	 $this->member_model->countMine($user->id),
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
		$mine_data = $this->member_model->getMine($config['per_page'],$per_page,$user->id);

		if(! $mine_data){
			$data = array(
				'header'       => $this->header(),
				'pills_header' => $this->pills_header(),
				'item'         => $mine_data,
				'pagination'   => $this->pagination->create_links(),
				'javascript'   => $this->load->view('member/javascript', '', TRUE),
				'footer'       => $this->load->view('member/footer', '', TRUE),
			);

			$this->parser->parse('member/group_mine', $data);
		}else{
			$data = array(
				'header'       => $this->header(),
				'pills_header' => $this->pills_header(),
				'user_id'      => $user->id,
				'item'         => $mine_data,
				'pagination'   => $this->pagination->create_links(),
				'javascript'   => $this->load->view('member/javascript', '', TRUE),
				'footer'       => $this->load->view('member/footer', '', TRUE),
			);

			$this->parser->parse('member/group_mine', $data);
		}
	}

	public function mine_paginated($per_page)
	{
		$per_page  = ( $this->uri->segment(4) ) ? $this->uri->segment(4): 0;
		$user      = $this->ion_auth->user()->row();

		$config = array(
			'base_url'        =>     base_url('member/post-list/mine'),
			'total_rows'      => 	 $this->member_model->countMine($user->id),
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
		$mine_data = $this->member_model->getMine($config['per_page'],$per_page,$user->id);

		if(! $mine_data){
			return $this->error_page();
		}else{
			$data = array(
				'header'       => $this->header(),
				'pills_header' => $this->pills_header(),
				'item'         => $mine_data,
				'pagination'   => $this->pagination->create_links(),
				'javascript'   => $this->load->view('member/javascript', '', TRUE),
				'footer'       => $this->load->view('member/footer', '', TRUE),
			);

			$this->parser->parse('member/group_mine', $data);
		}
	}
	//================================================//

	public function published()
	{
		$per_page = ( $this->uri->segment(4) ) ? $this->uri->segment(4): 0;

		$config = array(
			'base_url'        =>     base_url('member/post-list/published'),
			'total_rows'      => 	 $this->member_model->countPublished(),
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
		$user = $this->ion_auth->user()->row();
		$published_data = $this->member_model->getPublished($config['per_page'],$per_page);

		if(! $published_data){
			$data = array(
				'header'       => $this->header(),
				'pills_header' => $this->pills_header(),
				'user_id'	   => $user->id,
				'item'         => $published_data,
				'pagination'   => $this->pagination->create_links(),
				'javascript'   => $this->load->view('member/javascript', '', TRUE),
				'footer'       => $this->load->view('member/footer', '', TRUE),
			);

			$this->parser->parse('member/group_published', $data);
		}else{
			$data = array(
				'header'       => $this->header(),
				'pills_header' => $this->pills_header(),
				'user_id'	   => $user->id,
				'item'         => $published_data,
				'pagination'   => $this->pagination->create_links(),
				'javascript'   => $this->load->view('member/javascript', '', TRUE),
				'footer'       => $this->load->view('member/footer', '', TRUE),
			);

			$this->parser->parse('member/group_published', $data);
		}
	}

	public function published_paginated($per_page)
	{
		$per_page = ( $this->uri->segment(4) ) ? $this->uri->segment(4): 0;

		$config = array(
			'base_url'        =>     base_url('member/post-list/published'),
			'total_rows'      => 	 $this->member_model->countPublished(),
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
		$published_data = $this->member_model->getPublished($config['per_page'],$per_page);

		if(! $published_data){
			return $this->error_page();
		}else{
			$data = array(
				'header'       => $this->header(),
				'pills_header' => $this->pills_header(),
				'user_id'	   => $user->id,
				'item'         => $published_data,
				'pagination'   => $this->pagination->create_links(),
				'javascript'   => $this->load->view('member/javascript', '', TRUE),
				'footer'       => $this->load->view('member/footer', '', TRUE),
			);

			$this->parser->parse('member/group_published', $data);
		}
	}

	//================================================//
}