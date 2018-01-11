<?php
defined('BASEPATH')OR exit('No direct script access allowed');

class Post_term_model extends CI_Model{

	// Insert batch of data to table.
	public function insert_tag($post_term_data)
	{	
		$this->db->insert_batch('post_term', $post_term_data);
	}

	// Delete all specific rows.
	public function delete_item($id)
	{
		$this->db->where('term_post_id', $id);
		$this->db->delete('post_term');
	}

	// Count all tag foreach post.
	public function count_post_tag($id)
	{
		$this->db->where('term_post_id', $id);
		$this->db->join('tag','tag_id = term_tag_id','left');
		$query = $this->db->get('post_term');
		return $query->result();
	}

	// Exclusive for tag function only.
	public function checked_tag($tag_id,$post_id)
	{	
		$this->db->where('term_tag_id', $tag_id);
		$this->db->where('term_post_id', $post_id);
		$query = $this->db->get('post_term');
		return $query->row();
	}


}