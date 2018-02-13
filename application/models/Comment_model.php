<?php
defined('BASEPATH')OR exit('No direct script access allowed');

class Comment_model extends CI_Model{

	public function delete_comment_permanently($comment_id)
	{
		$this->db->where('comment_id', $comment_id);
		$this->db->where('comment_trash', TRUE);
		$this->db->delete('comment');
	}

	public function trash_comment($id)
	{
		$this->db->where('comment_id', $id);
		$this->db->set('comment_trash', TRUE);
		$this->db->update('comment');
	}

	public function trash_multiple_comment($comment_id)
	{
		$this->db->where('comment_id', $comment_id);
		$this->db->set('comment_trash', TRUE);
		$this->db->update('comment');
		 return $this->db->affected_rows();
	}

	public function post_comment_count($id)
	{
		$this->db->where('comment_post_id', $id);
		$this->db->where('comment_trash', FALSE);
		$this->db->from('comment');
		return $this->db->count_all_results();
	}

	public function get_single($id)
	{
		$this->db->where('comment_post_id', $id);
		$this->db->where('comment_trash', FALSE);
		$this->db->order_by('comment_id', 'DESC');
		$query = $this->db->get('comment');
		return $query->result();
	}

	public function restore_multiple($comment_id)
	{
		$this->db->where('comment_id', $comment_id);
		$this->db->set('comment_trash', FALSE);
		$this->db->update('comment');
		 return $this->db->affected_rows();
	}

	// Restore single and array of comment
	public function restore($comment_id)
	{
		$this->db->where('comment_id', $comment_id);
		$this->db->set('comment_trash', FALSE);
		$this->db->update('comment');
	}

	// Approved single comment.
	public function approved($id, $status)
	{	
		$this->db->where('comment_id', $id);
		$this->db->update('comment', $status);
	}

	// Unapproved single comment.
	public function unapproved($comment_id)
	{
		$this->db->where('comment_id', $comment_id);
		$this->db->set('comment_approved', FALSE);
		$this->db->update('comment');
	}

	public function get_trash($limit, $start)
	{
		$this->db->limit($limit, $start);
		$this->db->join('post', 'post_id = comment_post_id', 'left');
		$this->db->where('post_trash', NULL);
		$this->db->where('comment_trash', TRUE);
		$this->db->order_by('comment_id', 'DESC');
		$query = $this->db->get('comment');

		if($query->num_rows() > 0 ){
			foreach($query->result() as $row){
				$data[] = $row;
			}
			return $data;
		}else{
			return false;
		}
	}

	public function count_trash()
	{
		$this->db->from('comment');
		$this->db->join('post', 'post_id = comment_post_id', 'left');
		$this->db->where('post_trash', NULL);
		$this->db->where('comment_trash', TRUE);
		return $this->db->count_all_results();
	}

	// Retrieve all rows in the table.
	public function get_all($limit, $start)
	{	
		$this->db->limit($limit, $start);
		$this->db->join('post', 'post_id = comment_post_id', 'left');
		$this->db->where('post_trash', NULL);
		$this->db->where('comment_trash', FALSE);
		$this->db->order_by('comment_id', 'DESC');
		$query = $this->db->get('comment');

		if($query->num_rows() > 0 ){
			foreach($query->result() as $row){
				$data[] = $row;
			}
			return $data;
		}else{
			return false;
		}
	}

	public function count_admin_comment()
	{	
		$this->db->from('comment');
		$this->db->join('post', 'post_id = comment_post_id', 'left');
		$this->db->where('post_trash', NULL);
		$this->db->where('comment_trash', FALSE);
		return $this->db->count_all_results();
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