<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class M_chart extends CI_Model{

	function donuts($type)
	{
		$this->db->where('type', $type);
		return $this->db->get('user')->num_rows();
	}
	
	function area()
	{
		$date = date('Y-m', strtotime('-12 month', strtotime(date('Y-m'))));
		$dateFrom = $date.'-01';
		$dateNow = date('Y-m-d');
		$query = "SELECT YEAR(chart) AS y, MONTH(chart) AS m, SUM(type='hotspot') AS totalhotspot, SUM(type='ppp') AS totalppp FROM user WHERE (chart BETWEEN '$dateFrom' AND '$dateNow') GROUP BY YEAR(chart), MONTH(chart)";
		return $this->db->query($query)->result();
	}
}
?>