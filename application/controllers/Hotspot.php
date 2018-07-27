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
		$list_server = $this->m_mikrotik->select_api('/ip/hotspot/print');
		$user_profile = $this->m_mikrotik->select_api('/ip/hotspot/user/profile/print');
		foreach($user_hotspot as $userh){
            $user_sql = $this->m_mikrotik->get_user('hotspot', $userh['name'])->row_array();
            if($user_sql){
            	$userh['registered'] = date('d-m-Y', $user_sql['registered']);
            	$userh['expired'] = date('d-m-Y', $user_sql['expired']);
            }else{
            	$userh['registered'] = '00-00-0000';
            	$userh['expired'] = '00-00-0000';
            }
			if(!empty($userh['password'])){
				$passwd = $userh['password'];
			}else{
				$passwd = '';
			}
            if($userh['name'] != "default-trial"){
	            $data_sync[] = array(
	            	'.id' => $userh['.id'],
	            	'server' => $userh['server'],
	            	'name' => $userh['name'],
	            	'password' => $passwd,
	            	'registered' => $userh['registered'],
	            	'expired' => $userh['expired'],
	            	'profile' => $userh['profile'],
	            	'uptime' => $this->routersetting->formatDateTime($userh['uptime']),
	            	'disabled' => $userh['disabled']
	            );
	        }
        }
        $data = array(
        	'user_sync' => $data_sync,
			'list_server_hotspot' => $list_server,
			'list_user_profile' => $user_profile
        );
		$this->template->load('template', 'hotspot/users', $data);
	}
	
	function proses_edit()
	{
		if($this->input->post()){
			$dataPost = $this->input->post();
			$data_api = array(
				'.id' => $dataPost['id'],
				'server' => $dataPost['server'],
				'name' => $dataPost['user'],
				'password' => $dataPost['password'],
				'profile' => $dataPost['profile'],
				'disabled' => $dataPost['status']
			);
			$data_sql = array(
				'user' => $dataPost['user'],
				'type' => 'hotspot',
				'registered' => strtotime($dataPost['registered']),
				'expired' => strtotime($dataPost['expired']),
				'chart' => $dataPost['registered']
			);
			$this->m_mikrotik->edit_user_hotspot($data_sql);
			$result = $this->m_mikrotik->query_api('/ip/hotspot/user/set',$data_api);
			if($result === false){
				echo 'success';
			}else{
				echo $result;
			}
		}else{
			redirect(base_url('hotspot'));
		}
	}
	
	function proses_add()
	{
		if($this->input->post()){
			$dataPost = $this->input->post();
			$data_api = array(
				'server' => $dataPost['server'],
				'name' => $dataPost['user'],
				'password' => $dataPost['password'],
				'profile' => $dataPost['profile'],
				'disabled' => $dataPost['status']
			);
			$data_sql = array(
				'user' => $dataPost['user'],
				'type' => 'hotspot',
				'registered' => strtotime($dataPost['registered']),
				'expired' => strtotime($dataPost['expired']),
				'chart' => $dataPost['registered']
			);
			$this->m_mikrotik->syncronize($data_sql);
			$result = $this->m_mikrotik->query_api('/ip/hotspot/user/add',$data_api);
			if($result == true){
				echo 'success';
			}else{
				echo $result;
			}
		}else{
			redirect(base_url('hotspot'));
		}
	}
	
	function remove($id, $user){
		$this->m_mikrotik->query_api('/ip/hotspot/user/remove', array('.id' => urldecode($id)));
		$this->m_mikrotik->delete_user_hotspot(urldecode($user));
		redirect(base_url('hotspot'));
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
	
	function syncronize()
	{
		if($this->input->post()){
			$post = $this->input->post();
			$data = array(
				'user' => $post['user'],
				'type' => 'hotspot',
				'registered' => strtotime($post['registered']),
				'expired' => strtotime($post['expired']),
				'chart' => $post['registered']
			);
			$result = $this->m_mikrotik->syncronize($data);
			if($result){
				redirect($this->agent->referrer());
			}else{
				echo '<script>alert("Gagal"); window.location.replace("'.$this->agent->referrer().'");</script>';
			}
		}else{
			
		}
	}
}
?>
