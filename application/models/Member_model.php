<?php
defined('BASEPATH')OR exit('No direct script access allowed');

class Member_model extends CI_Model{

	/*
	* Delete single comment for member user
	*/
	public function delete_permanently_comment($comment_id, $user_id)
	{	
		$this->db->where('comment_id', $comment_id);
		$this->db->where('comment_trash', TRUE);
		$this->db->where('comment_user_id', $user_id);
		$this->db->delete('comment');
	}

	/*
	* Unapproved single comment for member user
	*/
	public function set_unapproved($comment_id, $comment_user_id)
	{
		$this->db->where('comment_id', $comment_id);
		$this->db->where('comment_user_id', $comment_user_id);
		$this->db->set('comment_approved', FALSE);
		$this->db->update('comment');
	}

	/*
	* Trash multiple comment for member users
	*/
	public function set_trash_multiple($comment_id, $user_id)
	{
		$this->db->where('comment_id', $comment_id);
		$this->db->where('comment_user_id', $user_id);
		$this->db->set('comment_trash', TRUE);
		$this->db->update('comment');
		 return $this->db->affected_rows();
	}

	/*
	* Trash single comment for member user
	*/
	public function set_trash($comment_id, $user_id)
	{
		$this->db->where('comment_id', $comment_id);
		$this->db->where('comment_user_id', $user_id);
		$this->db->set('comment_trash', TRUE);
		$this->db->update('comment');
	}

	/*
	* Restore multiple comment for member user
	*/
	public function restore_multiple_comment($comment_id, $user_id)
	{
		$this->db->where('comment_id', $comment_id);
		$this->db->where('comment_user_id', $user_id);
		$this->db->set('comment_trash', FALSE);
		$this->db->update('comment');
		 return $this->db->affected_rows();
	}

	/*
	* Restore single comment for member user
	*/
	public function comment_restore($comment_id, $user_id)
	{
		$this->db->where('comment_id', $comment_id);
		$this->db->where('comment_user_id', $user_id);
		$this->db->set('comment_trash', FALSE);
		$this->db->update('comment');
	}

	/*
	* Get trash comment
	*/
	public function count_trash_comment($user_id)
	{
		$this->db->from('comment');
		$this->db->join('post', 'post_id = comment_post_id', 'left');
		$this->db->where('comment_user_id', $user_id);
		$this->db->where('post_trash', NULL);
		$this->db->where('comment_trash', TRUE);
		return $this->db->count_all_results();
	}

	public function get_trash_comment($limit, $start, $user_id)
	{
		$this->db->limit($limit, $start);
		$this->db->join('post', 'post_id = comment_post_id', 'left');
		$this->db->where('comment_user_id', $user_id);
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

	/**
	* Get single post by random id and user id
	*/

	public function get_single($slug, $user_id)
	{	
		$this->db->select('*');
		$this->db->from('post');
		$this->db->where('post_random_id', $slug);
		$this->db->where('user_id', $user_id);
		$this->db->where('post_trash', NULL);
		$this->db->join('category', 'category.category_id = post.post_category_id', 'left'); // Join
		$query = $this->db->get();
		return $query->row();
	}

	/**
	* Trash multiple post by random_id and user_id
	*/
	public function trashMultiplePost($random_id, $user_id)
	{
		 $this->db->where('post_random_id', $random_id);
		 $this->db->where('user_id', $user_id);
		 $this->db->set('post_trash', TRUE);
	     $this->db->update('post');
	     return $this->db->affected_rows();
	}

	/**
	* Restore multiple post
	*/
	public function restoreMultiplePost($random_id, $user_id)
	{
		 $this->db->where('post_random_id', $random_id);
		 $this->db->where('user_id', $user_id);
		 $this->db->set('post_trash', NULL);
	     $this->db->update('post');
	     return $this->db->affected_rows();
	}


	/**
	* Restore single Post from trash list
	*/
	public function setRestore($random_id, $id)
	{
		$this->db->where('post_random_id', $random_id);
		$this->db->where('user_id', $id);
		$this->db->set('post_trash', NULL);
		$this->db->update('post');
	}

	/*
	* Trash single post and by id
	*/
	public function setTrash($random_id, $id)
	{
		$this->db->where('post_random_id', $random_id);
		$this->db->where('user_id', $id);
		$this->db->set('post_trash', TRUE);
		$this->db->update('post');
	}

	/*
	* Trash post for member
	*/

	public function countTrash($id)
	{
		$this->db->from('post');
		$this->db->where('post_trash', TRUE);
		$this->db->where('user_id', $id);
		return $this->db->count_all_results();
	}

	public function getTrash($limit, $start, $id)
	{
		$this->db->limit($limit, $start);
		$this->db->where('user_id', $id);
		$this->db->where('post_trash', TRUE);
		$this->db->order_by('post_id', 'DESC');
		$this->db->join('category', 'category_id = post_category_id', 'left');
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

	public function count_search_item($match, $user_id)
	{
		$this->db->like('post_title', $match);
		$this->db->where('user_id', $user_id);
		$this->db->from('post');
		return $this->db->count_all_results();
	}

	public function search($limit, $start, $match, $user_id)
	{
		$this->db->limit($limit, $start);
		$this->db->like('post_title', $match);
		$this->db->where('user_id', $user_id);
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

	// All
	public function getAll($limit, $start)
	{	
		$this->db->limit($limit, $start);
		$this->db->order_by('post_id', 'DESC');
		$this->db->where('post_trash', NULL);
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
		$this->db->where('post_trash', NULL);
		$this->db->from('post');
		return $this->db->count_all_results();
	}

	//================================================//
	// Mine
	public function getMine($limit, $start, $user_id)
	{
		$this->db->limit($limit, $start);
		$this->db->where('user_id', $user_id);
		$this->db->where('post_trash', NULL);
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
		$this->db->where('user_id', $user_id);
		$this->db->where('post_trash', NULL);
		$this->db->from('post');
		return $this->db->count_all_results();
	}	
	//================================================//
	// Published

	public function getPublished($limit, $start)
	{
		$this->db->limit($limit, $start);
		$this->db->where('post_published', TRUE);
		$this->db->where('post_trash', NULL);
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
		$this->db->where('post_trash', NULL);
		return $this->db->count_all_results();
	}


	//==========================
	// Tags
	//==========================
	public function post_tag_count($id, $user_id)
	{
		$this->db->where('term_tag_id', $id);
		$this->db->where('term_user_id', $user_id);
		$this->db->join('post', 'post_id = term_post_id', 'left');
		$this->db->where('post_trash', NULL);
		$this->db->from('post_term');
		return $this->db->count_all_results();
	}

	public function post_tag( $limit, $start, $id, $user_id )
	{
		$this->db->limit($limit, $start);
		$this->db->where('term_tag_id', $id); // Tag ID
		$this->db->where('term_user_id', $user_id); // User ID
		$this->db->order_by('term_order', 'DESC');
		$this->db->join('post', 'post_id = term_post_id', 'left');
		$this->db->where('post_trash', NULL);
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


	public function get_comment($limit, $start, $user_id)
	{
		$this->db->limit($limit, $start);
		$this->db->order_by('comment_id','DESC');
		$this->db->join('post', 'post_id = comment_post_id', 'left');
		$this->db->where('comment_user_id', $user_id);
		$this->db->where('post_trash', NULL);
		$this->db->where('comment_trash', FALSE);
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

	public function comment_approved($comment_id, $user_id)
	{
		$this->db->where('comment_id', $comment_id);
		$this->db->where('comment_user_id', $user_id);
		$this->db->set('comment_approved', TRUE);
		$this->db->update('comment');
	}

	public function count_comment_for($user_id)
	{
		$this->db->from('comment');
		$this->db->join('post', 'post_id = comment_post_id', 'left');
		$this->db->where('post_trash', NULL);
		$this->db->where('comment_user_id', $user_id);
		$this->db->where('comment_trash', FALSE);
		return $this->db->count_all_results();
	}

	/*-------------------------------
	*  Uncategorized Post by users and uncategorized slug.
	/*-------------------------------*/
	public function uncategorized_post($limit, $start ,$slug, $id)
	{	
		$this->db->limit($limit, $start);
		$this->db->where('user_id', $id);
		$this->db->where('post_uncategorized_slug', $slug);
		$this->db->where('post_trash', NULL);
		$this->db->order_by('post_id', 'DESC');
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

	public function count_uncategorized_post($slug, $id)
	{
		$this->db->where('user_id', $id);
		$this->db->where('post_uncategorized_slug', $slug);
		$this->db->where('post_trash', NULL);
		$this->db->from('post');
		return $this->db->count_all_results();
	}

	/*-------------------------------
	* Categorized Post by users and category slug.
	/*-------------------------------*/
	public function count_categorized_post($u_id, $c_id)
	{
		$this->db->where('user_id', $u_id);
		$this->db->where('post_category_id', $c_id);
		$this->db->where('post_trash', NULL);
		$this->db->from('post');
		return $this->db->count_all_results();
	}

	public function get_single_category($slug)
	{
		$this->db->select('category_id');
		$this->db->from('category');
		$this->db->where('category_slug', $slug);
		$query = $this->db->get();
		return $query->row();
	}


	public function categorized_post($limit, $start, $slug, $id)
	{	
		$this->db->limit($limit, $start);
		$this->db->where('user_id', $id);
		$this->db->where('category_slug', $slug);
		$this->db->where('post_trash', NULL);
		$this->db->order_by('post_id', 'DESC');
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


	//==========================
	// Post
	//==========================
	public function getSingle($random_id, $user_id)
	{
		$this->db->select('post_id, post_featured_img');
		$this->db->from('post');
		$this->db->where('post_random_id', $random_id);
		$this->db->where('user_id', $user_id);
		$query = $this->db->get();
		return $query->row();
	}

	public function delete_post($random_id, $user_id)
	{
		$this->db->where('post_random_id', $random_id);
		$this->db->where('user_id', $user_id);
		$this->db->where('post_trash', TRUE);
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
		$this->db->limit(10);
		$this->db->from('post');
		$this->db->where('user_id', $user_id);
		$this->db->where('post_trash', NULL);
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
		$this->db->from('comment');
		$this->db->where('comment_user_id', $user_id);
		$this->db->where('comment_trash', FALSE);
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
		$this->db->where('post_trash', NULL);
		$this->db->from('post');
		return $this->db->count_all_results();
	}

	public function count_post_comment($id)
	{	
		$this->db->from('comment');
		$this->db->where('comment_post_id', $id);
		$this->db->where('comment_trash', FALSE);
		return $this->db->count_all_results();
	}
}