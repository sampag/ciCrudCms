<?php
defined('BASEPATH')OR exit('No direct script access allowed');

class Comment_model extends CI_Model{

	public function post_comment_count($id)
	{
		$this->db->where('comment_post_id', $id);
		$this->db->from('comment');
		return $this->db->count_all_results();
	}

	public function get_single($id)
	{
		$this->db->where('comment_post_id', $id);
		$this->db->order_by('comment_id', 'DESC');
		$query = $this->db->get('comment');
		return $query->result();
	}

	public function delete($id)
	{	
		$this->db->where('comment_id', $id);
		$this->db->delete('comment');
	}

	// Approved single row.
	public function approved($id, $status)
	{	
		$this->db->where('comment_id', $id);
		$this->db->update('comment', $status);
	}

	// Retrieve all rows in the table.
	public function get_all()
	{	
		$this->db->join('post', 'post_id = comment_post_id', 'left');
		$query = $this->db->get('comment');
		return $query->result();
	}


	// Count foreach post comment.
	public function count_post_comment($id)
	{	
		$this->db->select('*');
		$this->db->from('comment');
		$this->db->where('comment_post_id', $id);
		return $this->db->count_all_results();
	}

}