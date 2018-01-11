<?php
defined('BASEPATH')OR exit('No direct script access allowed');

class Settings_model extends CI_Model{

	public function set_settings($settings_data)
	{
		$this->db->update('settings', $settings_data);
	}

	public function site_settings()
	{
		$this->db->select('*');
		$this->db->from('settings');
		$query = $this->db->get();
		return $query->row();
	}

	public function pagination()
	{
		$query = $this->db->query("Select * FROM settings;");
		$row = $query->row();

		if(isset($row)){
			return $row->pagination;	
		}

	}

}