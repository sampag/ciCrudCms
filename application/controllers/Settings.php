<?php
defined('BASEPATH')OR exit('No direct script access allowed');

class Settings extends CI_Controller{

	public function __construct()
	{
		parent::__construct();

		if(! $this->ion_auth->is_admin() ){
			redirect('login');
		}
	}

	public function index()
	{

		$setting = $this->settings_model->site_settings();

		if($setting->logo == NULL){
			$site_logo = '<div class="text-sm site-logo">Set Logo</div>';
		}else{
			$site_logo = img('assets/img/logo/200-x-100/'.$setting->logo, array('class' => 'img-responsive'));
		}

		if($setting->favicon == NULL){
			$favicon_32_x_32 = '<div class="text-sm site-favicon">Set Icon</div>';
		}else{
			$icon_32_x_32 = array(
				'src' => 'assets/img/favicon/32-x-32/'.$setting->favicon,
				'style' => 'width: 100px',
				'class' => 'img-responsive',
			);

			$favicon_32_x_32 = img($icon_32_x_32);
		}

		$data = array(
			'header' => $this->load->view('admin/header','', TRUE),
			'pagination' => $setting->pagination,
			'site_title' => $setting->title,
			'tagline' => $setting->tagline,
			'site_logo' => $site_logo,
			'favicon_32_x_32' => $favicon_32_x_32,
			'javascript' => $this->load->view('admin/javascript','', TRUE),
			'footer' => $this->load->view('admin/footer','', TRUE),
		);

		$this->parser->parse('admin/settings', $data);
	}


	public function settings_save_changes()
	{

		$config = array(
			'encrypt_name' => TRUE,
			'upload_path' => './assets/img/logo',
			'allowed_types' => 'png|jpg',
			'max_size' => '200',
		);

		$this->upload->initialize($config);
		
		$this->upload->do_upload('settings_site_logo');
		

		$rules = array(
			array(
				'field' => 'settings_pagination',
				'label' => 'pagination',
				'rules' => 'required|strip_tags|numeric|less_than[15]'
				),
			array(
				'field' => 'site_title',
				'label' => 'site title',
				'rules' => 'required|strip_tags'
				),
			array(
				'field' => 'site_tagline',
				'label' => 'site tagline',
				'rules' => 'required|strip_tags'
				),
		);

		$this->form_validation->set_rules($rules);


		if($this->form_validation->run() == FALSE){

			
			$this->session->set_flashdata('settings_error', validation_errors('<li><strong>Error </strong>', '</li>'));

			redirect('admin/settings');
		
		}else{

			$setting = $this->settings_model->site_settings();
			$logo_filename = $this->upload->data('file_name');

			if(! $logo_filename){
				$upload_logo = $setting->logo;
			}else{
				$this->delete_resize_site_logo($setting->logo);
				$this->delete_site_logo($setting->logo);
				$upload_logo = $this->upload->data('file_name');
			}

			$this->site_icon();
			
			// Store ===============
			$settings_data = array(
				'pagination' => $this->input->post('settings_pagination', TRUE),
				'title' => ucfirst($this->input->post('site_title', TRUE)),
				'tagline' => ucfirst($this->input->post('site_tagline', TRUE)),
				'logo' => $upload_logo,
				);

			$this->settings_model->set_settings($settings_data);


			// Delete ===============
			$icon = $this->settings_model->site_settings();
			if(! $logo_filename){

			}else{
				$this->resize_site_logo($icon->logo);
			}

			$this->delete_site_logo($icon->logo);

			// Redirect =============
			$this->session->set_flashdata('settings_save', '<li><strong>Successfully </strong> updated!');
			redirect('admin/settings');
		}
	}

	private function site_icon()
	{
		$config = array(
			'encrypt_name' => TRUE,
			'upload_path' => './assets/img/favicon',
			'allowed_types' => 'png|jpg',
			'max_size' => '200',
		);

		$this->upload->initialize($config);
		
		$icon = $this->settings_model->site_settings();
		$icon_upload = $this->upload->do_upload('settings_site_icon');

		if(! $icon_upload){
			$icon = $icon->favicon;
		}else{
			$this->del_icon_16_32_180($icon->favicon); // Delete rapidly buy one method
			$this->del_site_icon($icon->favicon);
			$icon = $this->upload->data('file_name');
		}
		
		$data = array(
			'favicon' => $icon,
		);

		$this->settings_model->set_settings($data);	

		// Resize the following set sizes.
		$setting = $this->settings_model->site_settings();
		if(! $icon_upload){
			//
		}else{
			$this->site_icon_16_x_16($setting->favicon); // // Size 32 x 32
			$this->site_icon_32_x_32($setting->favicon); // Size 32 x 32
			$this->site_icon_180_x_180($setting->favicon); // Size 180 x 180 apple touch
		}


	}


	//==============================================================
	// Site Icon Resize and Delete Methods
	//==============================================================
	private function site_icon_180_x_180($file_name)
	{
		$config['image_library'] = 'gd2';
		$config['source_image'] = './assets/img/favicon/'.$file_name;
		$config['quality'] = '100%';
		$config['maintain_ratio'] = TRUE;
		$config['new_image']    = './assets/img/favicon/180-x-180';
		$config['width']         = 180;
		$config['height']       = 180;

		
		$this->image_lib->initialize($config);

		if ( ! $this->image_lib->resize())
		{	
			$error = $this->image_lib->display_errors();	
		    $this->session->set_flashdata('fail_img_resize_180', $error); 
		}else{
			$this->image_lib->resize();
		}
	}

	private function site_icon_16_x_16($file_name)
	{
		$config['image_library'] = 'gd2';
		$config['source_image'] = './assets/img/favicon/'.$file_name;
		$config['quality'] = '100%';
		$config['maintain_ratio'] = TRUE;
		$config['new_image']    = './assets/img/favicon/16-x-16';
		$config['width']         = 16;
		$config['height']       = 16;

		
		$this->image_lib->initialize($config);

		if ( ! $this->image_lib->resize())
		{	
			$error = $this->image_lib->display_errors();	
		    $this->session->set_flashdata('fail_img_resize_16', $error); 
		}else{
			$this->image_lib->resize();
		}
	}

	private function site_icon_32_x_32($file_name)
	{	
        $config['image_library'] = 'gd2';
		$config['source_image'] = './assets/img/favicon/'.$file_name;
		$config['quality'] = '100%';
		$config['maintain_ratio'] = TRUE;
		$config['new_image']    = './assets/img/favicon/32-x-32';
		$config['width']         = 32;
		$config['height']       = 32;

		
		$this->image_lib->initialize($config);

		if ( ! $this->image_lib->resize())
		{	
			$error = $this->image_lib->display_errors();	
		    $this->session->set_flashdata('fail_img_resize_32', $error); 
		}else{
			$this->image_lib->resize();
		}
	}

	private function del_site_icon($icon)
	{
		$file = 'assets/img/favicon/'.$icon;
		
		if(is_file($file)){
			unlink($file);
		}
	}

	private function del_icon_16_32_180($file_name)
	{	
		// Delete site icon size 16 x 16
		$del_site_16 = 'assets/img/favicon/16-x-16/'.$file_name;
		
		if(is_file($del_site_16)){
			unlink($del_site_16);
		}

		// Delete site icon size 32 x 32
		$del_site_32 = 'assets/img/favicon/32-x-32/'.$file_name;
		
		if(is_file($del_site_32)){
			unlink($del_site_32);
		}

		// Delete site icon size 180 x 180 apple touch
		$del_site_180 = 'assets/img/favicon/180-x-180/'.$file_name;
		
		if(is_file($del_site_180)){
			unlink($del_site_180);
		}
	}

	//==============================================================
	// Site Logo Resize and Delete Methods
	//==============================================================

	private function resize_site_logo($logo)
	{
        $config['image_library'] = 'gd2';
		$config['source_image'] = './assets/img/logo/'.$logo;
		$config['quality'] = '100%';
		$config['maintain_ratio'] = TRUE;
		$config['new_image']    = './assets/img/logo/200-x-100';
		$config['width']         = 200;
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

	private function delete_site_logo($delete_logo)
	{
		$file = 'assets/img/logo/'.$delete_logo;
		
		if(is_file($file)){
			unlink($file);
		}
	}

	private function delete_resize_site_logo($resize_logo)
	{
		$file = 'assets/img/logo/200-x-100/'.$resize_logo;
		
		if(is_file($file)){
			unlink($file);
		}
	}
	
}// Settings class