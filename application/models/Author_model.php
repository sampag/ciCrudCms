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

	public function get_author_post($u_id)
	{
		$this->db->where('user_id', $u_id);
		$this->db->from('post');
		$this->db->join('users', 'id = user_id', 'left');
		$this->db->join('category', 'category_id = post_category_id', 'left');
		$query = $this->db->get();
		return $query->result();
	}

	public function author_post_count($u_id)
	{
		$this->db->where('user_id', $u_id);
		$this->db->from('post');
		return $this->db->count_all_results();
	}

}