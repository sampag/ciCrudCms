<?php
defined('BASEPATH')OR exit('No direct script access allowed');

class Category extends CI_Controller{

	public function __construct()
	{
		parent::__construct();
		
		if(! $this->ion_auth->is_admin() ){
			redirect('login');
		}
	}

	// Default view of the category class
	public function index()
	{
		
			$data = array(
				'header' => $this->load->view('admin/header','', TRUE),
				'javascript' => $this->load->view('admin/javascript','', TRUE),
				'footer' => $this->load->view('admin/footer','', TRUE),
				'momentjs' => '<script src="'.base_url('assets/js/moment.min.js').'"></script>',
			);

			$this->parser->parse('admin/category', $data);
		
	}

	// Add new entry in category table.
	public function category_add()
	{

			$rules = array(
				array(
					'field' => 'category_name',
					'label' => 'Category name',
					'rules' => 'required|strip_tags'
				),
				array(
					'field' => 'category_description',
					'label' => 'Category decription',
					'rules' => 'required|strip_tags'
				),
			);

			$this->form_validation->set_rules($rules);

			if( $this->form_validation->run() == FALSE ){

				$status = array(
					'errCatName' => form_error('category_name', '<p class="text-danger">', '</p>'),
					'errCatDesc' => form_error('category_description', '<p class="text-danger">', '</p>'),
				);

				$this->output
				->set_content_type('application/json')
				->set_output(json_encode($status));

			}else{
				$cat_name = ucfirst($this->input->post('category_name', TRUE));
				$cat_description = ucfirst($this->input->post('category_description', TRUE));

				$category_data = array(
					'category_name' => $cat_name,
					'category_description' => $cat_description,
					'category_slug' => url_title($cat_name, 'dash', TRUE),
				);

				$this->category_model->insert_new($category_data);

				$status = array(
					'success' => $this->input->post('category_name', TRUE),
				);

				$this->output
				->set_content_type('application/json')
				->set_output(json_encode($status));

			}
	}

	// Retrieve all rows in the table.
	public function category_get()
	{
		
			$category = $this->category_model->get_all();	

			if($category){
				$this->output
				->set_content_type('application/json')
				->set_output(json_encode($category));
			}else{
				$message = array('message' => 'No item found');

				$this->output
				->set_content_type('application/json')
				->set_output(json_encode($message));
			}
	}

	// Parse all rows using json.
	public function category_data()
	{

		$cat_count = $this->db->count_all('category');

		if($cat_count > 1){

			$cat_meter = '<span class="badge badge-danger">'.$cat_count.'</span> Items';

		}else{
			$cat_meter = '<span class="badge badge-danger">'.$cat_count.'</span> Item';
		}


		$category_data = array(
			'name' => $this->security->get_csrf_token_name(),
		    'hash' => $this->security->get_csrf_hash(),
			'categoryCount' => $cat_meter,
		);

		$this->output
		->set_content_type('application/json')
		->set_output(json_encode($category_data));

	}

	// Delete single category.
	public function category_delete()
	{
		
			$result = $this->category_model->delete_single();

			$status['success'] = FALSE;
			if($result){
				$status['success'] = TRUE;
			}

			$this->output
			->set_content_type('application/json')
			->set_output(json_encode($status));
	}

	public function error_page()
	{
		
			$this->load->view('admin/header');
			$this->load->view('admin/error');
			$this->load->view('admin/javascript');
			$this->load->view('admin/footer');
		
	}

	public function category_edit($id)
	{
		
			$id = $this->uri->segment(3);
			$category = $this->category_model->edit_single($id);

			if(! $category){
				return $this->error_page();
			}

			foreach($category as $row):
				$cat_id = $row->category_id;
				$cat_name = $row->category_name;
				$cat_slug = $row->category_slug;
				$cat_description = $row->category_description;
			endforeach;

			$data = array(
				'header' => $this->load->view('admin/header','', TRUE),
				'id' => $cat_id,
				'name' => $cat_name,
				'slug' => $cat_slug,
				'description' => $cat_description,
				'javascript' => $this->load->view('admin/javascript','', TRUE),
				'footer' => $this->load->view('admin/footer','', TRUE)
			);

			$this->parser->parse('admin/category_edit', $data);

	}

	public function category_update($id)
	{
	
			$id = $this->uri->segment(2);

			$rules = array(
				array(
					'field' => 'cat_update_name',
					'label' => 'Category name',
					'rules' => 'required|strip_tags'
				),
				array(
					'field' => 'cat_update_slug',
					'label' => 'Category slug',
					'rules' => 'required|strip_tags'
				),
				array(
					'field' => 'cat_update_description',
					'label' => 'Category slug',
					'rules' => 'strip_tags'
				),
			);

			$this->form_validation->set_rules($rules);

			if($this->form_validation->run() == FALSE){

				$this->session->set_flashdata('cat_name_failed', form_error('cat_update_name'));
				$this->session->set_flashdata('cat_slug_failed', form_error('cat_update_slug'));
				$this->session->set_flashdata('cat_update_failed', validation_errors('<li><strong>Error </strong>', '</li>'));
				redirect('admin/category-edit/'.$id);

			}else{

				$data = array(
					'category_name' => ucfirst($this->input->post('cat_update_name', TRUE)),
					'category_slug' => lcfirst($this->input->post('cat_update_slug', TRUE)),
					'category_description' => $this->input->post('cat_update_description',TRUE),
				);

				$this->category_model->update_single($id, $data);

				$back = anchor('admin/category', 'Back');
				$category = ucfirst($this->input->post('cat_update_name', TRUE));

				$this->session->set_flashdata('cat_update_success', '<li><strong>Successfully </strong> updated! '.$back.'</li >');

				redirect('admin/category-edit/'. $id);
			}
	}

	public function category_search()
	{
		
			$rules = array(
				array(
					'field' => 'search_cat_name',
					'label' => 'Category name',
					'rules' => 'required|strip_tags|xss_clean'
					),
			);

			$this->form_validation->set_rules($rules);

			if($this->form_validation->run() == FALSE){

				redirect('admin/category');

			}else{

				$match = $this->input->post('search_cat_name', TRUE);
				$url_match = str_replace(' ', ' ', $match);

				redirect('category/category-search-result/'. urlencode($url_match));

			}
	}

	public function category_search_result($match = NULL)
	{
		
			if($match == NULL){
				return $this->error_page();
			}

			$category = $this->category_model->search(str_replace('+', ' ', $match));

			$count = $this->category_model->count_search_item(str_replace('+', ' ', $match));

			if($count > 1){
				$cat_count = '<span class="badge badge-danger">'.$count.'</span> Items - Search results for "'.str_replace('+', ' ', $match).'"';
			}else{
				$cat_count = '<span class="badge badge-danger">'.$count.'</span> Item - Search results for "'.str_replace('+', ' ', $match).'"';
			}

			$data = array(
				'header' => $this->load->view('admin/header','', TRUE),
				'match' => str_replace('+', ' ', $match),
				'categories' => $category,
				'count_and_match' => $cat_count,
				'javascript' => $this->load->view('admin/javascript','', TRUE),
				'footer' => $this->load->view('admin/footer','', TRUE)
			);

			$this->parser->parse('admin/category_search', $data);


	}


}
