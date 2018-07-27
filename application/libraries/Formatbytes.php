<?php 

class Formatbytes
{

	function convert($size, $decimals = 2){
		$unit = array(
		'0' => 'Byte',
		'1' => 'KiB',
		'2' => 'MiB',
		'3' => 'GiB',
		'4' => 'TiB',
		'5' => 'PiB',
		'6' => 'EiB',
		'7' => 'ZiB',
		'8' => 'YiB'
		);
		
		for($i = 0; $size >= 1024 && $i <= count($unit); $i++){
			$size = $size/1024;
		}
	
		return round($size, $decimals).' '.$unit[$i];
	}
}
?>