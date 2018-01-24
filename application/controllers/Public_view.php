<?php
defined('BASEPATH')OR exit('No direct script access allowed');

class Public_view extends CI_Controller{

	public function __construct()
	{
		parent::__construct();
	}

	private function header()
	{	
		
		$site = $this->settings_model->site_settings();

		// Site title
		if($site->title == NULL){
			$site_title = NULL;
		}else{
			$site_title = $site->title;
		}

		if($site->tagline == NULL){
			$site_tagline = NULL;
		}else{
			$site_tagline = $site->tagline;
		}

		// Favicons
		if(! $site->favicon){
		    $favicon_16_x_16   = NULL;
		    $favicon_32_x_32   = NULL;
		    $favicon_180_x_180 = NULL;
		}else{

		    // For 180 x 180 apple touch
		    $favicon_180_x_180_prop = array(
		        'href'  => 'assets/img/favicon/180-x-180/'.$site->favicon,
		        'rel'   => 'apple-touch-icon',
		        'type'  => 'image/png',
		        'sizes' => '180x180'
		    );

		    // For 16 x 16
		    $favicon_16_x_16_prop = array(
		        'href'  => 'assets/img/favicon/16-x-16/'.$site->favicon,
		        'rel'   => 'icon',
		        'type'  => 'image/png',
		        'sizes' => '16x16'
		    );

		    // For 32 x 32
		    $favicon_32_x_32_prop = array(
		        'href'  => 'assets/img/favicon/32-x-32/'.$site->favicon,
		        'rel'   => 'icon',
		        'type'  => 'image/png',
		        'sizes' => '32x32'
		    );
		    
		    $favicon_180_x_180 = link_tag($favicon_180_x_180_prop);
		    $favicon_32_x_32   = link_tag($favicon_32_x_32_prop);
		    $favicon_16_x_16   = link_tag($favicon_16_x_16_prop);
		    
		}

		$meta = array(
			array(
				'name'    => 'robots',
				'content' => 'index, follow'
			),
			array(
				'name'    => 'Content-type',
                'content' => 'text/html; charset=utf-8', 'type' => 'equiv'
			),
			array(
				'name'    => 'X-UA-Compatible',
				'content' => 'IE=edge',
				'type'    => 'equiv'
			),
			array(
				'name'    => 'viewport',
				'content' => 'width=device-width, initial-scale=1, , user-scalable=no'
			),
			array(
				'name'    => 'description',
				'content' => $site_tagline,
			),
			array(
				'name'    => 'keywords',
				'content' => 'keyword, keyword, keyword, keyword'
			),

		);

		$data = array(
			'meta'             => $meta,
			'site_title'       => $site_title,
			'site_description' => $site_tagline,
			'favicon_180'      => $favicon_180_x_180,
			'favicon_32'       => $favicon_32_x_32,
			'favicon_16'       => $favicon_16_x_16,
		);

		$this->parser->parse('public/header', $data);
	}


	// Content
	public function post_all()
	{	
		$data = array(
			'header'     => $this->header(),
			'javascript' => $this->load->view('public/javascript','', TRUE),
			'footer'     => $this->load->view('public/footer','', TRUE),
		);

		$this->parser->parse('public/post', $data);
	}

	public function post_single()
	{

	}

	public function post_recent()
	{

	}

	public function post_categorized()
	{

	}

	public function post_uncategorized()
	{

	}

	public function post_tag()
	{

	}
}