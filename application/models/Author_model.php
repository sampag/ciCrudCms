<?php
defined('BASEPATH')OR exit('No direct script access allowed');

class Author_model extends CI_Model{

	public function get_author_profile($user_id)
	{
		$this->db->where('profile_user_id', $user_id);
		$query = $this->db->get('user_profile');
		return $query->row();
	}

	public function update_author_profile($user_id, $data)
	{	
		$this->db->where('profile_user_id', $user_id);
		$this->db->update('user_profile', $data);
	}

	public function get_author_post($limit, $start, $user_id)
	{
		$this->db->select('*');
		$this->db->from('post');
		$this->db->where('user_id', $user_id);
		$this->db->where('post_trash', NULL);
		$this->db->limit($limit, $start);
		$this->db->order_by('post_id', 'DESC');
		$this->db->join('users', 'id = user_id', 'left');
		$this->db->join('category', 'category_id = post_category_id', 'left');
		$query = $this->db->get();	

		if($query->num_rows() > 0 ){
			foreach($query->result() as $row){
				$data[] = $row;
			}
			return $data;
		}else{
			return false;
		}
	}

	public function author_post_count($u_id)
	{
		$this->db->where('user_id', $u_id);
		$this->db->where('post_trash', NULL);
		$this->db->from('post');
		return $this->db->count_all_results();
	}

}