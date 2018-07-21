<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Auth{

	function __construct(){
		$this->ci =& get_instance();
	}
	
	function cek(){
		$this->cek_cookie();
		if(empty($this->ci->session->userdata('adm_auth'))){
			echo '<script>alert("Silakan Login!"); window.location.replace("'.base_url('login').'"); </script>';
		}
	}
	
	function cek_cookie(){
		if(!empty($this->ci->input->cookie('adm_auth', TRUE))){
			$arr = array(
				'username' => $this->ci->input->cookie('adm_auth', TRUE)
			);
			$this->ci->session->set_userdata('adm_auth', $arr);
		}
	}
	
	function logged()
	{
		if(!empty($this->ci->session->userdata('adm_auth'))){
			echo '<script>window.location.replace("'.base_url().'"); </script>';
		}
	}
	
	function assign_session($data = array())
	{
		$this->ci->session->set_userdata('adm_auth', $data);
		return true;
	}
	
	function assign_cookie($data = array())
	{
		$arr_cookie = array(
			'name' => 'adm_auth',
			'value' => $data['username'],
			'expire' => '604800'
		);
		$this->ci->input->set_cookie($arr_cookie);
	}
	
	function logout()
	{
		$this->ci->session->sess_destroy();
		delete_cookie('adm_auth');
	}
}
?>