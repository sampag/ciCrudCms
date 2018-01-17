<?php
defined('BASEPATH')OR exit('No direct script access allowed');

class Tag_model extends CI_Model{

	public function count_filter_tag($id)
	{
		$this->db->where('term_tag_id', $id);
		$this->db->from('post_term');
		return $this->db->count_all_results();
	}

	public function get_author($user_id)
	{
		$this->db->where('user_id', $user_id);
		$this->db->join('users', 'id = user_id', 'left');
		$query = $this->db->get('post');
		return $query->row();

	}

	public function get_post_category($id)
	{	
		$this->db->where('post_category_id', $id);
		$this->db->order_by('post_id', 'DESC');
		$this->db->join('category', 'category.category_id = post.post_category_id', 'left');
		$query = $this->db->get('post');
		return $query->result();
	}


	public function get_post($limit, $start, $id)
	{
		$this->db->limit($limit, $start);
		$this->db->where('term_tag_id', $id);
		$this->db->order_by('term_order', 'DESC');
		$this->db->join('post', 'post_id = term_post_id', 'left');
		$query = $this->db->get('post_term');	

		if($query->num_rows() > 0 ){
			foreach($query->result() as $row){
				$data[] = $row;
			}
			return $data;
		}else{
			return false;
		}
	}

	public function get_single($slug)
	{
		$this->db->where('tag_slug', $slug);
		$query = $this->db->get('tag');
		return $query->result();
	}

	public function get_all()
	{	
		$this->db->order_by('tag_id', 'DESC');
		$query = $this->db->get('tag');
		return $query->result();
	}

	public function insert_new($tag_data)
	{	
		$this->db->set('tag_created', 'now()', FALSE);
		$this->db->insert('tag', $tag_data);
	}

	public function delete_single()
	{
		$id = $this->input->get('id');

		if($id){
			$this->delete_post_tags($id);
		}
		
		$this->db->where('tag_id', $id);
		$this->db->delete('tag');

		if($this->db->affected_rows() > 0){
			return TRUE;
		}else{
			return FALSE;
		}

	}

	public function delete_post_tags($id)
	{	
		$this->db->where('term_tag_id', $id);
		$this->db->delete('post_term');
	}


	public function edit_single($id)
	{
		$this->db->where('tag_id', $id);
		$query = $this->db->get('tag');
		return $query->result();
	}

	public function update_single($id, $data)
	{
		$this->db->where('tag_id', $id);
		$this->db->set('tag_updated', 'now()', FALSE);
		$this->db->update('tag', $data);
	}

	public function search($match)
	{
		$this->db->like('tag_name',$match);
		$this->db->order_by('tag_id', 'DESC');
		$query = $this->db->get('tag');
		return $query->result();
	}

	public function count_search_item($match)
	{
		$this->db->like('tag_name', $match);
		$this->db->from('tag');
		return $this->db->count_all_results();
	}
}