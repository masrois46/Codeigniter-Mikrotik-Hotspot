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
				$this->ci->session->set_flashdata('TITLE', $this->ci->m_mikrotik->config('TITLE')['value']);
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
}
?>