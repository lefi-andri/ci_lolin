<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	function antiinjection($data){
	    $filter_sql = stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES, 'UTF-8')));
	    return $filter_sql;
	}

?>