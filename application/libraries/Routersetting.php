<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Routersetting{

	private $host;
	private $user;
	private $pass;
	
	function __construct()
	{
		$this->ci =& get_instance();
		$this->ci->load->model('m_mikrotik');
		if($this->ci->uri->segment(1) != 'setup' && $this->ci->uri->segment(1) != 'cek-mikrotik'){
			if($this->check_config()){
				$this->host = $this->ci->m_mikrotik->config('MIKROTIK_HOST')['value'];
				$this->user = $this->ci->m_mikrotik->config('MIKROTIK_USER')['value'];
				$this->pass = $this->ci->m_mikrotik->config('MIKROTIK_PASS')['value'];
				$this->ci->session->set_flashdata('TITLE', $this->datatitle());
				if($this->check_connect()){
					return true;
				}else{
					echo 'Koneksi ke mikrotik gagal, silakan cek configurasi di <strong>application/config/mikrotik.php</strong>';
					die();
				}
			}else{
				echo 'Silakan setting konfirguasi Mikrotik terlebih dahulu <a href="'.base_url('setup').'">Click Here</a>';
				die();
			}
		}
	}
	
	function datatitle()
	{
		if($this->ci->routerosapi->connect($this->host, $this->user, $this->pass)){
			$title = $this->ci->m_mikrotik->select_api('/system/identity/print');
			return $title[0]['name'];
		}else{
			return false;
		}
	}
	
	function check_connect()
	{
		if($this->ci->routerosapi->connect($this->host, $this->user, $this->pass)){
			return true;
		}else{
			return false;
		}
	}
	
	function check_config()
	{
		if($this->ci->m_mikrotik->config('MIKROTIK_HOST')['value'] != NULL && $this->ci->m_mikrotik->config('MIKROTIK_USER')['value'] != NULL && $this->ci->m_mikrotik->config('MIKROTIK_PASS')['value'] != NULL && $this->ci->m_mikrotik->check_admin()->num_rows() >0 ){
			return true;
		}else{
			return false;
		}
	}
	
	function formatDateTime($dtm)
	{
		$val_conver = $dtm; 
		$new_format = str_replace("s", "s", str_replace("m", "m ", str_replace("h", "h ", str_replace("d", "d ", str_replace("w", "w ", $val_conver)))));
		return $new_format;
	}
}
?>