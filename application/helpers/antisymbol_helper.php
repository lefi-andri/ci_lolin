<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	function antisymbol($data) {
	    $symbol =  array("[","]","'","#",";");
	    $pengganti =array("","","","","");
	    $hasil_penggantian = str_replace($symbol, $pengganti, $data);
	    return $hasil_penggantian;
	}

?>