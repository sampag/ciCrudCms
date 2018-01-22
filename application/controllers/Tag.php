<?php
defined('BASEPATH')OR exit('No direct script access allowed');

class Tag extends CI_Controller{

	public function __construct()
	{
		parent::__construct();
		$model = array('tag_model');
		$this->load->model($model);
	}

	// Default view of the tag class
	public function index()
	{
		if(! $this->ion_auth->is_admin() ){

			redirect('login');

		}else{

			$data = array(
				'header' => $this->load->view('admin/header','', TRUE),
				'javascript' => $this->load->view('admin/javascript','', TRUE),
				'footer' => $this->load->view('admin/footer','', TRUE),
				'momentjs' => '<script src="'.base_url('assets/js/moment.min.js').'"></script>',
				'mainjs' => '<script src="'.base_url('assets/js/main.js').'"></script>', // main.min.js or main.js
			);

			$this->parser->parse('admin/tag', $data);

		}
	}

	// Add new entry in tag table.
	public function tag_add()
	{
		

		if(! $this->ion_auth->is_admin() ){

			redirect('login');

		}else{

			$rules = array(
				array(
					'field' => 'tag_name',
					'label' => 'Tag name',
					'rules' => 'required|strip_tags'
				),
				array(
					'field' => 'tag_description',
					'label' => 'Tag description',
					'rules' => 'required|strip_tags'
				),
			);

			$this->form_validation->set_rules($rules);

			if( $this->form_validation->run() == FALSE ){

				$status = array(
					'errTagName' => form_error('tag_name', '<p class="text-danger">', '</p>'),
					'errTagDesc' => form_error('tag_description', '<p class="text-danger">', '</p>'),
				);

				$this->output
				->set_content_type('application/json')
				->set_output(json_encode($status));

			}else{

				$tag_name = ucfirst($this->input->post('tag_name', TRUE));

				$tag_data = array(
					'tag_name' => $tag_name,
					'tag_description' => ucfirst($this->input->post('tag_description', TRUE)),
					'tag_slug' => url_title($tag_name, 'dash', TRUE),
				);

				$this->tag_model->insert_new($tag_data);

				$status = array(
					'success' => 'Successfully added!',
				);

				$this->output
				->set_content_type('application/json')
				->set_output(json_encode($status));

			}

		}
	}

	// Retrieve all rows in the table.
	public function tag_get()
	{
		if(! $this->ion_auth->is_admin() ){

			redirect('login');

		}else{
			$tag = $this->tag_model->get_all();

			if($tag){
				$this->output
				->set_content_type('application/json')
				->set_output(json_encode($tag));
			}else{
				$message = array('message' => 'No item found');
				echo json_encode($message);
			}

		}
	}

	// Delete single row.
	public function tag_delete()
	{
		if(! $this->ion_auth->is_admin() ){

			redirect('login');

		}else{

			$result = $this->tag_model->delete_single();

			$status['success'] = FALSE;
			if($result){
				$status['success'] = TRUE;
			}

			$this->output
			->set_content_type('application/json')
			->set_output(json_encode($status));

		}
	}

	// Parse all rows using json.
	public function tag_data()
	{
		if( ! $this->ion_auth->is_admin() ){

			redirect('login');

		}else{
			
			$tag_count = $this->db->count_all('tag');

			if($tag_count > 1){

				$tag_meter = '<span class="badge badge-danger">'.$tag_count.'</span> Items';

			}else{
				$tag_meter = '<span class="badge badge-danger">'.$tag_count.'</span> Item';
			}


			$category_data = array(
				'tagCount' => $tag_meter,
			);

			$this->output
			->set_content_type('application/json')
			->set_output(json_encode($category_data));

		}
	}

	public function tag_edit($id)
	{
		if(! $this->ion_auth->is_admin() ){
			redirect('login');
		}else{
			$id = $this->uri->segment(3);
			$tag = $this->tag_model->edit_single($id);

			if(! $tag){
				return $this->error_page();
			}

			foreach($tag as $row):
				$tag_id = $row->tag_id;
				$tag_name = $row->tag_name;
				$tag_slug = $row->tag_slug;
				$tag_description = $row->tag_description;
			endforeach;

			$data = array(
				'header' => $this->load->view('admin/header','', TRUE),
				'id' => $tag_id,
				'name' => $tag_name,
				'slug' => $tag_slug,
				'description' => $tag_description,
				'javascript' => $this->load->view('admin/javascript','', TRUE),
				'footer' => $this->load->view('admin/footer','', TRUE)
			);

			$this->parser->parse('admin/tag_edit', $data);

		}
	}

	public function tag_update($id)
	{
		if(! $this->ion_auth->is_admin()){
			redirect('login');
		}else{

			$id = $this->uri->segment(2);

			$rules = array(
				array(
					'field' => 'tag_update_name',
					'label' => 'Tag name',
					'rules' => 'required|strip_tags'
				),
				array(
					'field' => 'tag_update_slug',
					'label' => 'Tag slug',
					'rules' => 'required|strip_tags'
				),
				array(
					'field' => 'tag_update_description',
					'label' => 'Category slug',
					'rules' => 'strip_tags'
				),
			);

			$this->form_validation->set_rules($rules);

			if($this->form_validation->run() == FALSE){

				$this->session->set_flashdata('tag_name_failed', form_error('tag_update_name'));
				$this->session->set_flashdata('tag_slug_failed', form_error('tag_update_slug'));
				$this->session->set_flashdata('tag_update_failed', validation_errors('<li><strong>Error </strong>', '</li>'));
				redirect('admin/tag-edit/'. $id);

			}else{
				$data = array(
					'tag_name' => ucfirst($this->input->post('tag_update_name',TRUE)),
					'tag_slug' => lcfirst($this->input->post('tag_update_slug', TRUE)),
					'tag_description' => $this->input->post('tag_update_description'),
				);
			
				$this->tag_model->update_single($id, $data);

				$back = anchor('admin/tag', 'Back');
				$tag_success = $this->session->set_flashdata('tag_update_success', '<li><strong>Successfully updated! '. $back );

				redirect('admin/tag-edit/'. $id);
			}
		}
	}

	private function error_page()
	{
		if(! $this->ion_auth->is_admin()){
			redirect('login');
		}else{
			$this->load->view('admin/header');
			$this->load->view('admin/error');
			$this->load->view('admin/javascript');
			$this->load->view('admin/footer');
		}
	}


	public function tag_search()
	{
		if(! $this->ion_auth->is_admin()){
			redirect('login');
		}else{
			$rules = array(
				array(
					'field' => 'search_tag_name',
					'label' => 'Tag name',
					'rules' => 'required|strip_tags|xss_clean'
					),
			);

			$this->form_validation->set_rules($rules);

			if($this->form_validation->run() == FALSE){

				redirect('admin/tag');

			}else{

				$match = $this->input->post('search_tag_name', TRUE);
				$url_match = str_replace(' ', ' ', $match);

				redirect('tag/tag-search-result/'. urlencode($url_match));

			}
		}
	}

	public function tag_search_result($match = NULL)
	{
		if(! $this->ion_auth->is_admin()){
			redirect('login');
		}else{
			if($match == NULL){
				return $this->error_page();
			}

			$tag = $this->tag_model->search(str_replace('+', ' ', $match));

			$count = $this->tag_model->count_search_item(str_replace('+', ' ', $match));

			if($count > 1){
				$tag_count = '<span class="badge badge-danger">'.$count.'</span> Items - Search results for "'.str_replace('+', ' ', $match).'"';
			}else{
				$tag_count = '<span class="badge badge-danger">'.$count.'</span> Item - Search results for "'.str_replace('+', ' ', $match).'"';
			}

			$data = array(
				'header' => $this->load->view('admin/header','', TRUE),
				'match' => str_replace('+', ' ', $match),
				'tags' => $tag,
				'count_and_match' => $tag_count,
				'javascript' => $this->load->view('admin/javascript','', TRUE),
				'footer' => $this->load->view('admin/footer','', TRUE)
			);

			$this->parser->parse('admin/tag_search', $data);
		}	
	}
}