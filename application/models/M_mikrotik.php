<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_mikrotik extends CI_Model{

	function select_api($url){
		$this->routerosapi->write($url);
		$array = $this->routerosapi->read();
		return $array;
		$this->routerosapi->disconnect();
	}
	
	function count_monthly(){
		$tglawal = strtotime('01-'.date('m-Y'));
		$tglakhir = strtotime('31-'.date('m-Y'));
		$this->db->where('registered >=', $tglawal);
		$this->db->where('registered <=', $tglakhir);
		$this->db->from('user');
		return $this->db->count_all_results();
	}
	
	function query_api($url, $param){
		if($this->routerosapi->comm($url, $param)){
			return true;
		}else{
			return false;
		}
		$this->routerosapi->disconnect();
	}
	
	function config($key)
	{
		return $this->db->get_where('config', array('key' => $key))->row_array();
	}
	
	function check_admin()
	{
		$this->db->limit(1);
		return $this->db->get('admin');
	}
	
	function save_config($data = array())
	{
		$this->db->update_batch('config', $data, 'key');
	}
	
	function save_admin($data = array())
	{
		$cek = $this->db->get_where('admin', array('username' => $data['username']))->num_rows();
		if($cek > 0){
			$this->db->where('username', $data['username']);
			$this->db->delete('admin');
		}
		return $this->db->insert('admin', $data);
	}

	function get_user($type, $user){
		$this->db->where(array('type' => $type, 'user' => $user));
		return $this->db->get('user');
	}
	
	function syncronize($data = array()){
		$cek = $this->db->get_where('user', array('user' => $data['user']))->num_rows();
		if($cek > 0){
			return false;
		}else{
			$this->db->set($data);
			$this->db->insert('user');
			return true;
		}
	}
	
	function edit_user_hotspot($data = array()){
		$this->db->set($data);
		$this->db->where('user', $data['user']);
		$this->db->update('user');
		return true;
	}
	
	function delete_user_hotspot($user){
		$this->db->where('user', $user);
		return $this->db->delete('user');
	}
}
?>