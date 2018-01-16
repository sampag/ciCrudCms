<?php
defined('BASEPATH')OR exit('No direct script access allowed');

class Category_model extends CI_Model{

	// Retrieve all rows in the table.
	public function get_all()
	{	
		$this->db->order_by('category_id', 'DESC');
		$query = $this->db->get('category');
		return $query->result();
	}



	public function count_uncategorized()
	{
		$this->db->where('post_category_id', FALSE);
		$this->db->from('post');
		return $this->db->count_all_results();
	}

	public function uncategorized_post($limit ,$start ,$slug)
	{
		$this->db->limit($limit, $start);
		$this->db->where('post_uncategorized_slug', $slug);
		$this->db->order_by('post_id', 'DESC');
		$this->db->join('users', 'id = user_id', 'left');
		$query = $this->db->get('post');	

		if($query->num_rows() > 0 ){
			foreach($query->result() as $row){
				$data[] = $row;
			}
			return $data;
		}else{
			return false;
		}
	}

	public function count_categorized_item($id)
	{
		$this->db->where('post_category_id', $id);
		$this->db->from('post');
		return $this->db->count_all_results();
	}

	public function categorized_single($slug)
	{
		$this->db->where('category_slug', $slug);
		$this->db->order_by('post_id', 'DESC');
		$this->db->join('post','post_category_id = category_id', 'inner');
		$query = $this->db->get('category');
		return $query->row();
	}

	public function categorized_post($limit, $start, $slug)
	{	
		// $this->db->where('category_slug', $slug);
		// $this->db->order_by('post_id', 'DESC');
		// $this->db->join('post','post_category_id = category_id', 'inner');
		// $query = $this->db->get('category');
		// return $query->result();

		$this->db->limit($limit, $start);
		$this->db->order_by('post_id', 'DESC');
		$this->db->where('category_slug', $slug);
		$this->db->join('post','post_category_id = category_id', 'inner');
		$query = $this->db->get('category');	

		if($query->num_rows() > 0 ){
			foreach($query->result() as $row){
				$data[] = $row;
			}
			return $data;
		}else{
			return false;
		}
	}


	public function categorized_user_name($id)
	{
		$this->db->where('id', $id);
		$this->db->from('users');
		$query = $this->db->get();
		$row = $query->row();

		if(isset($row)){
			return $row->first_name.' '.$row->last_name;
		}
	}

	// Insert new single row in the table.
	public function insert_new($category_data)
	{	
		$this->db->set('category_created', 'now()', FALSE);
		$this->db->insert('category', $category_data);
	}

	// Delete single row in the table.
	public function delete_single()
	{	
		$id = $this->input->get('id');
		

		if($id){
			
			$data = array(
				'post_category_id' => FALSE,
				'post_uncategorized_slug' => 'uncategorized',
			);

			$this->update_post_category($id, $data);
		}

		$this->db->where('category_id', $id);
		$this->db->delete('category');


		if($this->db->affected_rows() > 0){
			return TRUE;
			
		}else{

			return FALSE;
		}

	}

	public function edit_single($id)
	{
		$this->db->where('category_id', $id);
		$query = $this->db->get('category');
		return $query->result();
	}

	public function update_single($id, $data)
	{
		$this->db->where('category_id', $id);
		$this->db->set('category_updated', 'now()', FALSE);
		$this->db->update('category', $data);
	}

	public function update_post_category($id, $data)
	{
		$this->db->where('post_category_id', $id);
		$this->db->update('post', $data);
	}

	public function search($match)
	{
		$this->db->like('category_name',$match);
		$this->db->order_by('category_id', 'DESC');
		$query = $this->db->get('category');
		return $query->result();
	}

	public function count_search_item($match)
	{
		$this->db->like('category_name', $match);
		$this->db->from('category');
		return $this->db->count_all_results();
	}
	
}