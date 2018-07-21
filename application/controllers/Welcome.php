<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}
	public function index()
	{
		$this->auth->cek();
		$this->session->set_flashdata(array('title' => 'Dashboard', 'update' => 'TRUE'));
		$dataDashboard = array(
			'hotspot_count' => count($this->m_mikrotik->select_api('/ip/hotspot/user/print')) - 1,
			'ppp_count' => count($this->m_mikrotik->select_api('/ppp/secret/print')),
			'count_mountly' => $this->m_mikrotik->count_monthly(),
			'count_total' => (count($this->m_mikrotik->select_api('/ip/hotspot/user/print')) - 1) + count($this->m_mikrotik->select_api('/ppp/secret/print'))
		);
		$this->template->load('template', 'dashboard', $dataDashboard);
	}
	
	public function login()
	{
		$this->auth->logged();
		if($this->input->post()){
			$data_auth = array(
				'username' => $this->input->post('username'),
				'password' => MD5($this->input->post('password'))
			);
			$cek_db = $this->db->get_where('admin', $data_auth)->row_array();
			if($cek_db){
				$result = $this->auth->assign_session($cek_db);
				if($this->input->post('remember') == TRUE){
					$this->auth->assign_cookie($cek_db);
				}
				if($result==TRUE){
					echo 'success';
				}else{
					echo 'error';
				}
			}else{
				echo 'error';
			}
		}else{
			$this->session->set_flashdata('title', 'Login Administrator');
			$data = array(
				'type' => 'login'
			);
			$this->load->view('login', $data);
		}
	}
	
	public function logout()
	{
		$this->auth->logout();
		redirect(base_url('login'));
	}
	
	public function setup_admin()
	{
		if($this->routersetting->check_config() === FALSE){
			if($this->input->post()){
				$data_config[0] = array(
					'key' => 'MIKROTIK_HOST',
					'value' => $this->input->post('mikrotik_host')
				);
				$data_config[1] = array(
					'key' => 'MIKROTIK_USER',
					'value' => $this->input->post('mikrotik_user')
				);
				$data_config[2] = array(
					'key' => 'MIKROTIK_PASS',
					'value' => $this->input->post('mikrotik_pass')
				);
				$this->m_mikrotik->save_config($data_config);
				$data_admin = array(
					'username' => $this->input->post('username'),
					'password' => md5($this->input->post('password'))
				);
				if($this->m_mikrotik->save_admin($data_admin)){
					echo "success";
				}else{
					echo "error";
				}
			}else{
				$this->session->set_flashdata('title', 'Setup Administrator');
				$data = array(
					'type' => 'setup',
					'mikrotik_host' => $this->m_mikrotik->config('MIKROTIK_HOST'),
					'mikrotik_user' => $this->m_mikrotik->config('MIKROTIK_USER'),
					'mikrotik_pass' => $this->m_mikrotik->config('MIKROTIK_PASS'),
					'data_admin' => $this->m_mikrotik->check_admin()->row_array()
				);
				$this->load->view('login', $data);
			}
		}else{
			echo '<script>alert("Konfigurasi sudah di setting, silakan login"); window.location.replace("'.base_url().'"); </script>';
		}
	}
	
	public function check_mikrotik()
	{
		if($this->routersetting->check_config() === FALSE){
			$host = $this->input->post('mikrotik_host');
			$user = $this->input->post('mikrotik_user');
			$pass = $this->input->post('mikrotik_pass');
			if($this->routerosapi->connect($host, $user, $pass)){
				echo 'success';
			}else{
				echo 'error';
				die();
			}
		}else{
			echo '<script>alert("Konfigurasi sudah di setting, silakan login"); window.location.replace("'.base_url().'"); </script>';
		}
	}

	public function server()
	{
		$results = $this->m_mikrotik->select_api('/system/resource/print');
		$arr = array();
		foreach($results as $result){
			$freeHdd = number_format($result['free-hdd-space']/1024000, 2);
			$totaleHdd = number_format($result['total-hdd-space']/1024000, 2);
			$freeMemory = number_format($result['free-memory']/1024000, 2);
			$totalMemory = number_format($result['total-memory']/1024000, 2);
			$arr = array(
				'uptime' => $result['uptime'],
				'cpu_load' => $result['cpu-load'].'%',
				'cpu_count' => $result['cpu-count'],
				'cpu_frequency' => $result['cpu-frequency'],
				'cpu' => $result['cpu'],
				'free_hdd_space' => $freeHdd.' Mib',
				'total_hdd_space' => $totaleHdd.' Mib',
				'free_memory' => $freeMemory.' Mib',
				'total_memory' => $totalMemory.' Mib',
				'version' => $result['version']
			);
		}
		echo json_encode($arr);
	}
	
	//percobaan
	public function chart()
	{
		header("Content-type: application/x-javascript");
		$this->load->model('m_chart');
		$data = $this->m_chart->area();
		$arr = array();
		foreach($data as $row){
			if($row->m < 10){
				$bulan = '0'.$row->m;
			}else{
				$bulan = $row->m;
			}
			$date = $row->y.'-'.$bulan;
			$arr[] = array(
				'period' => date('Y-m', strtotime($date)),
				'hotspot' => $row->totalhotspot-0,
				'ppp' => $row->totalppp-0
			);
		}
		echo "$(function() {

    Morris.Area({
        element: 'morris-area-chart',
        data: ".json_encode(array_values($arr)).",
        xkey: 'period',
        ykeys: ['ppp', 'hotspot'],
        labels: ['PPP', 'Hotspot'],
        pointSize: 2,
        hideHover: 'auto',
        resize: true
    });

    Morris.Donut({
        element: 'morris-donut-chart',
        data: [{
            label: 'User PPP',
            value: ".$this->m_chart->donuts('ppp')."
        }, {
            label: 'User Hotspot',
            value: ".$this->m_chart->donuts('hotspot')."
        }],
        resize: true
    });
});";
	}	
}
?>