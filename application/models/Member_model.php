<?php
defined('BASEPATH')OR exit('No direct script access allowed');

class Member_model extends CI_Model{

	// All
	public function getAll($limit, $start)
	{	
		$this->db->limit($limit, $start);
		$this->db->order_by('post_id', 'DESC');
		$this->db->join('category', 'category.category_id = post.post_category_id', 'left');
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

	public function countAll()
	{
		return $this->db->count_all('post');
	}

	//================================================//
	// Mine
	public function getMine($limit, $start, $user_id)
	{
		$this->db->limit($limit, $start);
		$this->db->where('user_id', $user_id);
		$this->db->order_by('post_id', 'DESC');
		$this->db->join('category', 'category.category_id = post.post_category_id', 'left');
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

	public function countMine($user_id)
	{
		$this->db->from('post');
		$this->db->where('user_id', $user_id);
		return $this->db->count_all_results();
	}	
	//================================================//
	// Published

	public function getPublished($limit, $start)
	{
		$this->db->limit($limit, $start);
		$this->db->where('post_published', TRUE);
		$this->db->order_by('post_id', 'DESC');
		$this->db->join('category', 'category.category_id = post.post_category_id', 'left');
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

	public function countPublished()
	{
		$this->db->from('post');
		$this->db->where('post_published', TRUE);
		return $this->db->count_all_results();
	}


	//==========================
	// Tags
	//==========================
	public function post_tag_count($id, $user_id)
	{
		$this->db->where('term_tag_id', $id);
		$this->db->where('term_user_id', $user_id);
		$this->db->from('post_term');
		return $this->db->count_all_results();
	}

	public function post_tag($id, $user_id)
	{
		$this->db->where('term_tag_id', $id); // Tag ID
		$this->db->where('term_user_id', $user_id); // User ID
		$this->db->order_by('term_order', 'DESC');
		$this->db->join('post', 'post_id = term_post_id', 'left');
		$query = $this->db->get('post_term');
		return $query->result();
	}


	//==========================
	// Comment by comment_user_id
	//==========================
	public function delete_comment($comment_id, $user_id)
	{	
		$this->db->where('comment_id', $comment_id);
		$this->db->where('comment_user_id', $user_id);
		$this->db->delete('comment');
	}

	public function get_comment($user_id)
	{
		$this->db->where('comment_user_id', $user_id);
		$this->db->order_by('comment_id','DESC');
		$this->db->join('post', 'post_id = comment_post_id', 'left');
		$query = $this->db->get('comment');
		return $query->result();
	}


	//==========================
	// Uncategorized Post by users and uncategorized slug.
	//==========================
	public function uncategorized_post($u_slug, $u_id)
	{	
		$this->db->where('user_id', $u_id);
		$this->db->where('post_uncategorized_slug', $u_slug);
		$this->db->order_by('post_id', 'DESC');
		$query = $this->db->get('post');
		return $query->result();
	}

	public function count_uncategorized_post($uc_slug, $u_id)
	{
		$this->db->where('user_id', $u_id);
		$this->db->where('post_uncategorized_slug', $uc_slug);
		$this->db->from('post');
		return $this->db->count_all_results();
	}

	//==========================
	// Categorized Post by users and category slug.
	//==========================
	public function count_categorized_post($u_id, $c_id)
	{
		$this->db->where('user_id', $u_id);
		$this->db->where('post_category_id', $c_id);
		$this->db->from('post');
		return $this->db->count_all_results();
	}


	public function categorized_post($categorized_slug, $id)
	{	
		$this->db->where('user_id', $id);
		$this->db->where('category_slug', $categorized_slug);
		$this->db->order_by('post_id', 'DESC');
		$this->db->join('post','post_category_id = category_id', 'inner');
		$query = $this->db->get('category');
		return $query->result();
	}


	//==========================
	// Post
	//==========================
	public function delete_post($id, $user_id)
	{
		$this->db->where('post_id', $id);
		$this->db->where('user_id', $user_id);
		$this->db->delete('post');
	}


	public function item_list($limit, $start, $user_id)
	{	
		$this->db->where('user_id', $user_id);
		$this->db->limit($limit, $start);
		$this->db->order_by('post_id', 'DESC');
		$this->db->join('category', 'category_id = post_category_id', 'left');
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

	public function get_recent_post($user_id)
	{	
		$this->db->select('*');
		$this->db->from('post');
		$this->db->where('user_id', $user_id);
		$this->db->limit(10);
		$this->db->order_by('post_id', 'DESC');
		$this->db->join('category','category_id = post_category_id', 'left');
		$query = $this->db->get();
		return $query->result();
	}

	public function delete_item($id)
	{
		$this->db->where('post_id', $id);
		$this->db->delete('post');		
	}


	//==========================
	// Counts
	//==========================
	public function count_comment($user_id)
	{	
		$this->db->where('comment_user_id', $user_id);
		$this->db->from('comment');
		return $this->db->count_all_results();
	}

	public function count_tag()
	{
		return $this->db->count_all_results('tag');
	}
	
	public function count_category()
	{
		return $this->db->count_all_results('category');
	}

	public function count_post($user_id)
	{
		$this->db->where('user_id', $user_id);
		$this->db->from('post');
		return $this->db->count_all_results();
	}
}