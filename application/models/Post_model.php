<?php
defined('BASEPATH')OR exit('No direct script access allowed');

class Post_model extends CI_Model{

	/**
	* Recent Post for admin
	*/

	public function recentPost()
	{	
		$this->db->limit(10);
		$this->db->order_by('post_id', 'DESC');
		$this->db->where('post_trash', NULL);
		$this->db->join('category', 'category_id = post_category_id', 'left');
		$query = $this->db->get('post');
		return $query->result();
	}

	/**
	* Meter Widget for admin
	*/
	public function meterPost()
	{
		$this->db->from('post');
		$this->db->where('post_trash', NULL);
		return $this->db->count_all_results();
	}

	public function meterCategory()
	{
		return $this->db->count_all('category');
	}

	public function meterTag()
	{
		return $this->db->count_all('tag');
	}

	public function meterComment()
	{
		return $this->db->count_all('comment');
	}

	/**
	* Get single post for admin
	*/

	public function getByRandomId($random_id)
	{	
		$this->db->select('*');
		$this->db->from('post');
		$this->db->where('post_random_id', $random_id);
		$query = $this->db->get();
		return $query->row();
	}

	/**
	* Restore Post for admin
	*/
	public function setRestore($random_id)
	{
		$this->db->where('post_random_id', $random_id);
		$this->db->set('post_trash', NULL);
		$this->db->update('post');
	}

	/**
	* Trash Post admin
	*/
	public function getTrash($limit, $start)
	{
		$this->db->limit($limit, $start);
		$this->db->order_by('post_id', 'DESC');
		$this->db->where('post_trash', TRUE);
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

	public function countTrash()
	{
		$this->db->from('post');
		$this->db->where('post_trash', TRUE);
		return $this->db->count_all_results();
	}


	public function setTrash($random_id)
	{
		$this->db->where('post_random_id', $random_id);
		$this->db->set('post_trash', TRUE);
		$this->db->update('post');
	}


	/**
	* Post
	*/
	public function getAll($limit, $start)
	{
		$this->db->limit($limit, $start);
		$this->db->where('post_trash', NULL);
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

	public function countAll()
	{
		$this->db->from('post');
		$this->db->where('post_trash', NULL);
		return $this->db->count_all_results();
	}

	/**
	* Mine Post
	*/
	public function getMine($limit, $start, $user_id)
	{
		$this->db->limit($limit, $start);
		$this->db->where('user_id', $user_id);
		$this->db->where('post_trash', NULL);
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

	public function countMine($user_id)
	{
		$this->db->from('post');
		$this->db->where('user_id', $user_id);
		$this->db->where('post_trash', NULL);
		return $this->db->count_all_results();
	}

	public function getPublished($limit, $start)
	{
		$this->db->limit($limit, $start);
		$this->db->where('post_published', TRUE);
		$this->db->where('post_trash', NULL);
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

	public function countPublished()
	{
		$this->db->from('post');
		$this->db->where('post_published', TRUE);
		$this->db->where('post_trash', NULL);
		return $this->db->count_all_results();
	}
	
	public function get_single($slug)
	{	
		$this->db->select('*');
		$this->db->from('post');
		$this->db->where('post_random_id', $slug);
		$this->db->where('post_trash', NULL);
		$this->db->join('category', 'category.category_id = post.post_category_id', 'left'); // Join
		$query = $this->db->get();
		return $query->row();
	}

	public function update_single($data,$id,$uid)
	{	
		$this->db->where('post_id', $id);
		$this->db->where('user_id', $uid);
		$this->db->set('post_updated','now()', FALSE);
		$this->db->update('post',$data);
	}

	public function count_list()
	{
		return $this->db->count_all('post');
	}

	public function item_list($limit, $start)
	{
		$this->db->limit($limit, $start);
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
	
	public function delete_item($id)
	{
		$this->db->where('post_id', $id);
		$this->db->delete('post');
	}

	public function delete_comment($id)
	{	
		$this->db->where('comment_post_id', $id);
		$this->db->delete('comment');
	}
	

	public function insert_new($post_data)
	{	
		$this->db->set('post_published_created', 'now()', FALSE);
		$this->db->insert('post', $post_data);
	}


	public function search($limit, $start, $match)
	{

		$this->db->limit($limit, $start);
		$this->db->like('post_title', $match);
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

	public function count_search_item($match)
	{
		$this->db->like('post_title', $match);
		$this->db->from('post');
		return $this->db->count_all_results();
	}
}