<?php

class Hotspot extends CI_Controller{

	function __construct(){
		parent::__construct();
	}

	function index(){
		$this->auth->cek();
		$this->session->set_flashdata('title', 'User Hotspot');

		//Sync SQL AND Mikrotik
		$data_sync = array();
		$user_hotspot = $this->m_mikrotik->select_api('/ip/hotspot/user/print');
		foreach($user_hotspot as $userh){
            $user_sql = $this->m_mikrotik->get_user('hotspot', $userh['name'])->row_array();
            if($user_sql){
            	$userh['registered'] = date('d-m-Y', $user_sql['registered']);
            	$userh['expired'] = date('d-m-Y', $user_sql['expired']);
            }else{
            	$userh['registered'] = '00-00-0000';
            	$userh['expired'] = '00-00-0000';
            }
            if($userh['name'] != "default-trial"){
	            $data_sync[] = array(
	            	'.id' => $userh['.id'],
	            	'server' => $userh['server'],
	            	'name' => $userh['name'],
	            	'password' => $userh['password'],
	            	'registered' => $userh['registered'],
	            	'expired' => $userh['expired'],
	            	'profile' => $userh['profile'],
	            	'uptime' => $userh['uptime'],
	            	'disabled' => $userh['disabled']
	            );
	        }
        }
        $data = array(
        	'user_sync' => $data_sync
        );
		$this->template->load('template', 'hotspot/users', $data);
	}

	function disableakun(){
		if($this->input->post()){
			$data_api = array(
				'.id' => $this->input->post('id'),
				'disabled' => 'true'
			);
			
			$result = $this->m_mikrotik->query_api('/ip/hotspot/user/set', $data_api);
			if($result === false){
				echo 'success';
			}else{
				echo $result;
			}
		}else{
			redirect(base_url());
		}
	}

	function date($a){
		echo strtotime($a);
	}
}
?>